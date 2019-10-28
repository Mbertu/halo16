<?php

  namespace halo16;

  abstract class AbstractModel{

    private static $instance = array();

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

    public function import($args){

        $default_values = $this->defaults;

        if(property_exists(get_class($this), 'child_defaults')){
            $default_values = $this->arrayMerge($this->child_defaults, $default_values);
        }

        if(isset($args) && !empty($args))
            $filtered = $this->arrayMerge( $args, $default_values );
        else
            $filtered = $default_values;

        foreach ($filtered as $key => $value) {
            $this->setProperty($key, $value);
        }
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

    public function arrayMerge($array1, $array2){
        $new_array = array();
        foreach($array1 as $key => $value){
          if(!empty($value) || is_bool($value)){
            $new_array[$key] = $value;
            continue;
          }
          if(isset($array2[$key]) && !empty($array2[$key])){
            $new_array[$key] = $array2[$key];
            continue;
          }
          $new_array[$key] = null;
        }
        foreach($array2 as $key => $value){
          if(isset($new_array[$key])){
            continue;
          }
          if(!empty($value) || is_bool($value)){
            $new_array[$key] = $value;
            continue;
          }
          $new_array[$key] = null;
        }
        return $new_array;
    }

		protected abstract function init($args);

		protected abstract function toArray();
  }
