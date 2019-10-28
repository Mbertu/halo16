<?php

  namespace halo16;

  abstract class AbstractWidgetConfigView extends AbstractView{

    protected function init($args){
      $this->setProperty('plugin_url', plugins_url( '../../', __FILE__ ));
    }

  	public function render($args=null){
      return;
    }

    public function renderUpload($args){
      $id = $args['id'];
      $name = $args['name'];
      $value = $args['value'];
      $label = (isset($args['label']) && !empty($args['label'])) ? $args['label'] : '';
      $enabled = isset($args['enabled']) ? $args['enabled'] : true;
      $message = isset($args['message']) ? $args['message'] : false;
      $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

      $output = "<p>";

      if(!empty($label)){
          $output .= "<label for='".$name."'>".$label."</label>";
      }


     $output .= "<input  ' id='".$id."' type='text'  value='".$value."' class='widefat upload_path ";
     foreach ($extra_classes as $class) {
         $output .= ' '.$class;
     }

     $output .= "' name='".$name."' ";

     if(!$enabled)
         $output .= "disabled ";
     $output .= ">";

     $output .= "<input  type='image' src='".$value."' value='' width='100px' height='100px' class='upload'>";

     $output .= "<a href='#' class='clear_upload fa fa-remove'></a>";

      //$output .= "<input type='button' name='upload-btn' id='upload-btn' class='button-secondary' value='Upload'>";


      if($message)
          $output .= "<p class='description'>".$message."</p>";

      $output .= "</p>";
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

      $output = "<p>";

      if(!empty($label)){
          $output .= "<label for='".$name."'>".$label."</label>";
      }

      $output .= "<input id='".$id."' type='text' value='".$value."' class='widefat";

      foreach ($extra_classes as $class) {
          $output .= ' '.$class;
      }

      $output .= "' name='".$name."' ";

      if(!$enabled)
          $output .= "disabled ";
      $output .= ">";


      if($message)
          $output .= "<p class='description'>".$message."</p>";

      $output .= "</p>";
      echo $output;
    }


    public function renderHidden($args){
      $id = $args['id'];
      $name = $args['name'];
      $value = $args['value'];

      $output = "<input id='".$id."' type='hidden' name='".$name."' value='".$value."' />";
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

      $output = "<p>";

      $classes = '';
      foreach ($extra_classes as $class) {
          $classes .= ' '.$class;
      }

      $output .= "<input id='".$id."' name='".$name."' type='checkbox' value='true' class='widefat".$classes."' ";
      if($checked)
          $output .= "checked='checked' ";
      if(!$enabled)
          $output .= "disabled ";
      $output .= "/>";
      if(!empty($label)){
          $output .= "<label for='".$name."'>".$label."</label>";
      }
      if($message)
          $output .= "<p class='description'>".$message."</p>";

      $output .= "</p>";
      echo $output;
    }

    public function renderRadio($args) {
      $id = $args['id'];
      $name = $args['name'];
      $elements = $args['elements'];
      $enabled = isset($args['enabled']) ? $args['enabled'] : true;
      $extra_classes = isset($args['extra_classes']) ? $args['extra_classes'] : array();

      $output = "<p>";

      foreach($elements as $element){
          $output .= "<p><label><input type='radio' name='".$name."' value='".$element['value']."' class='tog ".$id."' ";
          if($element['checked'])
              $output .= "checked='checked' ";
          if(!$enabled)
              $output .= "disabled ";
          $output .= "/>".$element['label']."</label></p>";
      }
      $output .= "</p>";
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

      $output .= "<select id='".$id."' class='widefat";
      foreach ($extra_classes as $class) {
          $output .= ' '.$class;
      }
      $output .= "' name='".$name."' ";

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

    public function renderSeparator(){
      echo '<p style="border-bottom:1px dashed black;"></p>';
    }
  }
