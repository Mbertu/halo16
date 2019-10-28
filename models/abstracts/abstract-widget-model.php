<?php

	namespace halo16;

	abstract class AbstractWidgetModel extends AbstractModel{

		protected $version;

		protected function init($args){
				$this->setProperty('version', isset($args['version']) ? $args['version'] : null );
				$this->import($this->getProperty('defaults'));
		}
	}
