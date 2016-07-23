<?php

/**
 * Link more
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * url:
 * text:
 */
function tfuse_link_more($atts, $content = null) {
    extract(shortcode_atts(array('url' => '#', 'text' => ''), $atts));

    if (empty($text))
        $text = 'more details';

    return '<a class="link-more" href="' . $url . '">' . $text . '</a>';
}

$atts = array(
    'name' => 'Link More',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 9,
    'options' => array(
        array(
            'name' => 'Link',
            'desc' => 'Specifies the URL of the page the link goes to',
            'id' => 'tf_shc_link_more_link',
            'value' => '#',
            'type' => 'text'
        ),
        array(
            'name' => 'Text',
            'desc' => 'Specifies the the text for shoh an shortcode',
            'id' => 'tf_shc_link_more_text',
            'value' => 'more details',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('link_more', 'tfuse_link_more', $atts);
