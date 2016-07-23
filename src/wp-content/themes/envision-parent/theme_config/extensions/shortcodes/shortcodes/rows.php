<?php

/**
 * Rows
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 */

function tfuse_row_box($atts, $content = null)
{
    extract(shortcode_atts(array('class' => ''), $atts));
    return '<div class="' . $class . '">' . do_shortcode($content) . '<div class="clear"></div></div>';
}

$atts = array(
    'name' => 'Row Box',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 7,
    'options' => array(
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode. To specify multiple classes,<br /> separate the class names with a space, e.g. <b>"left important"</b>',
            'id' => 'tf_shc_row_box_class',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'The page templates need to be constructed on rows. <br />
                You need to use the [row] shortcode when you want your content to go on another row.',
            'id' => 'tf_shc_row_box_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('row_box', 'tfuse_row_box', $atts);

function tfuse_row($atts, $content = null)
{
    return '<div class="row">' . do_shortcode($content) . '</div>';
}

$atts = array(
    'name' => 'Row',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 7,
    'options' => array(
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'The page templates need to be constructed on rows. <br />
                You need to use the [row] shortcode when you want your content to go on another row.',
            'id' => 'tf_shc_row_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('row', 'tfuse_row', $atts);
