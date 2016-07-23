<?php

/**
 * Table
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * class: custom css class
 */

function tfuse_table($atts, $content)
{
    extract(shortcode_atts(array('class' => ''), $atts));

    $tfuse_shortcode_arr['content'] = html_entity_decode(do_shortcode($content));

    return '<div class="styled_table ' . $class . '">' . html_entity_decode(do_shortcode($content)) . '</div>';
}

$atts = array(
    'name' => 'Table',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 7,
    'options' => array(
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode. To specify multiple classes,<br /> separate the class names with a space, e.g. <b>"left important"</b>',
            'id' => 'tf_shc_table_class',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter table content',
            'id' => 'tf_shc_table_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('table', 'tfuse_table', $atts);
