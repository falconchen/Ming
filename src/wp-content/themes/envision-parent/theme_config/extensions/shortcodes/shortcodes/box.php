<?php

/**
 * Boxes
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * type: info, note, download, warrning or custom css classes e.g. download box_border
 * color: color name or hexadecimal color code e.g. blue, #dbecf8
 * style: custom css style
 */

function tfuse_box($atts, $content = null)
{
    extract( shortcode_atts(array('type' => '', 'style' => '', 'class'=> ''), $atts) );


    if (!empty($color) || !empty($style))
        $style = ' style="'. $style . '"';
    
    return '<div class="box ' . $type . ' ' . $class . '"' . $style . '><span class="icontype"></span>' . do_shortcode($content) . '</div>';
}
$atts = array(
    'name' => 'Box',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 7,
    'options' => array(
        array(
            'name' => 'Type',
            'desc' => 'Specify type of the box',
            'id' => 'tf_shc_box_type',
            'value' => '',
            'options' => array(
                'info_box' => 'Info Box',
                'warning_box' => 'Warrning Box',
                'download_box' => 'Download Box',
                'note_box' => 'Note Box',
            ),
            'type' => 'select'
        ),
        array(
            'name' => 'Style',
            'desc' => 'Specify an inline style for an shortcode',
            'id' => 'tf_shc_box_style',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode, separated by space.
                <br /><b>predefined classes:</b> dark_blue, sky_blue, magic_pink, mellow_yellow,juicy_orange, sports_green, romance_red',
            'id' => 'tf_shc_box_class',
            'value' => '',
            'type' => 'text'

        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter shortcode content',
            'id' => 'tf_shc_box_content',
            'value' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('box', 'tfuse_box', $atts);
