<?php
/**
 * The template for displaying Animated Slider.
 * To override this template in a child theme, copy this file to your 
 * child theme's folder /theme_config/extensions/slider/designs/animated/
 * 
 * If you want to change style or javascript of this slider, copy files to your 
 * child theme's folder /theme_config/extensions/slider/designs/animated/static/
 * and change get_template_directory() with get_stylesheet_directory()
 */
$TFUSE->include->register_type('slider_css_folder', get_template_directory() . '/theme_config/extensions/slider/designs/'.$slider['design'].'/static/css');
$TFUSE->include->css('home', 'slider_css_folder', 'tf_head');

$TFUSE->include->register_type('slider_js_folder', get_template_directory() . '/theme_config/extensions/slider/designs/'.$slider['design'].'/static/js');
$TFUSE->include->js('home', 'slider_js_folder', 'tf_footer');

?>
<div class="container_12">
    <div class="slider">
            <div id="header_images">
                <?php foreach ($slider['slides'] as $slide) : ?>
                <img src="<?php echo $slide['slide_src']; ?>" class="header_image" alt="" color="<?php echo $slide['slide_color']; ?>" link="<?php echo $slide['slide_url']; ?>" target="<?php echo $slide['slide_target_url']; ?>"/>
                <?php endforeach; ?>
            </div>
            <div class="header_controls">
                <a href="#" id="header_controls_left"><?php _e('Previous','tfuse'); ?></a>
                <a href="#" id="header_controls_right"><?php _e('Next','tfuse'); ?></a>
            </div>
            <div id="overlay_bg"></div>
    </div>
</div>
