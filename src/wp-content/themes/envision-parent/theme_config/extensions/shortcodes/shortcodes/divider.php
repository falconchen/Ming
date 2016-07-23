<?php

/**
 * Divider Styles
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * type: space, space_thin, dots, dots_full, thin  
 */

function tfuse_divider($atts)
{
    extract( shortcode_atts(array('type' => 'space'), $atts) );

    if ( !empty($type) ) $type = '_' . $type;

    return '<div class="divider' . $type . '"></div>';
}

$atts = array(
    'name' => 'Dividers',
    'desc' => 'Here comes some lorem ipsum description for this shortcode.',
    'category' => 9,
    'before_preview' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
    'after_preview' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    'options' => array(
        array(
            'name' => 'Type',
            'desc' => 'Select divider type',
            'id' => 'tf_shc_divider_type',
            'value' => '',
            'options' => array(
                'space' => 'Divider Space',
                'thin' => 'Divider Thin'
            ),
            'type' => 'select'
        )
    )
);

tf_add_shortcode('divider', 'tfuse_divider', $atts);

function tfuse_clear($atts)
{
    extract( shortcode_atts(array('type' => 'clear'), $atts) );
    return '<div class="' . $type . '"></div>';
}

$atts = array(
    'name' => 'Clear',
    'desc' => 'Here comes some lorem ipsum description for this shortcode.',
    'category' => 9,
    'before_preview' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry.',
    'after_preview' => 'Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    'options' => array(
        array(
            'name' => 'Type',
            'desc' => 'Select clear type',
            'id' => 'tf_shc_clear_type',
            'value' => '',
            'options' => array(
                'clear' => 'Clear',
                'clearboth' => 'Clear Both'
            ),
            'type' => 'select'
        )
    )
);

tf_add_shortcode('clear', 'tfuse_clear', $atts);
tf_shortcode_alias('clearboth', 'clear', array('type' => 'clearboth'));
