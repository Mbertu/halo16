<?php

  namespace halo16;

  class Factory implements IFactory {

      private static $instance;

      private $controllers_path;

      private $models_path;

      private $views_path;

      private $languages_path;

      private $abstract_subfix;

      private $plugin_url;

      private $controller_categories = array('plugin', 'plugin-config', 'widget', 'shortcode');

      private $model_categories = array('plugin-config', 'widget');

      private $view_categories = array('plugin-config', 'frontend', 'widget-frontend', 'widget-config');

      public function __construct() {}

      public static function getInstance($args = null) {
        if (!isset(self::$instance)){
            self::$instance = new self;
            self::$instance->init($args);
        }
        return self::$instance;
      }

      public function init($args){
          $this->setProperty('controllers_path', $args['controllers_path']);
          $this->setProperty('models_path', $args['models_path']);
          $this->setProperty('views_path', $args['views_path']);
          $this->setProperty('languages_path', $args['languages_path']);
          $this->setProperty('plugin_url', $args['plugin_url']);
          $this->setProperty('abstract_subfix', 'abstracts/');
          return;
      }

      public function createController($category, $page, $args = null){
          if(!in_array($category, $this->controller_categories)){
              return new WP_Error( 'wrong_controller_name', __( "Wrong controller name.", 'Halo16' ).' '.$category.'.');
          }

          $class_name = generateClassName($page, 'controller');
          $file_name = generateFilename($page, 'controller');

          if($category == "plugin"){
              if(is_null($args))
                  $args = array();
              $args['factory-instance'] = $this;
              $args['controllers_path'] = $this->getProperty('controllers_path');
              $args['models_path']      = $this->getProperty('models_path');
              $args['views_path']       = $this->getProperty('views_path');
              $args['languages_path']   = $this->getProperty('languages_path');
              $args['plugin_url']       = $this->getProperty('plugin_url');
          }else{
              if(!class_exists('AbstractController')){
                  require_once($this->controllers_path . $this->abstract_subfix . "abstract-controller.php");
              }
          }

          if($category == "plugin-config"){
              if(!class_exists('AbstractPluginConfigController'))
                  require_once($this->controllers_path . $this->abstract_subfix . "abstract-plugin-config-controller.php");
          }

          if($category == "widget"){
              if(!class_exists('AbstractWidgetController'))
                  require_once($this->controllers_path . $this->abstract_subfix . "abstract-widget-controller.php");
          }

          if($category == "shortcode"){
              if(!class_exists('AbstractShortcodeController'))
                  require_once($this->controllers_path . $this->abstract_subfix . "abstract-shortcode-controller.php");
          }

          if(!class_exists($class_name))
              require_once($this->controllers_path . $file_name);
          return $class_name::getInstance($class_name, $args);
      }


      public function createModel($category, $page, $args = null){
          if(!in_array($category, $this->model_categories)){
              return new \WP_Error( 'wrong_model_name', __( 'Wrong model name.', 'halo16' ).' '.$category.'.');
          }

          $class_name = generateClassName($page, 'model');
          $file_name = generateFilename($page, 'model');

          if(!class_exists('AbstractModel')){
              require_once($this->models_path . $this->abstract_subfix . "abstract-model.php");
          }

          if($category == "plugin-config"){
              if(!class_exists('AbstractPluginConfigModel'))
                  require_once($this->models_path . $this->abstract_subfix . "abstract-plugin-config-model.php");
          }

          if($category == "widget"){
              if(!class_exists('AbstractWidgetModel'))
                  require_once($this->models_path . $this->abstract_subfix . "abstract-widget-model.php");
          }

          if(!class_exists($class_name))
              require_once($this->models_path . $file_name);


          return $class_name::getInstance($class_name, $args);
      }


      public function createView($category, $page, $args = null){
          if(!in_array($category, $this->view_categories)){
              return new \WP_Error( 'wrong_view_name', __( 'Wrong view name.', 'halo16' ).' '.$category.'.');
          }

          $class_name = generateClassName($page, 'view');
          $file_name = generateFilename($page, 'view');

          if(!class_exists('AbstractView')){
              require_once($this->views_path . $this->abstract_subfix . "abstract-view.php");
          }

          if($category == "plugin-config"){
              if(!class_exists('AbstractPluginConfigView'))
                  require_once($this->views_path . $this->abstract_subfix . "abstract-plugin-config-view.php");
          }

          if($category == "frontend"){
              if(!class_exists('AbstractFrontendView'))
                  require_once($this->views_path . $this->abstract_subfix. "abstract-frontend-view.php");
          }

          if($category == "widget-frontend"){
              if(!class_exists('AbstractWidgetFrontendView'))
                  require_once($this->views_path . $this->abstract_subfix . "abstract-widget-frontend-view.php");
          }

          if($category == "widget-config"){
              if(!class_exists('AbstractWidgetConfigView'))
                  require_once($this->views_path . $this->abstract_subfix. "abstract-widget-config-view.php");
          }

          if(!class_exists($class_name))
              require_once($this->views_path . $file_name);
          return $class_name::getInstance($class_name, $args);
      }

      public function loadWidgetClasses($page, $args = null){
        $class_name = generateClassName($page, 'controller');
        $file_name = generateFilename($page, 'controller');

        if(!class_exists('AbstractWidgetController'))
            require_once($this->controllers_path . $this->abstract_subfix . "abstract-widget-controller.php");

       if(!class_exists($class_name))
             require_once($this->controllers_path . $file_name);

         return $class_name;
      }

      public function loadShortcodeClasses($page, $args = null){
        $class_name = generateClassName($page, 'controller');
        $file_name = generateFilename($page, 'controller');

        if(!class_exists('AbstractController')){
            require_once($this->controllers_path . $this->abstract_subfix . "abstract-controller.php");
        }

        if(!class_exists('AbstractShortcodeController'))
            require_once($this->controllers_path . $this->abstract_subfix . "abstract-shortcode-controller.php");

        if(!class_exists($class_name))
            require_once($this->controllers_path . $file_name);

         return $class_name;
      }


      public function getProperty($name){
          if(property_exists(get_class($this), $name)){
              return $this->$name;
          }
          return null;
      }

      public function setProperty($name, $value){
          if(property_exists(get_class($this), $name)){
              $this->$name = $value;
              return true;
          }
          return false;
      }
  }
