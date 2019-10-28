<?php

  namespace halo16;

  abstract class AbstractPluginConfigView extends AbstractView{

    protected function init($args){
    	$this->setProperty('plugin_url', isset($args['plugin_url']) ? $args['plugin_url'] : null);
    }
  }
