<?php

  namespace halo16;

  abstract class AbstractWidgetFrontendView extends AbstractView{

    protected function init($args){
    	$this->setProperty('plugin_url', plugins_url( '../../', __FILE__ ));
    }

  	public function render($args=null){
      return;
    }
  }
