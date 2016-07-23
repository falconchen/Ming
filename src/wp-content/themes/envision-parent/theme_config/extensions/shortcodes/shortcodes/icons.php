<?php

/**
 * Icons
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 */
function tfuse_icon_check() {
    return '<img src="'.get_bloginfo('template_directory').'/images/icons/icon_check.png" class="check_icon" />';
}

$atts = array(
    'name' => 'Icon Check',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 7,
    'options' => array(
    )
);

tf_add_shortcode('icon_check', 'tfuse_icon_check', $atts);

function tfuse_icon_x() {
    return '<img src="'.get_bloginfo('template_directory').'/images/icons/icon_x.png" class="check_icon" />';
}

$atts = array(
    'name' => 'Icon X',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 7,
    'options' => array(
    )
);

tf_add_shortcode('icon_x', 'tfuse_icon_x', $atts);
