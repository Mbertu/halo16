<?php

  namespace halo16;

class Halo16WidgetController extends AbstractWidgetController
{

    function __construct()
    {
        parent::__construct(
            'halo16-widget',
            __('Halo16 Widget', 'Halo16'),
            array( 'description' => __('Display a single page inside a single section.', 'Halo16') )
        );
        $widget_model_args = array(
        'version' => '1.0.0'
        );
        $this->widget_model = $this->getProperty('factory')->createModel('widget', 'halo16-widget', $widget_model_args);
        $plugin_model_args = array(
        'option_name' => generateOptionName('halo16-plugin-config'),
        'page_name' => 'halo16-plugin-config',
        );

        $this->plugin_model = $this->getProperty('factory')->createModel('plugin-config', 'halo16-plugin-config', $plugin_model_args);
        $this->frontend_view = $this->getProperty('factory')->createView('widget-frontend', 'halo16-widget-frontend');
        $this->admin_view = $this->getProperty('factory')->createView('widget-config', 'halo16-widget-config');

        add_action('renderFrontendHalo16Widget', array($this,'renderFrontend'));
        do_action( 'renderFrontendHalo16WidgetRegistered', 'renderFrontendHalo16Widget');
    }


    public function widget($args, $instance)
    {
        $this->getProperty('widget_model')->import($instance);
        if (empty($this->getProperty('widget_model')->getProperty('page'))) {
            return;
        }
        $page =  get_post(apply_filters('wpml_object_id', $this->getProperty('widget_model')->getProperty('page'), 'page', false));
        $args['title'] = $page->post_title;
        $subtitle_meta = get_metadata('post', $page->ID, 'halo1-subtitle-metabox-theme_config', true);
        if (!empty($subtitle_meta)) {
            $args['subtitle'] = $subtitle_meta['subtitle'];
        }
        $args['content'] = $this->getPageContent($page->post_content);
        $args['permalink'] = get_permalink($page->ID);
        $args['image'] = $this->getPageImage($page->ID);
        $args['id'] = $page->ID;
        $args['date'] = $page->post_date;
        $args['author'] = $page->post_author;
        $args['widget'] = $this->getProperty('widget_model')->toArray();

        $args['plugin'] = $this->plugin_option;

        $parent = get_post_ancestors($page->ID);

        if (!empty($parent)) { //ha genitore
            $sibilings =   wp_list_pages(array('child_of' => $parent[0] ,'exclude'=>$page->ID, 'echo' => 0 ,'title_li'=> '','walker' => ''));
            if (!empty($sibilings)) {
                $args['sibilings'] = $sibilings;
            }
        }

        $childs = wp_list_pages(array('child_of' => $page->ID , 'echo' => 0, 'title_li'=> '','walker' => ''));
        if (!empty($childs)) {
            $args['childs'] = $childs;
        }

        do_action('renderFrontendHalo16Widget', $args);
    }


    public function form($instance)
    {
        $this->getProperty('widget_model')->import($instance);
        $args = array(
        'id' => apply_filters('wpml_object_id', $this->get_field_id('page'), 'page', false),
        'name' => $this->get_field_name('page'),
        'label' => __('Page', 'Halo16'),
        'elements' => $this->getPagesForSelect( apply_filters('wpml_object_id', $this->getProperty('widget_model')->getProperty('page'),  'page', false)),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderSelect($args);

        $args = array(
        'id' => $this->get_field_id('layout'),
        'name' => $this->get_field_name('layout'),
        'label' => __('Layout', 'Halo16'),
        'elements' =>  $this->getLayoutForSelect($this->getProperty('widget_model')->getProperty('layout')),
        'enabled' => true,
        'extra_classes' => array('layout_select'),
        );
        $this->getProperty('admin_view')->renderSelect($args);

        $args = array(
        'id' => $this->get_field_id('style'),
        'name' => $this->get_field_name('style'),
        'label' => __('Style', 'Halo16'),
        'elements' =>  $this->getSectionsStyleForSelect($this->getProperty('widget_model')->getProperty('style')),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderSelect($args);

        $args = array(
        'id' => $this->get_field_id('read_more'),
        'name' => $this->get_field_name('read_more'),
        'label' => __('Read More Text (empty to disable) ', 'Halo16'),
        'value' =>esc_html($this->getProperty('widget_model')->getProperty('read_more')),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderInput($args);

        $args = array(
        'id' => $this->get_field_id('map_key'),
        'name' => $this->get_field_name('map_key'),
        'label' => __('Map Key', 'Halo1'),
        'value' => $this->getProperty('widget_model')->getProperty('map_key'),
        'enabled' =>  true,
        'extra_classes' => array("map_key"),
        );
        $this->getProperty('admin_view')->renderInput($args);

        $args = array(
        'id' => $this->get_field_id('map_place_id'),
        'name' => $this->get_field_name('map_place_id'),
        'label' => __('Map Place ID (use , for more pointers)', 'Halo1'),
        'value' => $this->getProperty('widget_model')->getProperty('map_place_id'),
        'enabled' =>  true,
        'extra_classes' => array("map_place_id"),
        );
        $this->getProperty('admin_view')->renderInput($args);

        $args = array(
        'id' => $this->get_field_id('shortcode'),
        'name' => $this->get_field_name('shortcode'),
        'label' => __('Shortcode', 'Halo1'),
        'value' => $this->getProperty('widget_model')->getProperty('shortcode'),
        'enabled' =>  true,
        'extra_classes' => array("shortcode"),
        );
        $this->getProperty('admin_view')->renderInput($args);

        $args = array(
        'id' => $this->get_field_id('anchor'),
        'name' => $this->get_field_name('anchor'),
        'label' => __('Anchor', 'Halo16'),
        'value' => $this->getProperty('widget_model')->getProperty('anchor'),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderInput($args);

        $args = array(
        'id' => $this->get_field_id('animation_left'),
        'name' => $this->get_field_name('animation_left'),
        'label' => __('Animation Left', 'Halo16'),
        'elements' =>  $this->getAnimationForSelect($this->getProperty('widget_model')->getProperty('animation_left')),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderSelect($args);

        $args = array(
        'id' => $this->get_field_id('animation_right'),
        'name' => $this->get_field_name('animation_right'),
        'label' => __('Animation Right', 'Halo16'),
        'elements' =>  $this->getAnimationForSelect($this->getProperty('widget_model')->getProperty('animation_right')),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderSelect($args);

        $args = array(
        'id' => $this->get_field_id('offset'),
        'name' => $this->get_field_name('offset'),
        'label' => __('Offset', 'Halo16'),
        'value' => $this->getProperty('widget_model')->getProperty('offset'),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderInput($args);

        $args = array(
        'id' => $this->get_field_id('delay'),
        'name' => $this->get_field_name('delay'),
        'label' => __('Delay', 'Halo16'),
        'value' => $this->getProperty('widget_model')->getProperty('delay'),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderInput($args);

        $args = array(
        'id' => $this->get_field_id('duration'),
        'name' => $this->get_field_name('duration'),
        'label' => __('Duration', 'Halo16'),
        'value' => $this->getProperty('widget_model')->getProperty('duration'),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderInput($args);


        $args = array(
        'id' => $this->get_field_id('pattern'),
        'name' => $this->get_field_name('pattern'),
        'label' => __('Pattern', 'Halo16'),
        'value' => $this->getProperty('widget_model')->getProperty('pattern'),
        'enabled' => true,
        );
        $this->getProperty('admin_view')->renderUpload($args);  ?>


      <script type="text/javascript">
        jQuery(document).ready(function($){
            $('.upload').click(function(e) {
                e.preventDefault();
                var image = wp.media({
                    title: 'Upload Image',
                    multiple: false
                }).open()
                .on('select', function(e){
                    var uploaded_image = image.state().get('selection').first();
                    console.log(uploaded_image);
                    var image_url = uploaded_image.toJSON().url;
                    $('.upload_path').val(image_url);
                    $('.upload').attr("src",image_url);
                });
            });
            $('.clear_upload').click(function(e) {
                e.preventDefault();
                $('.upload').attr("src",'');
                $('.upload_path').val('');
            });
            $( ".upload_path" ).change(function() {
                $('.upload').attr("src",$( ".upload_path" ).val());
            });
        });
      </script>   <?php
    }


    public function update($new_instance, $old_instance)
    {
        $this->getProperty('widget_model')->import($old_instance);

        if (isset($new_instance['page'])) {
            $new_instance['page'] = esc_html(sanitize_text_field($new_instance['page']));
        }

        if (isset($new_instance['layout'])) {
            $new_instance['layout'] = sanitize_text_field($new_instance['layout']);
        }

        if (isset($new_instance['style'])) {
            $new_instance['style'] = sanitize_text_field($new_instance['style']);
        }

        if (isset($new_instance['read_more'])) {
            $new_instance['read_more'] = sanitize_text_field($new_instance['read_more']);
        }

        if (isset($new_instance['map_key'])) {
            $new_instance['map_key'] = sanitize_text_field($new_instance['map_key']);
        }

        if (isset($new_instance['map_place_id'])) {
            $new_instance['map_place_id'] = sanitize_text_field($new_instance['map_place_id']);
        }

        if (isset($new_instance['shortcode'])) {
            $new_instance['shortcode'] = sanitize_text_field($new_instance['shortcode']);
        }

        if (isset($new_instance['anchor'])) {
            $new_instance['anchor'] = sanitize_text_field($new_instance['anchor']);
        }

        if (isset($new_instance['animation_left'])) {
            $new_instance['animation_left'] = sanitize_text_field($new_instance['animation_left']);
        }

        if (isset($new_instance['animation_right'])) {
            $new_instance['animation_right'] = sanitize_text_field($new_instance['animation_right']);
        }

        if (isset($new_instance['offset'])) {
            $new_instance['offset'] = sanitize_text_field($new_instance['offset']);
        }

        if (isset($new_instance['delay'])) {
            $new_instance['delay'] = sanitize_text_field($new_instance['delay']);
        }

        if (isset($new_instance['duration'])) {
              $new_instance['duration'] = sanitize_text_field($new_instance['duration']);
        }

        if (isset($new_instance['pattern'])) {
              $new_instance['pattern'] = sanitize_text_field($new_instance['pattern']);
        }

        if (isset($new_instance['extra_classes'])) {
              $new_instance['extra_classes'] = sanitize_text_field($new_instance['extra_classes']);
        }

        $this->getProperty('widget_model')->import($new_instance);

        return $this->getProperty('widget_model')->toArray();
    }

    protected function getPagesForSelect($current = null)
    {

        $args = array(
        'sort_order' => 'ASC',
        'sort_column' => 'post_title',
        'post_type' => 'page',
        'post_status' => 'publish'
        );
        $pages = get_pages($args);

        $elements = array(
          array(
              'label' => '---',
              'value' => '',
              'current' => $current == null
          )
        );

        foreach ($pages as $page) {
            $elements[] = array(
              'label' => esc_html($page->post_title),
              'value' => esc_html($page->ID),
              'current' => esc_html($page->ID) == $current
            );
        }
        return $elements;
    }

    protected function getAnimationForSelect($current = null)
    {
        $options = $this->getProperty('widget_model')->getProperty('animation_options');
        foreach ($options as $option) {
            $elements[] = array(
                'label' => $option,
                'value' => $option,
                'current' => $option == $current
            );
        }
        return $elements;
    }

    protected function getLayoutForSelect($current = null)
    {
        $options = $this->getProperty('widget_model')->getProperty('layout_options');
        foreach ($options as $option) {
            $elements[] = array(
                'label' => $option,
                'value' => $option,
                'current' => $option == $current
            );
        }
        return $elements;
    }

    protected function getSectionsStyleForSelect($current = null)
    {
        $options = $this->getProperty('widget_model')->getProperty('style_options');
        foreach ($options as $option) {
            $elements[] = array(
                'label' => $option,
                'value' => $option,
                'current' => $option == $current
            );
        }
        return $elements;
    }
}
