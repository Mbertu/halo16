<?php

  namespace halo16;

  abstract class AbstractView{

    protected $plugin_url;

    protected function __construct() {}

    public static function getInstance($className, $args) {
      if (!function_exists('get_called_class')) {
          $c = $className;
      }else{
          $c = get_called_class();
      }
      $instance = new $c();
      $instance->init($args);
      return $instance;
    }

    protected abstract function init($args);

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

    public function renderColorPicker($args){
      $id = $args['id'];
      $name = $args['name'];
      $value = $args['value'];
      $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
      $enabled = isset($args['enabled']) ? $args['enabled'] : true;
      $message = isset($args['message']) ? $args['message'] : false;
      $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

      $output = "<div class='".$id."_container  cp halo16_input_container";
      foreach ($extra_classes as $class) {
          $output .= ' '.$class;
      }
      $output.= "'>";

      if(!empty($label)){
          $output .= "<label for='".$name."[".$id."]'>".$label."</label><br/>";
      }

      $output .= "<input id='".$id."' class='color_picker' type='text' name='".$name."[".$id."]' value='".$value."' ";

      if(!$enabled)
          $output .= "disabled ";

      $output .= "/>";

      if($message)
          $output .= "<p class='description'>".$message."</p>";

      $output .= "</div>";
      echo $output;

    }

    public function renderInput($args){
      $id = $args['id'];
      $name = $args['name'];
      $value = $args['value'];
      $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
      $enabled = isset($args['enabled']) ? $args['enabled'] : true;
      $message = isset($args['message']) ? $args['message'] : false;
      $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

      $output = "<div class='".$id."_container halo16_input_container";
      foreach ($extra_classes as $class) {
          $output .= ' '.$class;
      }
      $output.= "'>";

      if(!empty($label)){
          $output .= "<label for='".$name."[".$id."]'>".$label."</label><br/>";
      }

      $output .= "<input id='".$id."' type='text' name='".$name."[".$id."]' value='".$value."' ";

      if(!$enabled)
          $output .= "disabled ";

      $output .= "/>";

      if($message)
          $output .= "<p class='description'>".$message."</p>";

      $output .= "</div>";
      echo $output;
    }


    public function renderHidden($args){
      $id = $args['id'];
      $name = $args['name'];
      $value = $args['value'];

      $output = "<input id='".$id."' type='hidden' name='".$name."[".$id."]' value='".$value."' />";
      echo $output;
    }


    public function renderCheckbox($args) {
      $id = $args['id'];
      $name = $args['name'];
      $checked = $args['checked'];
      $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
      $enabled = isset($args['enabled']) ? $args['enabled'] : true;
      $message = isset($args['message']) ? $args['message'] : false;
      $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

      $output = "<div class='".$id."_container halo16_input_container";
      foreach ($extra_classes as $class) {
          $output .= ' '.$class;
      }
      $output.= "'>";

      $output .= "<input id='".$id."' name='".$name."[".$id."]' type='checkbox' value='true' ";
      if($checked)
          $output .= "checked='checked' ";
      if(!$enabled)
          $output .= "disabled ";
      $output .= "/>";
      if(!empty($label)){
          $output .= "<label for='".$name."[".$id."]'>".$label."</label>";
      }
      if($message)
          $output .= "<p class='description'>".$message."</p>";

      $output .= "</div>";
      echo $output;
    }


    public function renderRadio($args) {
      $id = $args['id'];
      $name = $args['name'];
      $elements = $args['elements'];
      $enabled = isset($args['enabled']) ? $args['enabled'] : true;
      $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

      $output = "<div class='".$id."_container halo16_input_container";
      foreach ($extra_classes as $class) {
          $output .= ' '.$class;
      }
      $output.= "'>";

      foreach($elements as $element){
          $output .= "<p><label><input type='radio' name='".$name."[".$id."]' value='".$element['value']."' class='tog ".$id."' ";
          if($element['checked'])
              $output .= "checked='checked' ";
          if(!$enabled)
              $output .= "disabled ";
          $output .= "/>".$element['label']."</label></p>";
      }
      $output .= "</div>";
      echo $output;
    }


    public function renderSelect($args) {
      $id = $args['id'];
      $name = $args['name'];
      $elements = $args['elements'];
      $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
      $enabled = isset($args['enabled']) ? $args['enabled'] : true;
      $message = isset($args['message']) ? $args['message'] : false;
      $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

      $output = "<p>";

      if(!empty($label)){
          $output .= "<label for='".$id."'>".$label."</label>";
      }

      $output .= "<select id='".$id."' name='".$name."[".$id."]' ";
      if(!$enabled)
          $output .= "disabled ";
      $output .= ">";
      foreach($elements as $element){
          $output .= "<option value='".$element['value']."'";
          if($element['current'])
              $output .= "selected";
          $output .= ">".$element['label']."</option>";
      }
      $output .= "</select>";

      if($message)
          $output .= "<p class='description'>".$message."</p>";

      $output .= "</p>";
      echo $output;
    }


    public function renderButton($args) {
      $id = $args['id'];
      $name = $args['name'];
      $message = isset($args['message']) ? $args['message'] : false;

      $output = "<a id='".$id."'class='".$args['button_classes']."' href='#'>".$name."</a>";
      if($message)
          $output .= "<p class='description'>".$message."</p>";
      echo $output;
    }


    public function renderInputFile($args){
      $id = $args['id'];
      $name = $args['name'];
      $current = $args['current'];
      $delete_button_text = isset($args['delete_button_text']) ? $args['delete_button_text'] : 'Delete';

      $output = '';

      if($current) {
        $output .= $current;
        $output .= '<input id="no_image_reset" type="submit" name="reset-no_image_reset" id="reset-no_image_reset" class="button button-primary" value="'.$delete_button_text.'"> <br/>';
      }

      $output .= "<input id='".$id."' type='file' name='".$id."' />";

      echo $output;
    }

    public function renderNumber($args){
      $id = $args['id'];
      $name = $args['name'];
      $value = $args['value'];
      $min = (isset($args['min'])) ? $args['min'] : '';
      $max = (isset($args['max'])) ? $args['max'] : '';
      $step = (isset($args['step']) && !empty($args['step'])) ? $args['step'] : '';
      $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
      $enabled = isset($args['enabled']) ? $args['enabled'] : true;
      $message = isset($args['message']) ? $args['message'] : false;
      $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

      $output = "<div class='".$id."_container halo16_input_container";
      foreach ($extra_classes as $class) {
          $output .= ' '.$class;
      }
      $output.= "'>";

      if(!empty($label)){
          $output .= "<label for='".$name."[".$id."]'>".$label."</label><br/>";
      }

      $output .= "<input id='".$id."' type='number' min='".$min."' max='".$max."' step='".$step."' name='".$name."[".$id."]' value='".$value."' ";

      if(!$enabled)
          $output .= "disabled ";

      $output .= "/>";

      if($message)
          $output .= "<p class='description'>".$message."</p>";

      $output .= "</div>";
      echo $output;
    }

    public abstract function render($args=null);
  }
