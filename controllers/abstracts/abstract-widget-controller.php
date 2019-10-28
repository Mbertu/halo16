<?php

  namespace halo16;

  abstract class AbstractWidgetController extends \WP_Widget{

    protected $widget_model;

    protected $frontend_view;

    protected $admin_view;

    protected $factory;

    protected $plugin_option;

    public function __construct($id, $name, $args) {
        parent::__construct($id, $name, $args);
        $this->setProperty('factory', Factory::getInstance(null));
        $this->setProperty('plugin_option', get_option('halo16-plugin-config-option'));
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

    protected function cleanArray($array, $to_delete){
        if(is_array($to_delete)){
            foreach($to_delete as $element){
                unset($array[$element]);
            }
        }else{
            unset($array, $to_delete);
        }
        return $array;
    }

    protected function getProperty($name){
        if(property_exists(get_class($this), $name)){
            return $this->$name;
        }
        return null;
    }

    protected function setProperty($name, $value){
        if(property_exists(get_class($this), $name)){
            $this->$name = $value;
            return true;
        }
        return false;
    }

    protected function getPageContent($post_content)
    {
        if(strpos($post_content,'<!--more-->')) {
            return apply_filters('the_content',get_extended($post_content)['main']);
        }
        if($this->plugin_option['words_to_show']!=0){
            return wp_trim_words($post_content, $this->plugin_option['words_to_show'], '...' );
        } else {
            return apply_filters('the_content',$post_content);
        }
    }

    protected function getPageImage($ID){
        if(has_post_thumbnail($ID))
            return get_the_post_thumbnail($ID,$this->plugin_option['image_size']);
        if(!empty(wp_get_attachment_image($this->plugin_option['no_image'])))
            return wp_get_attachment_image($this->plugin_option['no_image'],$this->plugin_option['image_size']);
        else
            return '';
    }


    public function renderFrontend($args){
      $this->getProperty('frontend_view')->render($args);
    }
  }
