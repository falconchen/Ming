<?php
/* ----------------------------------------------------------------------------------- */
/* Initializes all the theme settings option fields for categories area.             */
/* ----------------------------------------------------------------------------------- */

$options = array(
    // Choice Category Template
    array('name' => 'Choice Category Template',
        'desc' => 'Some themes have custom templates you can use for certain categories that might have additional features or custom layouts. If so, you\'ll see them above.',
        'id' => TF_THEME_PREFIX . '_portfolio_tax_template',
        'value' => 'image',
        'options' => array(
            '1col' => 'Portfolio 1 column',
            '2col' => 'Portfolio 2 columns',
            '3col' => 'Portfolio 3 columns',
            '4col' => 'Portfolio 4 columns'
        ),
        'type' => 'select',
    ),
    // Element of Hedear
    array('name' => 'Element of Hedear',
        'desc' => 'Select type of element on the header.',
        'id' => TF_THEME_PREFIX . '_header_element',
        'value' => 'image',
        'options' => array( 'slider' => 'Slider on Header', 'image' => 'Image on Header'),
        'type' => 'select',
    ),
    // Select Slider
    $this->ext->slider->model->has_sliders() ?
            array(
        'name' => 'Slider',
        'desc' => 'Select a slider for your post. The sliders are created on the <a href="' . admin_url( 'admin.php?page=tf_slider_list' ) . '" target="_blank">Sliders page</a>.',
        'id' => TF_THEME_PREFIX . '_select_slider',
        'value' => '',
        'options' => $TFUSE->ext->slider->get_sliders_dropdown(),
        'type' => 'select'
            ) :
            array(
        'name' => 'Slider',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_select_slider',
        'value' => '',
        'html' => 'No sliders created yet. You can start creating one <a href="' . admin_url('admin.php?page=tf_slider_list') . '">here</a>.',
        'type' => 'raw'
            )
    ,
    // Header Image
    array('name' => 'Header Image',
        'desc' => 'Upload an image for your header. It will be resized to 960x368 px',
        'id' => TF_THEME_PREFIX . '_header_image',
        'value' => '',
        'type' => 'upload',
    ),
    // Header Image Link
    array('name' => 'Image Link',
        'desc' => 'Add URL for Single Image Slider (Ex: http://themefuse.com)',
        'id' => TF_THEME_PREFIX . '_header_image_link',
        'value' => '',
        'type' => 'text',
    ),
    // Image Target
    array('name' => 'Image Target',
        'desc' => 'Add Image Target',
        'id' => TF_THEME_PREFIX . '_header_image_target',
        'value' => '_blank',
        'options' => array( '_blank' => 'Open link in new window', '_self' => 'Open link in same window'),
        'type' => 'select',
        'divider' => true
    ),
    // Header Welcome bar
    array('name' => 'Welcome Bar',
        'desc' => 'Check if you don\'t want the header bar to appear for this page',
        'id' => TF_THEME_PREFIX . '_header_welcome_bar',
        'value' => 'true',
        'type' => 'checkbox',
    ),
    // use template
    array('name' => 'Use',
        'desc' => 'Add Image Target',
        'id' => TF_THEME_PREFIX . '_header_welcome_template',
        'value' => 'our',
        'options' => array( 'our' => 'Our template', 'your' => 'Make your own'),
        'type' => 'select'
    ),
    // Make your own header bar by using custom text, html, shortcodes.
    array('name' => 'Custom',
        'desc' => 'Make your own header bar by using custom text, html, shortcodes.',
        'id' => TF_THEME_PREFIX . '_header_your_template',
        'value' => '',
        'type' => 'textarea',
    ),
    // Header Welcome Title
    array('name' => 'Title',
        'desc' => 'Enter your preferred Header Bar Title for this page.',
        'id' => TF_THEME_PREFIX . '_header_welcome_title',
        'value' => '',
        'type' => 'text',
    ),
    // Header Welcome Subtitle
    array('name' => 'Subtitle',
        'desc' => 'Enter your preferred Header Bar Subitle for this page.',
        'id' => TF_THEME_PREFIX . '_header_welcome_subtitle',
        'value' => '',
        'type' => 'text',
    ),
    // Header Welcome Icon
    array('name' => 'Icon',
        'desc' => 'Upload an icon for your Header Bar, or specify the icon address of your online icon. (http://yoursite.com/icon.png)',
        'id' => TF_THEME_PREFIX . '_header_welcome_icon',
        'value' => '',
        'type' => 'upload',
    ),
    // Make your own header bar by using custom text, html, shortcodes.
    array('name' => 'Shortcode',
        'desc' => 'Use a shortcode that you whant to appear on the right side of the header bar ([search], [button link="#" size="large"]View Portfolio[/button]) or other text/html',
        'id' => TF_THEME_PREFIX . '_header_our_template',
        'value' => '',
        'type' => 'textarea',
    ),

);

?>