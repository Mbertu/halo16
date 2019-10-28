<?php

  namespace halo16;

  abstract class AbstractPluginConfigController extends AbstractController{

    protected $sections = array();

    protected $fields = array();

    protected $menu_label;

    protected function init($args){
      $this->setProperty('model', isset($args['model']) ? $args['model'] : null);
      $this->setProperty('view', isset($args['view']) ? $args['view'] : null);
      $this->setProperty('plugin_url', isset($args['plugin_url']) ? $args['plugin_url'] : plugins_url().'/halo16/');
      $this->setProperty('sections', isset($args['sections']) ? $args['sections'] : null);
      $this->setProperty('fields', isset($args['fields']) ? $args['fields'] : null);
      $this->setProperty('menu_label', isset($args['menu_label']) ? $args['menu_label'] : null);
    }

    public function addMenuPage(){
    	add_menu_page(  $this->getProperty('menu_label'),
                      $this->getProperty('menu_label'),
                      'manage_options',
                      $this->getProperty('model')->getProperty('page_name'),
                      array( $this, "renderView" ) );
    }

    public function registerSetting(){
        register_setting( $this->getProperty('model')->getProperty('page_name'),
                          $this->getProperty('model')->getProperty('option_name'),
                          array($this, 'validateInput'));
    }

    public function addSettingsSection() {
        foreach($this->getProperty('sections') as $section){
            add_settings_section(
                $section['name'],
                $section['label'],
                null,
                $this->getProperty('model')->getProperty('page_name')
            );
        }
    }

    public function addSettingsField(){
        foreach($this->getProperty('fields') as $field){
            add_settings_field(
                $field['id'],
                $field['label'],
                $field['callback'],
                $this->getProperty('model')->getProperty('page_name'),
                $field['section_name'],
                $field['id']
            );
        }
    }

    public abstract function renderView();

    public abstract function enqueueCss();

    public abstract function enqueueJs();

    public abstract function validateInput($args);
  }
