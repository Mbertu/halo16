<?php

  namespace halo16;

  class Halo16PluginConfigController extends AbstractPluginConfigController {

    public function setSections(){
      $sections = array();
      $page_name = $this->getProperty('model')->getProperty('page_name');

      $sections[] = array('name' => $page_name.'_content_section', 'label' => __('Content and images configuration', 'Halo16'));



      $sections[] = array('name' => $page_name.'_ignore_assets', 'label' => __('Ignore CSS / JS', 'Halo16'));
      $sections[] = array('name' => $page_name.'_style1', 'label' => __('Style 1', 'Halo16'));
      $sections[] = array('name' => $page_name.'_style2', 'label' => __('Style 2', 'Halo16'));
      $sections[] = array('name' => $page_name.'_style3', 'label' => __('Style 3', 'Halo16'));
      $sections[] = array('name' => $page_name.'_style3', 'label' => __('Style 3', 'Halo16'));
      $sections[] = array('name' => $page_name.'_more_pages', 'label' => __('More Pages', 'Halo16'));
      $this->setProperty('sections',$sections);
    }

    public function setFields(){
      $fields = array();
      $page_name = $this->getProperty('model')->getProperty('page_name');

      $fields[] = array('id' => 'imageSize', 'label' => __('Choose the image size.', 'Halo16'), 'callback' => array($this, 'selectImageSize'), 'section_name' => $page_name.'_content_section');
      $fields[] = array('id' => 'noImage', 'label' => __('Upload the no image.', 'Halo16'), 'callback' => array($this, 'inputNoImage'), 'section_name' => $page_name.'_content_section');
      $fields[] = array('id' => 'wordsToShow', 'label' => __('Words to show.', 'Halo16'), 'callback' => array($this, 'inputTrimContent'), 'section_name' => $page_name.'_content_section');



      $fields[] = array('id' => 'ignoreCss', 'label' => __('Exclude default css files and styles configuration of the plugin.', 'Halo16'), 'callback' => array($this, 'checkboxIgnoreCss'), 'section_name' => $page_name.'_ignore_assets');
      $fields[] = array('id' => 'ignoreJs', 'label' => __('Exclude default js files of the plugin.', 'Halo16'), 'callback' => array($this, 'checkboxIgnoreJs'), 'section_name' => $page_name.'_ignore_assets');
      $fields[] = array('id' => 'title_color_1', 'label' => __('Title color.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style1');
      $fields[] = array('id' => 'text_color_1', 'label' => __('Text color.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style1');
      $fields[] = array('id' => 'button_color_1', 'label' => __('Button color.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style1');
      $fields[] = array('id' => 'button_background_1', 'label' => __('Button background.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style1');
      $fields[] = array('id' => 'title_color_2', 'label' => __('Title color.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style2');
      $fields[] = array('id' => 'text_color_2', 'label' => __('Text color.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style2');
      $fields[] = array('id' => 'button_color_2', 'label' => __('Button color.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style2',);
      $fields[] = array('id' => 'button_background_2', 'label' => __('Button background.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style2');
      $fields[] = array('id' => 'title_color_3', 'label' => __('Title color.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style3');
      $fields[] = array('id' => 'text_color_3', 'label' => __('Text color.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style3');
      $fields[] = array('id' => 'button_color_3', 'label' => __('Button color.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style3');
      $fields[] = array('id' => 'button_background_3', 'label' => __('Button background.', 'Halo16'), 'callback' => array($this, 'inputColor'), 'section_name' => $page_name.'_style3');

      $fields[] = array('id' => 'morePages', 'label' => __('Show the child/sibiling pages after the content.', 'Halo16'), 'callback' => array($this, 'checkboxMorePages'), 'section_name' => $page_name.'_more_pages');

      $this->setProperty('fields',$fields);
    }

    public function inputTrimContent() {
        $current = intval($this->getProperty('model')->getProperty('words_to_show'));
        $args = array(
            'id' => 'words_to_show',
            'name' => $this->getProperty('model')->getProperty('option_name'),
            'value' => $current,
            'message' => __('Input the number of words to show in the post content.','Halo16'),
            'min' => 0,
            'max' => 255,
            'step' => 1
        );
        $this->getProperty('view')->renderNumber($args);
        return;
    }


    public function selectImageSize() {
        $current = $this->getProperty('model')->getProperty('image_size');
        $args = array(
            'id' => 'image_size',
            'name' => $this->getProperty('model')->getProperty('option_name'),
            'elements' => $this->getImageSizeForSelect($current),
            'enabled' => true,
        );
        $this->getProperty('view')->renderSelect($args);
        return;
    }

    protected function getImageSizeForSelect($current = null){
        global $_wp_additional_image_sizes;
        $options = get_intermediate_image_sizes();
        foreach($options as $option){
            if ( in_array( $option, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
                $elements[] = array(
                    'label' => $option.' ['. get_option( "{$option}_size_w" ).' x '.get_option( "{$option}_size_h" ).']',
                    'value' => $option,
                    'current' => $option == $current
                );
            } elseif ( isset( $_wp_additional_image_sizes[ $option ] ) ) {
                $elements[] = array(
                    'label' => $option.' ['. $_wp_additional_image_sizes[$option]['width'].' x '.$_wp_additional_image_sizes[$option]['height'].']',
                    'value' => $option,
                    'current' => $option == $current
                );
            }
        }
        $elements[] = array(
            'label' => 'full [full_width x full_height]',
            'value' => 'full',
            'current' => 'full' == $current
        );
        return $elements;
    }

    public function inputColor($id) {
    	$current = $this->getProperty('model')->getProperty($id);
    	$args = array(
            'id' => $id,
            'name' => $this->getProperty('model')->getProperty('option_name'),
            'value' => $current,
            'message' => __('Select the color','Halo16'),
            'extra_classes' => $this->getProperty('model')->getProperty('ignore_css')==1 ? array('cp_disabled') :array()
        );
        $this->getProperty('view')->renderColorPicker($args);
        return;
    }

    public function import(){
      $this->getProperty('model')->import(get_option('halo16-plugin-config-option'));
    }

    public function setName() {
      $this->setProperty('menu_label',__('Halo16', 'Halo16'));
    }

    public function validateInput($args){
      $errors = array();

      if($this->validateFile('no_image', array('image/jpeg','image/png','image/gif')))
        $args['no_image'] = $this->uploadMedia('no_image');
      else
        $errors[] = __('Wrong mime type or dimension for no image.', 'Halo16');

      if(isset($_POST['reset'])){
        switch($_POST['reset']){
          case 'no_image_reset':
            $this->deleteMediaByID($this->getProperty('model')->getProperty('no_image'));
            $args['no_image'] = null;
            break;
        }
      }

      if(isset($args['ignore_css']))
        $args['ignore_css'] = $this->stringToBool($args['ignore_css']);

      if(isset($args['ignore_js']))
      	$args['ignore_js'] = $this->stringToBool($args['ignore_js']);

      foreach($errors as $error){
          add_settings_error(
              'halo16_plugin_config_report',
              esc_attr( 'settings_updated' ),
              $error,
              'error'
          );
      }

      if(empty($errors)){
          $this->getProperty('model')->import($args);
      }

      return $this->getProperty('model')->toArray();
    }


    public function checkboxIgnoreCss() {
      $current = $this->getProperty('model')->getProperty('ignore_css');
      $args = array(
        'id' => 'ignore_css',
        'name' => $this->getProperty('model')->getProperty('option_name'),
        'checked' => $current,
        'message' => __('Check to avoid the plugin css and styles load. Specific css and colors must be write on theme. See readme file for the css layout.','Halo16')
      );
      $this->getProperty('view')->renderCheckbox($args);
      return;
    }

    public function checkboxIgnoreJs() {
        $current = $this->getProperty('model')->getProperty('ignore_js');
        $args = array(
            'id' => 'ignore_js',
            'name' => $this->getProperty('model')->getProperty('option_name'),
            'checked' => $current,
            'message' => __('Check to avoid the plugin js load. Specific js must be write on theme.','Halo16')
        );
        $this->getProperty('view')->renderCheckbox($args);
        return;
    }

    public function checkboxMorePages() {
        $current = $this->getProperty('model')->getProperty('more_pages');
        $args = array(
            'id' => 'more_pages',
            'name' => $this->getProperty('model')->getProperty('more_pages'),
            'checked' => $current,
            'message' => __('Enable to show other pages at the end of the content.
                            If the page is a parent page it will show the child pages.
                            If the page is a child page it will show the sibiling pages.','Halo16')
        );
        $this->getProperty('view')->renderCheckbox($args);
        return;
    }

    public function inputNoImage(){
        $current = $this->getProperty('model')->getProperty('no_image');
        $args = array(
            'id' => 'no_image',
            'name' => $this->getProperty('model')->getProperty('option_name'),
            'current' => wp_get_attachment_image( $current, 'thumbnail' ),
            'delete_button_text' => __('Delete Image','Halo16')
        );
        $this->getProperty('view')->renderInputFile($args);
        return;
    }


    private function uploadMedia($image_name){
      $media_id = $this->getProperty('model')->getProperty('no_image');

      if(isset($_FILES[$image_name]) && !empty($_FILES[$image_name]['tmp_name'])){
        if(!is_null($media_id)){
          if(!$this->deleteMediaByID($media_id)){
            return $media_id;
          }
        }

        $upload_result = media_handle_upload($image_name, 0);
        if(!is_wp_error( $upload_result )){
            $media_id = $upload_result;
        }else{
            // echo errors;
        }
      }

      return $media_id;
    }

    private function deleteImageFromUrl($url){
      if(empty($url))
          return;
      $array = parse_url($url);
      $file_name = get_home_path().substr($array['path'], 1);
      if(file_exists($file_name))
          unlink($file_name);
    }

    private function deleteMediaByID($id){
      if ( false === wp_delete_attachment( $id ) ){
        return false;
      }
      return true;
    }

    private function validateFile($image_name, $types, $dimensions = null){
      if(empty($_FILES[$image_name]['tmp_name'])){
        return true;
      }

      if(!$this->checkMimeType($types, $_FILES[$image_name]['type'])){
        return false;
      }

      if(!empty($dimensions)){
        return $this->checkImageDimension($dimensions, $_FILES[$image_name]['tmp_name']);
      }

      return true;
    }

    private function checkMimeType($types, $img_type){
      foreach($types as $type){
        if($type == $img_type){
          return true;
          break;
        }
      }
      return false;
    }

    private function checkImageDimension($dimensions, $img_path){
      list($img_width, $img_height) = getimagesize($img_path);
      if($img_width != $dimensions[0] || $img_height != $dimensions[1])
        return false;
      return true;
    }

  	public function renderView(){
      $args = array(
        'title'                     => __('Main configuration for Halo16 page preview plugin','Halo16'),
        'form_id'                   => $this->getProperty('model')->getProperty('page_name').'-form',
        'fields'                    => $this->getProperty('model')->getProperty('page_name'),
        'sections'                  => $this->getProperty('model')->getProperty('page_name'),
        'permission_error_message'  => __( 'You do not have sufficient permissions to access this page.', 'Halo16' )
      );
  		$this->getProperty('view')->render($args);
  		return;
  	}

  	public function enqueueCss(){

  	}

    public function enqueueJs(){

    }
  }
