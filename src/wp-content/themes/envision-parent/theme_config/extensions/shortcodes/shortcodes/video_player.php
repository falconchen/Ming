<?php

/**
 * Video player
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * link: 
 * width:
 * height:
 * title:
 */
function tfuse_youtube($atts, $content = null) {
    extract(shortcode_atts(array('link' => '', 'width' => 590, 'height' => 315), $atts));

    $tfuse_shortcode_arr = array();

    preg_match("#(?<=v=)[a-zA-Z0-9-]+(?=&)|(?<=v\/)[^&\n]+|(?<=v=)[^&\n]+|(?<=youtu.be/)[^&\n]+#", $link, $video_id);

    return '<iframe width="' . $width . '" height="' . $height . '" src="http://www.youtube.com/embed/' . $video_id[0] . '?wmode=transparent" frameborder="0"></iframe>' . PHP_EOL;
}

$atts = array(
    'name' => 'Youtube',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 6,
    'options' => array(
        array(
            'name' => 'Link',
            'desc' => 'Specifies the link of the youtube video',
            'id' => 'tf_shc_youtube_link',
            'value' => 'http://www.youtube.com/watch?v=5yB1XPzFzjk',
            'type' => 'text'
        ),
        array(
            'name' => 'Width',
            'desc' => 'Specifies the width of the video',
            'id' => 'tf_shc_youtube_width',
            'value' => '590',
            'type' => 'text'
        ),
        array(
            'name' => 'Height',
            'desc' => 'Specifies the height of the video',
            'id' => 'tf_shc_youtube_height',
            'value' => '315',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('youtube', 'tfuse_youtube', $atts);


function tfuse_vimeo($atts, $content)
{

    extract(shortcode_atts(array('link' => '', 'width' => 590, 'height' => 332, 'title' => ''), $atts));

    return '<iframe src="http://player.vimeo.com/video/' . substr($link, 17, 8) . '?title=0&amp;byline=0&amp;portrait=0" width="' . $width . '" height="' . $height . '" frameborder="0"></iframe>' . PHP_EOL;
}

$atts = array(
    'name' => 'Vimeo',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 6,
    'options' => array(
        array(
            'name' => 'Link',
            'desc' => 'Specifies the link of the vimeo video',
            'id' => 'tf_shc_vimeo_link',
            'value' => 'http://vimeo.com/16919307',
            'type' => 'text'
        ),
        array(
            'name' => 'Width',
            'desc' => 'Specifies the width of the video',
            'id' => 'tf_shc_vimeo_width',
            'value' => '590',
            'type' => 'text'
        ),
        array(
            'name' => 'Height',
            'desc' => 'Specifies the height of the video',
            'id' => 'tf_shc_vimeo_height',
            'value' => '332',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('vimeo', 'tfuse_vimeo', $atts);
