<?php

  namespace halo16;

  class PluginController{

    protected static $instance = null;

    protected $version = '1.0.0';

    protected $factory;

    protected $controllers_path;

    protected $languages_path;

    protected $models_path;

    protected $views_path;

    protected $plugin_config_controllers;

    protected $frontend_views;

    protected $widget_controllers;

    protected $shortcode_controllers;

    protected $plugin_url;

    protected $plugin_option;

    private function __construct() { }

    public static function getInstance($class_name, $args){
      if (null == self::$instance) {
          self::$instance = new self();
          self::$instance->init($args);
      }
      return self::$instance;
    }

    public function init($args) {
      $this->setProperty('factory', $args['factory-instance']);
      $this->setProperty('controllers_path', $args['controllers_path']);
      $this->setProperty('models_path', $args['models_path']);
      $this->setProperty('views_path', $args['views_path']);
      $this->setProperty('languages_path', $args['languages_path']);
      $this->setProperty('plugin_url', $args['plugin_url']);
      $this->setProperty('plugin_option', get_option('halo16-plugin-config-option'));

      $plugin_config_controllers = array(
          'halo16-plugin-config' => null,
      );
      $this->setProperty('plugin_config_controllers', $plugin_config_controllers);

      $widget_controllers = array(
        'halo16-widget' => null,
      );
      $this->setProperty('widget_controllers', $widget_controllers);

      $shortcode_controllers = array(
        'halo16-shortcode' => null,
      );
      $this->setProperty('shortcode_controllers', $shortcode_controllers);

      $frontend_views = array(

      );
      $this->setProperty('frontend_views', $frontend_views);
      add_action('init', array($this, 'pluginInit'));
      add_action('init', array($this, 'registerShortcodes'));
      add_action('widgets_init', array($this, 'registerWidgets'));
    }



  public function pluginInit(){
      $domain = 'Halo16';
      $locale = apply_filters('plugin_locale', get_locale(), $domain);

      load_textdomain($domain, WP_LANG_DIR.'/'.$domain.'/'.$domain.'-'.$locale.'.mo');
      load_plugin_textdomain($domain, false, dirname(plugin_basename(__FILE__)).'/../lang/');

      add_filter( 'the_content', array($this, 'contentFilterHalo16'), 9);

      if (is_admin()) {
        $this->initPluginConfigControllers();
        add_action('admin_menu', array($this, 'addPluginAdminMenu'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminStyles'));
        add_action('admin_enqueue_scripts', array($this, 'enqueueAdminScripts'));
        add_action('save_post', array($this, 'savePost'));
      } else {
        $this->initFrontendViews();
        add_action('wp_enqueue_scripts', array($this, 'enqueueStyles'));
        add_action('wp_enqueue_scripts', array($this, 'enqueueScripts'));
      }

    }

    public function  contentFilterHalo16($content){
        return $content;
    }

    public function registerWidgets(){
      if (!empty($this->widget_controllers)) {
        foreach ($this->widget_controllers as $key => $object) {
          register_widget($this->factory->loadWidgetClasses($key));
        }
      }
    }

    public function registerShortcodes(){
      if (!empty($this->shortcode_controllers)) {
        foreach ($this->shortcode_controllers as $key => $object) {
          $this->factory->loadShortcodeClasses($key);
          add_shortcode('halo16', array($this,'halo16_shortcode'));
        }
      }
    }

    public function savePost($post_id){}

    public function enqueueAdminStyles($hook){
      wp_enqueue_style('halo16-config-css', $this->getProperty('plugin_url').'assets/css/halo16-config.css',array( 'wp-color-picker' ),null, 'screen');
    }

    public function enqueueAdminScripts($hook){
      wp_enqueue_script( 'halo16-config-js', $this->getProperty('plugin_url').'assets/js/halo16-config.js', array( 'wp-color-picker' ), null, true );
    }

    public function enqueueStyles(){
        wp_enqueue_style('halo16-plugin-css', $this->getProperty('plugin_url').'assets/css/halo16-plugin.css',array(),null,'screen');
        if ($this->plugin_option['ignore_css']!=1) {
            wp_enqueue_style('halo16-widget-css', $this->getProperty('plugin_url').'assets/css/halo16_widget.css',array(),null,'screen');
        }
    }

    public function enqueueScripts(){
      wp_enqueue_script('halo16-plugin-js', $this->getProperty('plugin_url').'assets/js/halo16-plugin.js',array('jquery'),null,true);
      if ($this->plugin_option['ignore_js']!=1) {
          wp_enqueue_script( 'wow-js', $this->getProperty('plugin_url').'bower_components/wowjs/dist/wow.min.js', array('jquery'),null,true );
          wp_enqueue_script('halo16-widget-js', $this->getProperty('plugin_url').'assets/js/halo16-widget.js', array('jquery'),null,true);
      }
    }

    public function addPluginAdminMenu(){
      foreach ($this->plugin_config_controllers as $key => $object) {
        if (!is_null($object)) {
          $object->import();
          $object->setName();
          $object->setSections();
          $object->setFields();
          $object->registerSetting();
          $object->addSettingsSection();
          $object->addSettingsField();
          $object->addMenuPage();
          $object->enqueueCss();
          $object->enqueueJs();
        }
      }
    }

    private function getProperty($name){
      if (property_exists(get_class($this), $name)){
        return $this->$name;
      }
      return null;
    }

    private function setProperty($name, $value){
      if (property_exists(get_class($this), $name)) {
        $this->$name = $value;
        return true;
      }
      return false;
    }

    private function initPluginConfigControllers(){
      foreach ($this->plugin_config_controllers as $key => $object) {
        if (!is_null($object)) {
          continue;
        }
        $model_args = array(
            'option_name' => generateOptionName($key),
            'page_name' => $key,
        );

        $model = $this->factory->createModel('plugin-config', $key, $model_args);
        $view = $this->factory->createView('plugin-config', $key);
        $plugin_config_controller = $this->factory->createController('plugin-config', $key, array('model' => $model, 'view' => $view));
        if (is_wp_error($plugin_config_controller)) {
            echo $plugin_config_controller->get_error_message();
            return;
        }
        $this->plugin_config_controllers[$key] = $plugin_config_controller;
      }
    }

    private function initFrontendViews(){
      foreach ($this->frontend_views as $key => $object) {
        if (is_null($object)) {
          $this->frontend_views[$key] = $this->factory->createView('widget-frontend', $key);
        }
      }
    }

    protected function cleanArray($array, $to_delete){
      if (is_array($to_delete)) {
        foreach ($to_delete as $element) {
          unset($array[$element]);
        }
      } else {
        unset($array, $to_delete);
      }
      return $array;
    }
  }
