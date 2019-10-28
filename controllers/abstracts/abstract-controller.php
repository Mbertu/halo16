<?php

	namespace halo16;

	abstract class AbstractController{

		private static $instance = array();

		protected $model;

	  protected $plugin_url;

	  protected $view;

	  protected function __construct() {}

	  public static function getInstance($className, $args) {
	      if (!function_exists('get_called_class')) {
	          $c = $className;
	      }else{
	          $c = get_called_class();
	      }
	      if ( !isset( self::$instance[$c] ) ) {
	          self::$instance[$c] = new $c();
	          self::$instance[$c]->init($args);
	      }
	      return self::$instance[$c];
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

	  protected function stringToBool($string) {
	      return $string == 'true' ? true : false;
	  }

	  protected function validateInputFromArray($value, $array) {
	      return in_array($value, $array);
	  }

	  protected function validateInteger($number){
	      return is_int($number);
	  }

	  protected function validateInputWithRegex($regex, $input){
	      if(!preg_match($regex, $input)){
	          return false;
	      }
	      return true;
	  }


		protected abstract function init($args);

	}
