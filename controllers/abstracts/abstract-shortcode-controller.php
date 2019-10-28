<?php

  namespace halo16;

  abstract class AbstractShortcodeController extends AbstractController{

    protected $parameters = array();

    protected function init($args){
      $this->setProperty('model', isset($args['model']) ? $args['model'] : null);
      $this->setProperty('view', isset($args['view']) ? $args['view'] : null);
      $this->setProperty('plugin_url', isset($args['plugin_url']) ? $args['plugin_url'] : plugins_url().'/halo16/');
      $this->setProperty('sections', isset($args['sections']) ? $args['sections'] : null);
      $this->setProperty('fields', isset($args['fields']) ? $args['fields'] : null);
      $this->setProperty('menu_label', isset($args['menu_label']) ? $args['menu_label'] : null);
    }

    protected function getParameters(){

    }

  }
