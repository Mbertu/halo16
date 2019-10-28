<?php

namespace halo16;

class Halo16PluginConfigModel extends AbstractPluginConfigModel {

    protected $ignore_css;
    protected $ignore_js;
    protected $no_image;
    protected $image_size;
    protected $words_to_show;
    protected $title_color_1;
    protected $title_color_2;
    protected $title_color_3;
    protected $text_color_1;
    protected $text_color_2;
    protected $text_color_3;
    protected $button_color_1;
    protected $button_color_2;
    protected $button_color_3;
    protected $button_background_1;
    protected $button_background_2;
    protected $button_background_3;
    protected $more_pages;

    protected $defaults = array(
        'ignore_css'      => false,
        'ignore_js'       => false,
        'no_image'        => null,
        'image_size'      => null,
        'words_to_show'  => 0,
        'title_color_1'   => '#000000',
        'title_color_2'   => '#000000',
        'title_color_3'   => '#000000',
        'text_color_1'    => '#000000',
        'text_color_2'    => '#000000',
        'text_color_3'    => '#000000',
        'button_color_1'    => '#FFFFFF',
        'button_color_2'    => '#FFFFFF',
        'button_color_3'    => '#FFFFFF',
        'button_background_1'    => '#000000',
        'button_background_2'    => '#000000',
        'button_background_3'    => '#000000',
        'more_pages' => false,
    );

    public function toArray(){
        return array(
            'ignore_css'        => $this->getProperty('ignore_css'),
            'ignore_js'         => $this->getProperty('ignore_js'),
            'no_image'          => $this->getProperty('no_image'),
            'image_size'        => $this->getProperty('image_size'),
            'words_to_show'     => $this->getProperty('words_to_show'),
            'title_color_1'     => $this->getProperty('title_color_1'),
            'title_color_2'     => $this->getProperty('title_color_2'),
            'title_color_3'     => $this->getProperty('title_color_3'),
            'text_color_1'      => $this->getProperty('text_color_1'),
            'text_color_2'      => $this->getProperty('text_color_2'),
            'text_color_3'      => $this->getProperty('text_color_3'),
            'button_color_1'      => $this->getProperty('button_color_1'),
            'button_color_2'      => $this->getProperty('button_color_2'),
            'button_color_3'      => $this->getProperty('button_color_3'),
            'button_background_1'      => $this->getProperty('button_background_1'),
            'button_background_2'      => $this->getProperty('button_background_2'),
            'button_background_3'      => $this->getProperty('button_background_3'),
            'more_pages' => $this->getProperty('more_pages'),
        );

    }
}
