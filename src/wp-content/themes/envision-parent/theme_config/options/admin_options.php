<?php

/* ----------------------------------------------------------------------------------- */
/* Initializes all the theme settings option fields for admin area. */
/* ----------------------------------------------------------------------------------- */

$options = array(
    'tabs' => array(
        array(
            'name' => 'General',
            'type' => 'tab',
            'id' => TF_THEME_PREFIX . '_general',
            'headings' => array(
                array(
                    'name' => 'General Settings',
                    'options' => array(/* 1 */
                        // Custom Logo Option
                        array(
                            'name' => 'Custom Logo',
                            'desc' => 'Upload a logo for your theme, or specify the image address of your online logo. (http://yoursite.com/logo.png)',
                            'id' => TF_THEME_PREFIX . '_logo',
                            'value' => '',
                            'type' => 'upload'
                        ),
                        // Custom Favicon Option
                        array(
                            'name' => 'Custom Favicon <br /> (16px x 16px)',
                            'desc' => 'Upload a 16px x 16px Png/Gif image that will represent your website\'s favicon.',
                            'id' => TF_THEME_PREFIX . '_favicon',
                            'value' => '',
                            'type' => 'upload',
                            'divider' => true
                        ),
                        // Theme Stylesheet Option
                        array(
                            "name" 		=> "Theme Stylesheet",
                            "desc" 		=> "Please select your colour scheme here.",
                            "id" 		=> TF_THEME_PREFIX ."_stylesheet",
                            "std" 		=> "",
                            "type" 		=> "select",
                            'value' => 'default.css',
                            'options' => $TFUSE->optigen->styles(),
                            'divider' => true
                        ),
                        // Search Box Text
                        array(
                            'name' => 'Search Box text',
                            'desc' => 'Enter your Search Box text',
                            'id' => TF_THEME_PREFIX . '_search_box_text',
                            'value' => 'Type for search',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Tracking Code Option
                        array(
                            'name' => 'Tracking Code',
                            'desc' => 'Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.',
                            'id' => TF_THEME_PREFIX . '_google_analytics',
                            'value' => '',
                            'type' => 'textarea',
                            'divider' => true
                        ),
                        // Custom CSS Option
                        array(
                            'name' => 'Custom CSS',
                            'desc' => 'Quickly add some CSS to your theme by adding it to this block.',
                            'id' => TF_THEME_PREFIX . '_custom_css',
                            'value' => '',
                            'type' => 'textarea'
                        )
                    ) /* E1 */
                ),
                array(
                    'name' => 'Social Settings',
                    'options' => array(
                        // RSS URL Option
                        array('name' => 'RSS URL',
                            'desc' => 'Enter your preferred RSS URL. (Feedburner or other)',
                            'id' => TF_THEME_PREFIX . '_feedburner_url',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true

                        ),
                        // E-Mail URL Option
                        array('name' => 'E-Mail URL',
                            'desc' => 'Enter your preferred E-mail subscription URL. (Feedburner or other)',
                            'id' => TF_THEME_PREFIX . '_feedburner_id',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Twitter URL
                        array('name' => 'Twitter URL',
                            'desc' => 'Enter Twitter URL',
                            'id' => TF_THEME_PREFIX . '_twitter',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Facebook URL
                        array('name' => 'Facebook URL',
                            'desc' => 'Enter Facebook URL',
                            'id' => TF_THEME_PREFIX . '_facebook',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Twitter URL
                        array('name' => 'Flickr URL',
                            'desc' => 'Enter Flickr URL',
                            'id' => TF_THEME_PREFIX . '_flickr',
                            'value' => '',
                            'type' => 'text',
                            'divider' => true
                        ),
                        // Facebook URL
                        array('name' => 'DeviantART URL',
                            'desc' => 'Enter DeviantART URL',
                            'id' => TF_THEME_PREFIX . '_deviantart',
                            'value' => '',
                            'type' => 'text'
                        ),

                    )
                ),
                array(
                    'name' => 'Twitter',
                    'options' => array(
                        array(
                            'name' => 'Consumer Key',
                            'desc' => 'Set your <a href="http://screencast.com/t/zHu17C7nXy1">twitter</a> application <a href="http://screencast.com/t/yb44HiF2NZ">consumer key</a>.',
                            'id' => TF_THEME_PREFIX . '_twitter_consumer_key',
                            'value' => 'XW7t8bECoR6ogYtUDNdjiQ',
                            'type' => 'text',
                            'divider' => true
                        ),
                        array(
                            'name' => 'Consumer Secret',
                            'desc' => 'Set your <a href="http://screencast.com/t/zHu17C7nXy1">twitter</a> application <a href="http://screencast.com/t/eaKJHG1omN">consumer secret key</a>.',
                            'id' => TF_THEME_PREFIX . '_twitter_consumer_secret',
                            'value' => 'Z7UzuWU8a4obyOOlIguuI4a5JV4ryTIPKZ3POIAcJ9M',
                            'type' => 'text',
                            'divider' => true
                        ),
                        array(
                            'name' => 'User Token',
                            'desc' => 'Set your <a href="http://screencast.com/t/zHu17C7nXy1">twitter</a> application <a href="http://screencast.com/t/QEEG2O4H">access token key</a>.',
                            'id' => TF_THEME_PREFIX . '_twitter_user_token',
                            'value' => '1510587853-ugw6uUuNdNMdGGDn7DR4ZY4IcarhstIbq8wdDud',
                            'type' => 'text',
                            'divider' => true
                        ),
                        array(
                            'name' => 'User Secret',
                            'desc' => 'Set your <a href="http://screencast.com/t/zHu17C7nXy1">twitter</a>  application <a href="http://screencast.com/t/Yv7nwRGsz">access token secret key</a>.',
                            'id' => TF_THEME_PREFIX . '_twitter_user_secret',
                            'value' => '7aNcpOUGtdKKeT1L72i3tfdHJWeKsBVODv26l9C0Cc',
                            'type' => 'text'
                        )
                    )
                ),
                array(
                    'name' => 'Copyright',
                    'options' => array(
                        //copyright
                        array('name' => 'Custom Copyright',
                            'desc' => 'Create your custom copyright',
                            'id' => TF_THEME_PREFIX . '_custom_copyright',
                            'value' => '&copy; 2010  All Rights Reserved - Envision. WordPress theme  by Themefuse -<a href="http://themefuse.com"> Premium WordPress Themes</a>',
                            'type' =>'textarea'
                        )
                    )
                ),
                array(
                    'name' => 'Disable Theme settings',
                    'options' => array(
                        // Disable Image for All Single Posts
                        array('name' => 'Image on Single Post',
                            'desc' => 'Disable Image on All Single Posts? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_image',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Video for All Single Posts
                        array('name' => 'Video on Single Post',
                            'desc' => 'Disable Video on All Single Posts? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_video',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Comments for All Posts
                        array('name' => 'Post Comments',
                            'desc' => 'Disable Comments for All Posts? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_posts_comments',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable Comments for All Pages
                        array('name' => 'Page Comments',
                            'desc' => 'Disable Comments for All Pages? These settings may be overridden for individual articles.',
                            'id' => TF_THEME_PREFIX . '_disable_pages_comments',
                            'value' => 'true',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable posts lightbox (prettyPhoto) Option
                        array('name' => 'prettyPhoto on Categories',
                            'desc' => 'Disable opening image and attachemnts in prettyPhoto on Categories listings? If YES, image link go to post.',
                            'id' => TF_THEME_PREFIX . '_disable_listing_lightbox',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable posts lightbox (prettyPhoto) Option
                        array('name' => 'prettyPhoto on Single Post',
                            'desc' => 'Disable opening image and attachemnts in prettyPhoto on Single Post?',
                            'id' => TF_THEME_PREFIX . '_disable_single_lightbox',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'divider' => true
                        ),
                        // Disable preloadCssImages plugin
                        array('name' => 'preloadCssImages',
                            'desc' => 'Disable jQuery-Plugin "preloadCssImages"? This plugin loads automatic all images from css.If you prefer performance(less requests) deactivate this plugin',
                            'id' => TF_THEME_PREFIX . '_disable_preload_css',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'on_update' => 'reload_page',
                            'divider' => true
                        ),
                        // Disable SEO
                        array('name' => 'SEO Tab',
                            'desc' => 'Disable SEO option?',
                            'id' => TF_THEME_PREFIX . '_disable_tfuse_seo_tab',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'on_update' => 'reload_page',
                            'divider' => true
                        ),
                        // Enable Dynamic Image Resizer Option
                        array('name' => 'Dynamic Image Resizer',
                            'desc' => 'This will Disable the thumb.php script that dynamicaly resizes images on your site. We recommend you keep this enabled, however note that for this to work you need to have "GD Library" installed on your server. This should be done by your hosting server administrator.',
                            'id' => TF_THEME_PREFIX . '_disable_resize',
                            'value' => 'false',
                            'type' => 'checkbox'
                        ),
						 array('name' => 'Image from content',
                            'desc' => 'If no thumbnail is specified then the first uploaded image in the post is used.',
                            'id' => TF_THEME_PREFIX . '_enable_content_img',
                            'value' => 'false',
                            'type' => 'checkbox'
                        ),
                        // Remove wordpress versions for security reasons
                        array(
                            'name' => 'Remove Wordpress Versions',
                            'desc' => 'Remove Wordpress versions from the source code, for security reasons.',
                            'id' => TF_THEME_PREFIX . '_remove_wp_versions',
                            'value' => FALSE,
                            'type' => 'checkbox'
                        )
                    )
                ),
                array(
                    'name' => 'WordPress Admin Style',
                    'options' => array(
                        // Disable Themefuse Style
                        array('name' => 'Disable Themefuse Style',
                            'desc' => 'Disable Themefuse Style',
                            'id' => TF_THEME_PREFIX . '_deactivate_tfuse_style',
                            'value' => 'false',
                            'type' => 'checkbox',
                            'on_update' => 'reload_page'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Homepage',
            'id' => TF_THEME_PREFIX . '_homepage',
            'headings' => array(
                array(
                    'name' => 'Homepage Population',
                    'options' => array(
                        array('name' => 'Homepage Population',
                            'desc' => ' Select which categories to display on homepage. More over you can choose to load a specific page or change the number of posts on the homepage from <a target="_blank" href="' . network_admin_url('options-reading.php') . '">here</a>',
                            'id' => TF_THEME_PREFIX . '_homepage_category',
                            'value' => '',
                            'options' => array('all' => 'From All Categories', 'specific' => 'From Specific Categories','page' =>'From Specific Page','all_tax' => 'From Portfolio', 'specific_tax' => 'From Specific Portfolio Categories'),
                            'type' => 'select',
                            'install' => 'cat'
                        ),
						
						array('name' => 'Template',
                            'desc' => ' Select template type for portfolio.',
                            'id' => TF_THEME_PREFIX . '_template_portfolio',
                            'value' => '1col',
                            'options' => array('1col' => '1 column', '2col' => '2 columns','3col' =>'3 columns','4col' => '4 columns'),
                            'type' => 'select'
                        ),
						
                        array(
                            'name' => 'Select specific categories to display on homepage',
                            'desc' => 'Pick one or more
                            categories by starting to type the category name.',
                            'id' => TF_THEME_PREFIX . '_categories_select_categ',
                            'type' => 'multi',
                            'subtype' => 'category',
                        ),
						
						array(
                            'name' => 'Select specific portfolio categories to display on homepage',
                            'desc' => 'Pick one or more
                            portfolio categories by starting to type the category name.',
                            'id' => TF_THEME_PREFIX . '_portfolio_select_categ',
                            'type' => 'multi',
                            'subtype' => 'group',
                        ),
                        // page on homepage
                        array('name' => 'Select Page',
                            'desc' => 'Select the page',
                            'id' => TF_THEME_PREFIX . '_home_page',
                            'value' => 'image',
                            'options' => tfuse_list_page_options(),
                            'type' => 'select',
                        ),
                        array('name' => 'Use page options',
                            'desc' => 'Use page options',
                            'id' => TF_THEME_PREFIX . '_use_page_options',
                            'value' => 'false',
                            'type' => 'checkbox'
                        )
                    )
                ),
                array(
                    'name' => 'Homepage Slider',
                    'options' => array(
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
                            ),
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
                    )
                ),
                array(
                    'name' => 'Homepage Header',
                    'options' => array(
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
                    )
                ),
            )
        ),
        array(
            'name' => 'Blog',
            'id' => TF_THEME_PREFIX . '_blogpage',
            'headings' => array(
                array(
                    'name' => 'Blog Page Population',
                    'options' => array(
                        array('name' => 'Select Page',
                            'desc' => 'Select the page',
                            'id' => TF_THEME_PREFIX . '_blog_page',
                            'value' => 'image',
                            'options' => tfuse_list_page_options(),
                            'type' => 'select',
                        ),
                        array('name' => 'Blog Page Population',
                            'desc' => ' Select which categories to display on blogpage. More over you can choose to load a specific page or change the number of posts on the homepage from <a target="_blank" href="' . network_admin_url('options-reading.php') . '">here</a>',
                            'id' => TF_THEME_PREFIX . '_blogpage_category',
                            'value' => '',
                            'options' => array('all' => 'From All Categories', 'specific' => 'From Specific Categories','all_tax' => 'From Portfolio', 'specific_tax' => 'From Specific Portfolio Categories'),
                            'type' => 'select',
                            'install' => 'cat'
                        ),
                        array(
                            'name' => 'Select specific categories to display on blogpage',
                            'desc' => 'Pick one or more
                            categories by starting to type the category name.',
                            'id' => TF_THEME_PREFIX . '_categories_select_categ_blog',
                            'type' => 'multi',
                            'subtype' => 'category',
                        ),
						array('name' => 'Template',
                            'desc' => ' Select template type for portfolio.',
                            'id' => TF_THEME_PREFIX . '_template_portfolio_blog',
                            'value' => '',
                            'options' => array('1col' => '1 column', '2col' => '2 columns','3col' =>'3 columns','4col' => '4 columns'),
                            'type' => 'select'
                        ),
						array(
                            'name' => 'Select specific portfolio categories to display on homepage',
                            'desc' => 'Pick one or more
                            portfolio categories by starting to type the category name.',
                            'id' => TF_THEME_PREFIX . '_portfolio_select_categ_blog',
                            'type' => 'multi',
                            'subtype' => 'group',
                        )
                    )
                ),
                array(
                    'name' => 'Blog Page Slider',
                    'options' => array(
                        // Element of Hedear
                        array('name' => 'Element of Hedear',
                            'desc' => 'Select type of element on the header.',
                            'id' => TF_THEME_PREFIX . '_header_element_blog',
                            'value' => 'image',
                            'options' => array( 'slider' => 'Slider on Header', 'image' => 'Image on Header'),
                            'type' => 'select',
                        ),
                        // Select Slider
                        $this->ext->slider->model->has_sliders() ?
                            array(
                                'name' => 'Slider',
                                'desc' => 'Select a slider for your post. The sliders are created on the <a href="' . admin_url( 'admin.php?page=tf_slider_list' ) . '" target="_blank">Sliders page</a>.',
                                'id' => TF_THEME_PREFIX . '_select_slider_blog',
                                'value' => '',
                                'options' => $TFUSE->ext->slider->get_sliders_dropdown(),
                                'type' => 'select'
                            ) :
                            array(
                                'name' => 'Slider',
                                'desc' => '',
                                'id' => TF_THEME_PREFIX . '_select_slider_blog',
                                'value' => '',
                                'html' => 'No sliders created yet. You can start creating one <a href="' . admin_url('admin.php?page=tf_slider_list') . '">here</a>.',
                                'type' => 'raw'
                            ),
                        // Header Image
                        array('name' => 'Header Image',
                            'desc' => 'Upload an image for your header. It will be resized to 960x368 px',
                            'id' => TF_THEME_PREFIX . '_header_image_blog',
                            'value' => '',
                            'type' => 'upload',
                        ),
                        // Header Image Link
                        array('name' => 'Image Link',
                            'desc' => 'Add URL for Single Image Slider (Ex: http://themefuse.com)',
                            'id' => TF_THEME_PREFIX . '_header_image_link_blog',
                            'value' => '',
                            'type' => 'text',
                        ),
                        // Element of Hedear
                        array('name' => 'Image Target',
                            'desc' => 'Add Image Target',
                            'id' => TF_THEME_PREFIX . '_header_image_target_blog',
                            'value' => '_blank',
                            'options' => array( '_blank' => 'Open link in new window', '_self' => 'Open link in same window'),
                            'type' => 'select',
                        ),
                    )
                ),
                array(
                    'name' => 'Blog Page Header',
                    'options' => array(
                        // Header Welcome bar
                        array('name' => 'Welcome Bar',
                            'desc' => 'Check if you don\'t want the header bar to appear for this page',
                            'id' => TF_THEME_PREFIX . '_header_welcome_bar_blog',
                            'value' => 'true',
                            'type' => 'checkbox',
                        ),
                        // use template
                        array('name' => 'Use',
                            'desc' => 'Add Image Target',
                            'id' => TF_THEME_PREFIX . '_header_welcome_template_blog',
                            'value' => 'our',
                            'options' => array( 'our' => 'Our template', 'your' => 'Make your own'),
                            'type' => 'select'
                        ),
                        // Make your own header bar by using custom text, html, shortcodes.
                        array('name' => 'Custom',
                            'desc' => 'Make your own header bar by using custom text, html, shortcodes.',
                            'id' => TF_THEME_PREFIX . '_header_your_template_blog',
                            'value' => '',
                            'type' => 'textarea',
                        ),
                        // Header Welcome Title
                        array('name' => 'Title',
                            'desc' => 'Enter your preferred Header Bar Title for this page.',
                            'id' => TF_THEME_PREFIX . '_header_welcome_title_blog',
                            'value' => '',
                            'type' => 'text',
                        ),
                        // Header Welcome Subtitle
                        array('name' => 'Subtitle',
                            'desc' => 'Enter your preferred Header Bar Subitle for this page.',
                            'id' => TF_THEME_PREFIX . '_header_welcome_subtitle_blog',
                            'value' => '',
                            'type' => 'text',
                        ),
                        // Header Welcome Icon
                        array('name' => 'Icon',
                            'desc' => 'Upload an icon for your Header Bar, or specify the icon address of your online icon. (http://yoursite.com/icon.png)',
                            'id' => TF_THEME_PREFIX . '_header_welcome_icon_blog',
                            'value' => '',
                            'type' => 'upload',
                        ),
                        // Make your own header bar by using custom text, html, shortcodes.
                        array('name' => 'Shortcode',
                            'desc' => 'Use a shortcode that you whant to appear on the right side of the header bar ([search], [button link="#" size="large"]View Portfolio[/button]) or other text/html',
                            'id' => TF_THEME_PREFIX . '_header_our_template_blog',
                            'value' => '',
                            'type' => 'textarea',
                        )
                    )
                ),
            )
        ),
        array(
            'name' => 'Posts',
            'id' => TF_THEME_PREFIX . '_posts',
            'headings' => array(
                array(
                    'name' => 'Default Post Options',
                    'options' => array(
                        // Post Content
                        array('name' => 'Post Content',
                            'desc' => 'Select if you want to show the full content (use <em>more</em> tag) or the excerpt on posts listings (categories).',
                            'id' => TF_THEME_PREFIX . '_post_content',
                            'value' => 'excerpt',
                            'options' => array('excerpt' => 'The Excerpt', 'content' => 'Full Content'),
                            'type' => 'select',
                            'divider' => true
                        ),
                        // Single Image Position
                        array('name' => 'Image Position',
                            'desc' => 'Select your preferred image alignment',
                            'id' => TF_THEME_PREFIX . '_single_image_position',
                            'value' => 'alignleft',
                            'type' => 'images',
                            'options' => array('alignleft' => array($url . 'left_off.png', 'Align to the left'), 'alignright' => array($url . 'right_off.png', 'Align to the right'))
                        ),
                        // Single Image Dimensions
                        array('name' => 'Image Resize (px)',
                            'desc' => 'These are the default width and height values. If you want to resize the image change the values with your own. If you input only one, the image will get resized with constrained proportions based on the one you specified.',
                            'id' => TF_THEME_PREFIX . '_single_image_dimensions',
                            'value' => array(612, 252),
                            'type' => 'textarray',
                            'divider' => true
                        ),
                        // Thumbnail Posts Position
                        array('name' => 'Thumbnail Position',
                            'desc' => 'Select your preferred thumbnail alignment',
                            'id' => TF_THEME_PREFIX . '_thumbnail_position',
                            'value' => 'alignleft',
                            'type' => 'images',
                            'options' => array('alignleft' => array($url . 'left_off.png', 'Align to the left'), 'alignright' => array($url . 'right_off.png', 'Align to the right'))
                        ),
                        // Posts Thumbnail Dimensions
                        array('name' => 'Thumbnail Resize (px)',
                            'desc' => 'These are the default width and height values. If you want to resize the thumbnail change the values with your own. If you input only one, the thumbnail will get resized with constrained proportions based on the one you specified.',
                            'id' => TF_THEME_PREFIX . '_thumbnail_dimensions',
                            'value' => array(580, 349),
                            'type' => 'textarray',
                            'divider' => true
                        ),
                        // Video Position
                        array('name' => 'Video Position',
                            'desc' => 'Select your preferred video alignment',
                            'id' => TF_THEME_PREFIX . '_video_position',
                            'value' => 'alignleft',
                            'type' => 'images',
                            'options' => array('alignleft' => array($url . 'left_off.png', 'Align to the left'), 'alignright' => array($url . 'right_off.png', 'Align to the right'))
                        ),
                        // Video Dimensions
                        array('name' => 'Video Resize (px)',
                            'desc' => 'These are the default width and height values. If you want to resize the video change the values with your own. If you input only one, the video will get resized with constrained proportions based on the one you specified.',
                            'id' => TF_THEME_PREFIX . '_video_dimensions',
                            'value' => array(580, 349),
                            'type' => 'textarray'
                        )
                    )
                )
            )
        ),
        array(
            'name' => 'Footer',
            'id' => TF_THEME_PREFIX . '_footer',
            'headings' => array(
                array(
                    'name' => 'Footer Content',
                    'options' => array(
                        // Enable Footer Shortcodes
                        array('name' => 'Enable Footer Shortcodes',
                            'desc' => 'This will enable footer shortcodes.',
                            'id' => TF_THEME_PREFIX . '_enable_footer_shortcodes',
                            'value' => '',
                            'type' => 'checkbox'
                        ),
                        // Footer Shortcodes
                        array('name' => 'Footer Shortcodes',
                            'desc' => 'In this textarea you can input your prefered custom shotcodes.',
                            'id' => TF_THEME_PREFIX . '_footer_shortcodes',
                            'value' => '',
                            'type' => 'textarea'
                        )
                    )
                )
            )
        )
    )
);

?>