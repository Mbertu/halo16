<?php

  namespace halo16;

  abstract class AbstractPluginConfigModel extends AbstractModel{

    protected $page_name;

    protected $option_name;

  	protected function init($args){
  		$this->setProperty('option_name', isset($args['option_name']) ? $args['option_name'] : null );
  		$this->setProperty('page_name', isset($args['page_name']) ? $args['page_name'] : null );
  		$this->import($this->getProperty('defaults'));
  	}
  }
