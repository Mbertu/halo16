<?php

  namespace halo16;

  function getPluginNamespace(){
      return "halo16\\";
  }

  function getPluginPrefix(){
      return "halo16-";
  }

  /**
   * Transform dashed word to cammel case
   * @since  1.0.0
   */
  function dashesToCamelCase($string, $capitalizeFirstCharacter = true){

      $str = str_replace(' ', '', ucwords(str_replace('-', ' ', $string)));

      if (!$capitalizeFirstCharacter) {
          $str[0] = strtolower($str[0]);
      }

      return $str;
  }

  /**
   * Generate the option name from pagename
   * @since 1.0.0
   */
  function generateOptionName($page){
      return $page.'-option';
  }

  /**
   * Generate the name
   * @since  1.0.0
   */
  function generateName($page,$type){
      $name = $page.'-'.$type;

      return $name;
  }

  /**
   * Generate the class name
   * @since  1.0.0
   */
  function generateClassName($page, $type){
      $className = getPluginNamespace().dashesToCamelCase(generateName($page, $type));

      return $className;
  }

  /**
   * Generate the filename for the controller
   * @since  1.0.0
   */
  function generateFilename($page, $type){
      $fileName = generateName($page, $type).'.php';
      return $fileName;
  }
