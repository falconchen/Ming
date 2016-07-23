<?php
/**
 * Styled Boxes
 *
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/shortcodes/ folder.
 *
 * Optional arguments:
 * title: Shortcode title
 * class: custom class
 */

function tfuse_styled_box($atts, $content = null)
{
    extract( shortcode_atts(array('title' => '', 'class' => ''), $atts) );


    return '<div class="sb '.$class.'">
                <div class="box_title">' . $title . '</div>
                <div class="box_content">'. do_shortcode($content) .'<div class="clear"></div>
                </div>
            </div>';
}
$atts = array(
    'name' => 'Styled Boxes',
    'desc' => 'Here comes some lorem ipsum description for the button shortcode.',
    'category' => 7,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Text to display above the box',
            'id' => 'tf_shc_styled_box_title',
            'value' => 'The most popularity internet browser',
            'type' => 'text'
        ),
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode, separated by space.
                <br /><b>predefined classes:</b> sb_pink, sb_black, sb_blue, sb_yellow, sb_green',
            'id' => 'tf_shc_styled_box_class',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter shortcode content',
            'id' => 'tf_shc_styled_box_content',
            'value' => 'Content',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('styled_box', 'tfuse_styled_box', $atts);
