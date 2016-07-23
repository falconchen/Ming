<?php

/* ----------------------------------------------------------------------------------- */
/* Initializes all the theme settings option fields for posts area. */
/* ----------------------------------------------------------------------------------- */

$options = array(
    /* ----------------------------------------------------------------------------------- */
    /* Sidebar */
    /* ----------------------------------------------------------------------------------- */

    /* Single Post */
    array('name' => 'Single Post',
        'id' => TF_THEME_PREFIX . '_side_media',
        'type' => 'metabox',
        'context' => 'side',
        'priority' => 'low' /* high/low */
    ),
    // Disable Single Post Image
    array('name' => 'Disable Image',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_image',
        'value' => tfuse_options('disable_image','false'),
        'type' => 'checkbox'
    ),
    // Disable Single Post Video
    array('name' => 'Disable Video',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_video',
        'value' => tfuse_options('disable_video','false'),
        'type' => 'checkbox'
    ),
    // Disable Single Post Comments
    array('name' => 'Disable Comments',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_comments',
        'value' => tfuse_options('disable_posts_comments','false'),
        'type' => 'checkbox'
    ),
    // Post Meta
    array('name' => 'Disable Post Category',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_post_category',
        'value' => 'false',
        'type' => 'checkbox'
    ),
    // Published Date
    array('name' => 'Disable Published Date',
        'desc' => '',
        'id' => TF_THEME_PREFIX . '_disable_published_date',
        'value' => 'false',
        'type' => 'checkbox'
    ),
    
    /* ----------------------------------------------------------------------------------- */
    /* After Textarea */
    /* ----------------------------------------------------------------------------------- */

    /* Post Media */
    array('name' => 'Media',
        'id' => TF_THEME_PREFIX . '_media',
        'type' => 'metabox',
        'context' => 'normal'
    ),
    // Single Image
    array('name' => 'Image',
        'desc' => 'This is the main image for your post. Upload one from your computer, or specify an online address for your image (Ex: http://yoursite.com/image.png).',
        'id' => TF_THEME_PREFIX . '_single_image',
        'value' => '',
        'type' => 'upload',
        'hidden_children' => array(
            TF_THEME_PREFIX . '_single_img_dimensions',
            TF_THEME_PREFIX . '_single_img_position'
        )
    ),
    // Single Image Dimensions
    array('name' => 'Image Resize (px)',
        'desc' => 'These are the default width and height values. If you want to resize the image change the values with your own. If you input only one, the image will get resized with constrained proportions based on the one you specified.',
        'id' => TF_THEME_PREFIX . '_single_img_dimensions',
        'value' => tfuse_options('single_image_dimensions'),
        'type' => 'textarray'
    ),
    // Single Image Position
    array('name' => 'Image Position',
        'desc' => 'Select your preferred image  alignment',
        'id' => TF_THEME_PREFIX . '_single_img_position',
        'value' => tfuse_options('single_image_position'),
        'options' => array(
            'noalign' => array($url . 'full_width.png', 'Don\'t apply an alignment'),
            'alignleft' => array($url . 'left_off.png', 'Align to the left'),
            'alignright' => array($url . 'right_off.png', 'Align to the right')
            ),
        'type' => 'images',
        'divider' => true
    ),    
    // Thumbnail Image
    array('name' => 'Thumbnail',
        'desc' => 'This is the thumbnail for your post. Upload one from your computer, or specify an online address for your image (Ex: http://yoursite.com/image.png).',
        'id' => TF_THEME_PREFIX . '_thumbnail_image',
        'value' => '',
        'type' => 'upload',
        'hidden_children' => array(
            TF_THEME_PREFIX . '_thumbnail_dimensions',
            TF_THEME_PREFIX . '_thumbnail_position'
        )
    ),
    // Posts Thumbnail Dimensions
    array('name' => 'Thumbnail Dimension (px)',
        'desc' => 'These are the default width and height values. If you want to resize the thumbnail change the values with your own. If you input only one, the thumbnail will get resized with constrained proportions based on the one you specified.',
        'id' => TF_THEME_PREFIX . '_thumbnail_dimensions',
        'value' => tfuse_options('thumbnail_dimensions'),
        'type' => 'textarray'
    ),
    // Thumbnail Position
    array('name' => 'Thumbnail Position',
        'desc' => 'Select your preferred thumbnail alignment',
        'id' => TF_THEME_PREFIX . '_thumbnail_position',
        'value' => tfuse_options('thumbnail_position'),
        'options' => array(
            'noalign' => array($url . 'full_width.png', 'Don\'t apply an alignment'),
            'alignleft' => array($url . 'left_off.png', 'Align to the left'),
            'alignright' => array($url . 'right_off.png', 'Align to the right')
            ),
        'type' => 'images',
        'divider' => true
    ),
    // Custom Post Video
    array('name' => 'Video',
        'desc' => 'Copy paste the video URL or embed code. The video URL works only for Vimeo and YouTube videos. Read <a target="_blank" href="http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/">prettyPhoto documentation</a>
                    for more info on how to add video or flash in this text area
                    ',
        'id' => TF_THEME_PREFIX . '_video_link',
        'value' => '',
        'type' => 'textarea',
        'hidden_children' => array(
            TF_THEME_PREFIX . '_video_dimensions',
            TF_THEME_PREFIX . '_video_position'
        )
    ),
    // Video Dimensions
    array('name' => 'Video Size (px)',
        'desc' => 'These are the default width and height values. If you want to resize the video change the values with your own. If you input only one, the video will get resized with constrained proportions based on the one you specified.',
        'id' => TF_THEME_PREFIX . '_video_dimensions',
        'value' => tfuse_options('video_dimensions'),
        'type' => 'textarray'
    ),
    // Video Position
    array('name' => 'Video Position',
        'desc' => 'Select your preferred video alignment',
        'id' => TF_THEME_PREFIX . '_video_position',
        'value' => tfuse_options('video_position'),
        'options' => array(
            'noalign' => array($url . 'full_width.png', 'Don\'t apply an alignment'),
            'alignleft' => array($url . 'left_off.png', 'Align to the left'),
            'alignright' => array($url . 'right_off.png', 'Align to the right')
            ),
        'type' => 'images'
    ),   
    /* Slider Options */
    array('name' => 'Slider',
        'id' => TF_THEME_PREFIX . '_slider_option',
        'type' => 'metabox',
        'context' => 'normal'
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
    // Element of Hedear
    array('name' => 'Image Target',
        'desc' => 'Add Image Target',
        'id' => TF_THEME_PREFIX . '_header_image_target',
        'value' => '_blank',
        'options' => array( '_blank' => 'Open link in new window', '_self' => 'Open link in same window'),
        'type' => 'select',
    ),
    /* Slider Options */
    array('name' => 'Welcome Bar',
        'id' => TF_THEME_PREFIX . '_welcome_bar_option',
        'type' => 'metabox',
        'context' => 'normal'
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
    )
);

?>