<?php
/**
 * Basic slider configurations
 *
 * @since Envision 2.0
 */

global $TFUSE;
$cfg['valid_types'] = array('custom');
$cfg['setup'] = array(
    array(
        'design' => 'animated',
        'name' => 'Animated'
    ),
    array(
        'design' => 'flash',
        'name' => 'Flash'
    ),
    array(
        'design' => 'nivo',
        'name' => 'Nivo'
    ),
    array(
        'design' => 'text_content',
        'name' => 'Text Content'
    )
);
$cfg['slider_type_names'] = array(
    'custom' => 'Manually, I\'ll upload the images myself',
    'categories' => 'Automatically, fetch images from categories',
    'tags' => 'Automatically, fetch images by tags',
    'posts' => 'Automatically, fetch images from posts'
);

//*********************
$type_select = array('' => 'Choose your slider type');
if (isset($cfg['valid_types']) && count($cfg['valid_types']) > 0) {
    $tmp = array_intersect($TFUSE->ext->slider->valid_types, $cfg['valid_types']);
    if (count($tmp) > 0)
        foreach ($tmp as $type)
            $type_select[$type] = $cfg['slider_type_names'][$type];
}
//*********************
$cfg['add_new_slider'] = array(
    'tabs' => array(
        array(
            'name' => 'Add New Slider',
            'id' => 'add_new_slider', #do not change id
            'headings' => array(
                array(
                    'name' => 'General Settings',
                    'options' => array(
                        array(
                            'name' => 'Slider Type',
                            'desc' => 'Choose the slider type. You can check the sliders in the <a target="_black" href="http://themefuse.com/demo/wp/envision/">demo live preview</a> on our website.',
                            'id' => 'slider_design_type',
                            'value' => '',
                            'type' => 'callback',
                            'callback' => array(&$TFUSE->ext->slider, 'slider_design_callback')
                        ),
                        array(
                            'name' => 'Slider Population Method',
                            'desc' => ' The images from the slider can be uploaded manually or you can choose to automatically take them from posts, tags or categories.',
                            'id' => 'slider_type',
                            'value' => 'custom',
                            'type' => 'text'
                        ),
                        array(
                            'name' => 'Slider Title',
                            'desc' => 'Choose a title for your slider only for internal use: Ex: "Homepage".',
                            'id' => 'slider_title',
                            'value' => '',
                            'type' => 'text',
                            'required' => TRUE
                        )
                    )
                )
            )
        )
    )
);

$cfg['slider_design_and_type'] = array(
    array(
        'name' => 'Slider Design',
        'desc' => ' This is the design of your slider. It can\'t be changed. If you need another design please create a new slider.',
        'id' => 'slider_design_chosen',
        'value' => '',
        'type' => 'callback',
        'callback' => array(&$TFUSE->ext->slider, 'slider_design_chosen_callback')
    ),
    array(
        'name' => 'Slider Type',
        'desc' => 'This is the method of populating the slider and can\'t be changed. You\'ll need to create a different slider if you want a different type of population method.',
        'id' => 'slider_type_chosen',
        'value' => '',
        'type' => 'callback',
        'callback' => array(&$TFUSE->ext->slider, 'slider_type_chosen_callback')
    )
);

$cfg['slider_framebox'] = array(
    'name' => 'Drag/Click slides to Rearrange/Edit',
    'options' => array(
        array(
            'name' => 'Framebox',
            'desc' => 'Framebox description',
            'id' => TF_THEME_PREFIX . '_slider_framebox',
            'value' => '',
            'type' => 'callback',
            'callback' => 'framebox'
        )
    )
);

$cfg['settings'] = array(
    'tab_includes' => array(
        'common' => array(
            'slider_settings'
        ),
        'custom' => array(
            'slider_setup'
        ),
        'categories' => array(
            'slider_type_categories'
        ),
        'posts' => array(
            'slider_type_posts'
        ),
        'tags' => array(
            'slider_type_tags'
        )
    ),
    'extra' => array(
        'custom' => array(
            'slide_src' => 'slide_src',
            'slide_media' => 'slide_media',
            'slide_prefix' => 'slide_',
            'slide_title' => 'slide_title'
        )
    )
);
