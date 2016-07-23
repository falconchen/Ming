<?php

/**
 * HighLight
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * class: custom css class e.g. highlight_yellow, highlight_brown, highlight_blue, highlight_black, highlight_purple
 * style: custom css style e.g. color:#ffffff; background:#cc1d00
 */
function tfuse_highlight($atts, $content) {
    extract(shortcode_atts(array('class' => '', 'style' => ''), $atts));

    if (!empty($class))
        $class = ' class="' . $class . '"';
    if (!empty($style))
        $style = ' style="' . $style . '"';

    return '<span' . $class . $style . '>' . strip_tags($content) . '</span>';
}

$atts = array(
    'name' => 'Highlight',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 9,
    'before_preview' => 'Lorem Ipsum is simply ',
    'after_preview' => '. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.',
    'options' => array(
        array(
            'name' => 'Class',
            'desc' => 'Specify classes of the shortcode
                <br /><b>predefined classes:</b> highlight_yellow, highlight_brown, highlight_blue, highlight_black, highlight_purple',
            'id' => 'tf_shc_highlight_class',
            'value' => 'highlight_yellow',
            'type' => 'text'
        ),
        array(
            'name' => 'Style',
            'desc' => 'Specify an inline style for the shortcode <br /> e.g. color:#ffffff; background:#cc1d00',
            'id' => 'tf_shc_highlight_style',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter shortcode content',
            'id' => 'tf_shc_highlight_content',
            'value' => 'text of the printing',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('highlight', 'tfuse_highlight', $atts);
