<?php

namespace halo16;

class Halo16WidgetFrontendView extends AbstractWidgetFrontendView
{
    private $args;
    private $widget;
    private $plugin;
    private $colors = array('title'=>'','text'=>'','button_text'=>'','button_background'=>'');

    public function render($args = null)
    {
        $this->args = $args;
        $this->widget = $args['widget'];
        $this->plugin = $args['plugin'];

        echo $args['before_widget'];

        $background = !empty($this->widget['pattern']) ? 'background-image: url('.$this->widget['pattern'].');
    																								      background-repeat:no-repeat;
          																								background-position:center;
          																								background-size:cover;'
                                                                          : '';
        if ($this->plugin['ignore_css'] != 1) {
            $style = $this->widget['style'];
            if ($style == 'style_1') {
                $this->colors['title'] = $this->plugin['title_color_1'];
                $this->colors['text'] = $this->plugin['text_color_1'];
                $this->colors['button_text'] = $this->plugin['button_color_1'];
                $this->colors['button_background'] = $this->plugin['button_background_1'];
            } elseif ($style == 'style_2') {
                $this->colors['title'] = $this->plugin['title_color_2'];
                $this->colors['text'] = $this->plugin['text_color_2'];
                $this->colors['button_text'] = $this->plugin['button_color_2'];
                $this->colors['button_background'] = $this->plugin['button_background_2'];
            } else {
                $this->colors['title'] = $this->plugin['title_color_3'];
                $this->colors['text'] = $this->plugin['text_color_3'];
                $this->colors['button_text'] = $this->plugin['button_color_3'];
                $this->colors['button_background'] = $this->plugin['button_background_3'];
            }
        } ?>

    		<div id="<?php echo $this->widget['anchor']; ?>"
    						 class="halo16_widget  <?php echo $this->widget['style']; ?> "
    						 style="<?php echo $background; ?>">

        			 <div class="row">
                         <div class="row-height">
      					 <?php switch ($this->widget['layout']) {
                                case 'text':
                                    $this->renderText('', $this->widget['animation_left']);
                                    break;
                                case 'image-text':
                                    $this->renderText(' col-sm-6 col-sm-push-6 ', $this->widget['animation_right']);
                                    $this->renderImage('col-sm-6 col-sm-pull-6 ', $this->widget['animation_left']);
                                    break;
                                case 'text-image':
                                    $this->renderText('col-sm-6 ', $this->widget['animation_left']);
                                    $this->renderImage('col-sm-6 ', $this->widget['animation_right']);
                                    break;
                                case 'map-text':
                                    if(empty($this->widget['map_place_id']) || empty($this->widget['map_key'])) break;
                                    wp_register_script( 'halo16-maps-js', get_stylesheet_directory_uri() . '/assets/js/halo16-maps.js', array('jquery'), true );
                                    $map = array('id'=>$this->args['id'],'map_place_id'=> $this->widget['map_place_id'],'map_key'=>$this->widget['map_key'],'theme_folder'=>get_stylesheet_directory_uri());
                                    $this->renderText('col-sm-6 col-sm-push-6',$this->widget['animation_right']);
                                    $this->renderMap('col-sm-6 col-sm-pull-6',$this->widget['animation_left'],$map);
                                    break;
                                case 'text-map':
                                    if(empty($this->widget['map_place_id']) || empty($this->widget['map_key'])) break;
                                    $map = array('id'=>$this->args['id'],'map_place_id'=> $this->widget['map_place_id'],'map_key'=>$this->widget['map_key'],'theme_folder'=>get_stylesheet_directory_uri());
                                    $this->renderText('col-sm-6' ,$this->widget['animation_left']);
                                    $this->renderMap('col-sm-6',$this->widget['animation_right'],$map);
                                    break;
                                case 'shortcode-text':
                                    $this->renderText('col-sm-6 col-sm-push-6',$this->widget['animation_right']);
                                    $this->renderShortcode('col-sm-6 col-sm-pull-6',$this->widget['animation_left'],$this->widget['shortcode']);
                                    break;
                                case 'text-shortcode':
                                    $this->renderText('col-sm-6' ,$this->widget['animation_left']);
                                    $this->renderShortcode('col-sm-6',$this->widget['animation_right'],$this->widget['shortcode']);
                                    break;
                                default:
                                    break;
                            } ?>
                        </div>
                    </div>
            </div>
     	<?php echo $args['after_widget'];
    }



    private function renderText($behavior, $animation)
    {
        ?>
    		<div class="col-xs-12 <?php echo $behavior; ?>  wow <?php echo $animation; ?>"
    		 	data-wow-delay=<?php echo $this->widget['delay']; ?>
    			data-wow-offset=<?php echo $this->widget['offset']; ?>>
    			<header class="halo16_header">
    				<?php if (!empty($this->args['title'])) { ?>
                        <h2 class="halo16_title" style="color:<?php echo $this->colors['title']; ?>;"><?php echo $this->args['title']; ?></h2>
                    <?php } ?>
					<?php if (!empty($this->args['subtitle'])) { ?>
                        <p class="halo16_subtile" style="color:<?php echo $this->colors['text']; ?>;"><?php echo $this->args['subtitle']; ?></p>
                    <?php } ?>
                </header>
    			<div class="halo16_content" style="color:<?php echo $this->colors['text']; ?>;">
    				<?php echo $this->args['content']; ?>
    			</div>
    			<?php if (!empty($this->widget['read_more'])) { ?>
    				<div class="halo16_read_more">
    					<a href="<?php echo $this->args['read_more']; ?>"  style="color:<?php echo $this->colors['button_text']; ?>; background:<?php echo $this->colors['button_background']; ?>;">
                           <?php echo $this->widget['read_more']; ?>
                        </a>
                   </div>
                <?php } ?>
    		</div>
    	<?php
    }

    private function renderImage($behavior, $animation)
    {
        ?>
    		<div class="col-xs-12  <?php echo $behavior; ?>  wow <?php echo $animation; ?>"
    			 	data-wow-delay=<?php echo $this->widget['delay']; ?>
    				data-wow-offset=<?php echo $this->widget['offset']; ?>>
    				<div class="halo16_image">
    					<?php echo $this->args['image']; ?>
    				</div>
    		</div>
    	<?php
    }

    private function renderMap($behavior,$animation,$map)
    {
        wp_enqueue_script(  'halo16-map-js' , plugins_url() . '/halo16/assets/js/halo16-maps.js',array(),null,false);
        ?>
    		<div class="col-xs-12  <?php echo $behavior;?>  wow <?php echo $animation;?>"
    		 	data-wow-delay=<?php echo $this->widget['delay'];?>
    			data-wow-offset=<?php echo $this->widget['offset'];?>>
				<div class="halo16_map">
					<div class="halo16_map_container" >
						<div id="halo16_map_<?php echo $map['id'];?>" class="halo16_map_canvas" ></div>
					</div>
				</div>
    		</div>
    		<script>
                halo16_maps = <?php echo json_encode($map); ?>;
    		</script>
		<?php
	}

	private function renderShortcode($behavior,$animation,$shortcode){ ?>
		<div class="col-xs-12  <?php echo $behavior;?>  wow <?php echo $animation;?>"
			 	data-wow-delay=<?php echo $this->widget['delay'];?>
				data-wow-offset=<?php echo $this->widget['offset'];?>>
				<div class="section_shortcode">
						<?php echo do_shortcode($shortcode); ?>
				</div>
		</div>
		<?php
	}






}
