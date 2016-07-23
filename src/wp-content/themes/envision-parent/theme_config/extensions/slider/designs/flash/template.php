<?php
/**
 * The template for displaying Awkward Showcase.
 * To override this template in a child theme, copy this file to your 
 * child theme's folder /theme_config/extensions/slider/designs/awkward/
 * 
 * If you want to change style or javascript of this slider, copy files to your 
 * child theme's folder /theme_config/extensions/slider/designs/awkward/static/
 * and change get_template_directory() with get_stylesheet_directory()
 */

$TFUSE->include->register_type('slider_js_folder', get_template_directory() . '/theme_config/extensions/slider/designs/'.$slider['design'].'/static/js');
$TFUSE->include->js('swfobject_modified', 'slider_js_folder', 'tf_footer');
$slider =  tfuse_get_slider();
?>

<div class="container_12">
    <div class="header_flash">
        <div class="map" id="visionFlow">
            <script type="text/javascript" src="<?php echo get_template_directory_uri().'/theme_config/extensions/slider/designs/flash/static'; ?>/swfobject/swfobject.js"></script>
            <script type="text/javascript">
                var flashvars = {
                  configPath: "<?php echo get_template_directory_uri().'/theme_config/extensions/slider/designs/flash'; ?>/config.php?d=<?php echo rand(1,1000) . ',' . $post->ID . ',' . $slider ?>"
                };
                var params = {
                    wmode:'transparent'
                };
                var attributes = {
                  id:"visionFlow",
                  name:"visionFlow"
                };
                swfobject.embedSWF("<?php echo get_template_directory_uri().'/theme_config/extensions/slider/designs/flash/static'; ?>/visionFlow.swf", "visionFlow", "990", "368", "10.0.0", "<?php echo get_template_directory_uri().'/theme_config/extensions/slider/designs/flash/static'; ?>/swfobject/expressInstall.swf", flashvars, params, attributes);
            </script>
      </div>
    </div>
</div>
