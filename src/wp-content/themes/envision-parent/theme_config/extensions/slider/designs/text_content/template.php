<?php
/**
 * The template for displaying Text Content Slider.
 * To override this template in a child theme, copy this file to your 
 * child theme's folder /theme_config/extensions/slider/designs/text_content/
 * 
 * If you want to change style or javascript of this slider, copy files to your 
 * child theme's folder /theme_config/extensions/slider/designs/text_content/static/
 * and change get_template_directory() with get_stylesheet_directory()
 */

$TFUSE->include->register_type('slider_js_folder', get_template_directory() . '/theme_config/extensions/slider/designs/'.$slider['design'].'/static/js');
$TFUSE->include->js('loopedslider', 'slider_js_folder', 'tf_head');
?>
<!-- slider -->
    <div class="container_12">
        <div class="slider">
				<div class="sText" id="textSlider">
					<div class="sliderBody">
                    	<div class="slides">
                            <?php foreach ($slider['slides'] as $slide) : ?>
                        	<div class="slide-item">
                            	<div class="slide-image <?php echo $slide['slide_align_img']; ?>">
                                <?php
                                    if ($slide['slide_align_img'] == 'afullwidth'){
                                        $width = 885;
                                        $height = 360;
                                    }
                                    else{
                                        $width = 640;
                                        $height = 360;
                                    }

                                    if ( $slide['slide_media'] != ''){
                                        $video = new TF_GET_EMBED();
                                        echo $video->width($width)->height($height)->source($slide['slide_media'],$slide['slide_media'])->get();
                                    }
                                    else {
                                        if ( $slide['slide_url'] != '') { ?>
                                             <a href="<?php echo $slide['slide_url']; ?>" target="<?php echo $slide['slide_target_url']; ?>">
                                                 <img src="<?php echo $slide['slide_src'] ?>" alt="" width="<?php echo $width; ?>" height="<?php echo $height; ?>" border="0" />
                                             </a>
                                        <?php
                                        }
                                        else { ?>
                                            <img src="<?php echo $slide['slide_src'] ?>" alt="" width="<?php echo $width; ?>" height="<?php echo $height; ?>" border="0" />
                                <?php   }
                                    } ?>
                                </div>
                                <div class="slide-text">
                                	<div class="slide-title"><strong><?php echo $slide['slide_title']; ?></strong></div>
                                    <?php echo $slide['slide_description']; ?>
                                    <a href="<?php echo $slide['slide_url']; ?>" class="slider-button" target="<?php echo $slide['slide_target_url']; ?>"><?php _e('Find out more', 'tfuse'); ?></a>
                                </div>
                                <div class="clear"></div>
                            </div>
                            <?php endforeach; ?>

        </div>
    </div>
    <a href="#" class="previous"><?php _e('Previous','tfuse'); ?></a>
    <a href="#" class="next"><?php _e('Next','tfuse'); ?></a>
</div>
            <script language="javascript" type="text/javascript" charset="utf-8">
                    jQuery(document).ready(function($) {
                        $('#textSlider').loopedSlider({
                            container: ".sliderBody",
                            slides: ".slides",
                            autoStart: 7000,
                            slidespeed: 500,
                            effect: "easeOutCubic",
                            containerClick: false
                        });
                    });
                </script>
    </div>
</div>
<!--/ slider -->
