<?php

namespace halo16;

class Halo16WidgetModel extends AbstractWidgetModel {

    protected $page;

    protected $layout;

    protected $style;

    protected $read_more;

    protected $map_key;

    protected $map_place_id;

    protected $shortcode;

    protected $anchor;

    protected $animation_left;

    protected $animation_right;

    protected $offset;

    protected $delay;

    protected $duration;

    protected $pattern;

    protected $style_options = array('style_1','style_2','style_3');

    protected $layout_options = array('text','image-text','text-image','map-text','text-map','shortcode-text','text-shortcode');

    protected $animation_options = array(
        'bounce',
        'flash',
        'pulse',
        'rubberBand',
        'shake',
        'swing',
        'tada',
        'wobble',
        'bounceIn',
        'bounceInDown',
        'bounceInLeft',
        'bounceInRight',
        'bounceInUp',
        'bounceOut',
        'bounceOutDown',
        'bounceOutLeft',
        'bounceOutRight',
        'bounceOutUp',
        'fadeIn',
        'fadeInDown',
        'fadeInDownBig',
        'fadeInLeft',
        'fadeInLeftBig',
        'fadeInRight',
        'fadeInRightBig',
        'fadeInUp',
        'fadeInUpBig',
        'fadeOut',
        'fadeOutDown',
        'fadeOutDownBig',
        'fadeOutLeft',
        'fadeOutLeftBig',
        'fadeOutRight',
        'fadeOutRightBig',
        'fadeOutUp',
        'fadeOutUpBig',
        'flip',
        'flipInX',
        'flipInY',
        'flipOutX',
        'flipOutY',
        'lightSpeedIn',
        'lightSpeedOut',
        'rotateIn',
        'rotateInDownLeft',
        'rotateInDownRight',
        'rotateInUpLeft',
        'rotateInUpRight',
        'rotateOut',
        'rotateOutDownLeft',
        'rotateOutDownRight',
        'rotateOutUpLeft',
        'rotateOutUpRight',
        'hinge',
        'rollIn',
        'rollOut',
        'zoomIn',
        'zoomInDown',
        'zoomInLeft',
        'zoomInRight',
        'zoomInUp',
        'zoomOut',
        'zoomOutDown',
        'zoomOutLeft',
        'zoomOutRight',
        'zoomOutUp'
    );

    protected $defaults = array(
        'page'                   => '',
        'layout'                 => 'text',
        'style'                  => 'page_style_1',
        'read_more'              => '',
        'map_key'                => '',
        'map_place_id'           => '',
        'shortcode'              => '',
        'anchor'                 => '',
        'animation_left'         => 'fadeInLeft',
        'animation_right'        => 'fadeInRight',
        'offset'                 => '100',
        'delay'                  => '0.5s',
        'duration'               => '0.5s',
        'pattern'                => '',
    );

    public function toArray(){
        $state = array(
            'page'                   => $this->getProperty('page'),
            'layout'                 => $this->getProperty('layout'),
            'style'                  => $this->getProperty('style'),
            'read_more'              => $this->getProperty('read_more'),
            'map_key'                => $this->getProperty('map_key'),
            'map_place_id'           => $this->getProperty('map_place_id'),
            'shortcode'              => $this->getProperty('shortcode'),
            'anchor'                 => $this->getProperty('anchor'),
            'animation_left'         => $this->getProperty('animation_left'),
            'animation_right'        => $this->getProperty('animation_right'),
            'offset'                 => $this->getProperty('offset'),
            'delay'                  => $this->getProperty('delay'),
            'duration'               => $this->getProperty('duration'),
            'pattern'                => $this->getProperty('pattern'),
        );
        return $state;
    }
}
