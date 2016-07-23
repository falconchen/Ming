<?php

/**
 * Slide Show
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * width:
 * height:
 * 
 * Slides documentation http://slidesjs.com/
 */

function tfuse_slideshow($atts, $content = null)
{
    extract(shortcode_atts(array('width' => 400, 'height' => 300), $atts));

    $content = trim($content);
    $image_arr = (array) preg_split("/(\r?\n)/", $content);
    $uniq = rand(300, 400);

    $out = '
    <script type="text/javascript">
        jQuery(document).ready(function($){
            $("#slides' . $uniq . '").slides({
                play: 4000,
                hoverPause: true,
                autoHeight: true,
                effect: "fade",
                fadeSpeed: 600,
                crossfade: true,
                preload: true,
                preloadImage: "' . get_template_directory_uri() . '/images/loading.gif"});
        });
    </script>
    <!--/ SlideShow -->
    ';

    $out .= '
    <div id="slides' . $uniq . '" class="slideshow slideGallery" style="width:'.$width.'px; height:'.$height.'px;">
        <div class="slides_container">
    ';

    foreach ($image_arr as $image)
    {
        if ( !empty($image) )
        {
            $getimage = new TF_GET_IMAGE();
            $img = $getimage->width($width)->height($height)->src($image)->get_img();
            $out .= '<div class="slide">' . $img . '</div>' . PHP_EOL;
        }
    }

    $out .= '
        </div>
    </div>
    ';

    return $out;
}

$atts = array(
    'name' => 'Slideshow',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 6,
    'options' => array(
        array(
            'name' => 'Width',
            'desc' => 'Specifies the width of an slideshow',
            'id' => 'tf_shc_slideshow_width',
            'value' => '570',
            'type' => 'text'
        ),
        array(
            'name' => 'Height',
            'desc' => 'Specifies the height of an slideshow',
            'id' => 'tf_shc_slideshow_height',
            'value' => '270',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Images',
            'desc' => 'Specifies the URLs of images of an shortcode, one per line.',
            'id' => 'tf_shc_slideshow_content',
            'value' => '
http://themefuse.com/demo/wp/medica/files/2011/10/slide-2.jpg

http://themefuse.com/demo/wp/medica/files/2011/10/slide-1.jpg

http://themefuse.com/demo/wp/medica/files/2011/10/slide-4.jpg

http://themefuse.com/demo/wp/medica/files/2011/10/slide-3.jpg

http://themefuse.com/demo/wp/medica/files/2011/10/slide-5.jpg
            ',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('slideshow', 'tfuse_slideshow', $atts);
