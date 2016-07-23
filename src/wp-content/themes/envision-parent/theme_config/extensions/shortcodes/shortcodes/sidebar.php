<?php

/**
 * Display dynamic sidebar.
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * index: or name: int|string Optional, default is 1. Name or ID of dynamic sidebar.
 * 
 * http://codex.wordpress.org/Function_Reference/dynamic_sidebar
 */

function tfuse_sidebar($atts)
{
    extract(shortcode_atts(array('index' => 1, 'name' => ''), $atts));

    if ( !empty($name) ) $index = $name;

    ob_start();
    dynamic_sidebar($index);
    $output = ob_get_contents();
    ob_end_clean();

    return $output;
}

$atts = array(
    'name' => 'Sidebar',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Index',
            'desc' => 'Specifies the sidebar ID <br /><br /> OR',
            'id' => 'tf_shc_sidebar_index',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Name',
            'desc' => 'Specifies the sidebar name (optional)',
            'id' => 'tf_shc_sidebar_name',
            'value' => '',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('sidebar', 'tfuse_sidebar', $atts);
