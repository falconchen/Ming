<?php

/**
 * Columns
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * type: 1, 1_2, 1_3, 1_4, 2_3 etc.
 * class:

 */

function tfuse_col($atts, $content = null)
{
    extract(shortcode_atts(array('type' => '1', 'class' => ''), $atts));
    return '<div class="col col_' . $type . ' ' . $class . '"><div class="inner">' . do_shortcode($content) . '</div></div>';
}

$atts = array(
    'name' => 'Columns',
    'desc' => 'Here comes some lorem ipsum description for the button shortcode.',
    'category' => 4,
    'options' => array(
        array(
            'name' => 'Type',
            'desc' => 'Select column type',
            'id' => 'tf_shc_col_type',
            'value' => '_self',
            'options' => array(
                '1' => 'One column',
                '1_2' => 'One half column (1/2)',
                '1_3' => 'One third column (1/3)',
                '1_4' => 'A fourth column (1/4)',
                '1_5' => 'A fifth column (1/5)',
                '1_6' => 'A sixth column (1/6)',
                '1_12' => 'A twelfth column (1/12)',
                '2_3' => 'Two thirds column (2/3)',
                '2_5' => 'Two fifths of the column (2/5)',
                '3_4' => 'Threee fourths column (3/4)',
                '3_5' => 'Threee fifts column (3/5)',
                '3_8' => 'Threee eights Column (3/8)',
                '4_5' => 'Four fifths column (4/5)',
                '5_6' => 'Five sixths column (5/6)',
                '5_8' => 'Five eights Column (5/8)',
                '4_5' => 'Five sixths column (5/6)'
            ),
            'type' => 'select'
        ),
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode. To specify multiple classes,<br /> separate the class names with a space, e.g. <b>"left important"</b>.',
            'id' => 'tf_shc_col_class',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter shortcode content',
            'id' => 'tf_shc_col_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('col', 'tfuse_col', $atts);
