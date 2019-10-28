<?php

  namespace halo16;

  class Halo16ShortcodeController extends AbstractShortcodeController{

    public function halo16_shortcode($atts = [], $content = null, $tag = ''){
       $atts = array_change_key_case((array)$atts, CASE_LOWER);
       if(empty($atts['id'])) return $content;

       $page_atts = shortcode_atts([ // attr default ( se non settati)
                                    'layout' => 'text',
                                ], $atts, $tag);

      $output = '';
      $output .= '<h2>' .  $page_atts['layout'] . '</h2>';

      if (!is_null($content)) {
         // secure output by executing the_content filter hook on $content
         $output .= apply_filters('the_content', $content);

         // run shortcode parser recursively
         $output .= do_shortcode($content);
     }

     return $output;
   }


  }
