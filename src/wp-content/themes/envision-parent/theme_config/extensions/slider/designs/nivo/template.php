<?php
/**
 * The template for displaying Nivo Slider.
 * To override this template in a child theme, copy this file to your 
 * child theme's folder /theme_config/extensions/slider/designs/nivo/
 * 
 * If you want to change style or javascript of this slider, copy files to your 
 * child theme's folder /theme_config/extensions/slider/designs/nivo/static/
 * and change get_template_directory() with get_stylesheet_directory()
 */

$TFUSE->include->register_type('slider_js_folder', get_template_directory() . '/theme_config/extensions/slider/designs/'.$slider['design'].'/static/js');
$TFUSE->include->js('jquery.nivo.slider', 'slider_js_folder', 'tf_footer');
?>
<script type="text/javascript">
		jQuery(window).load(function() {
			jQuery('#imageSlider').nivoSlider({
					effect:'random',
					animSpeed:300,
					pauseTime:5000,
					pauseOnHover:true,
					directionNavHide:false
			});
		});
</script>
<!-- slider -->
    <div class="container_12">
        <div class="slider">

            <div class="sImages">
                <div class="sliderBody nivsliderBody" id="imageSlider">
                    <?php foreach ($slider['slides'] as $slide) :
                    if ( $slide['slide_url'] != '') { ?>
                	<a href="<?php echo $slide['slide_url']; ?>" target="<?php echo $slide['slide_target_url']; ?>">
                        <img src="<?php echo $slide['slide_src']; ?>" alt="" class="slider-img" />
                    </a>
                    <?php }
                    else { ?>
                        <img src="<?php echo $slide['slide_src']; ?>" alt="" class="slider-image"  />
                    <?php } endforeach ?>

                    </div>
            </div>
        </div>
    </div>
<!--/ slider -->
