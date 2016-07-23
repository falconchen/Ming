<?php

add_action( 'wp_print_styles', 'tfuse_add_css' );
add_action( 'wp_print_scripts', 'tfuse_add_js' );

if ( ! function_exists( 'tfuse_add_css' ) ) :
/**
 * This function include files of css.
 */
    function tfuse_add_css()
    {
        $template_directory = get_template_directory_uri();

        wp_register_style( 'prettyPhoto', TFUSE_ADMIN_CSS . '/prettyPhoto.css', false, '3.1.4' );
        wp_enqueue_style( 'prettyPhoto' );

        wp_register_style( 'jquery-ui-custom', tfuse_get_file_uri('/css/ui-lightness/jquery-ui-1.8.4.custom.css'), false, '1.8.4' );
        wp_enqueue_style( 'jquery-ui-custom' );

        wp_register_style( 'selectmenu', tfuse_get_file_uri('/css/ui.selectmenu.css'), false, '1.1.0' );
        wp_enqueue_style( 'selectmenu' );

        wp_register_style( 'custom_admin', tfuse_get_file_uri('/css/custom_admin.css'), false, '' );
        wp_enqueue_style( 'custom_admin`' );
        
        wp_register_style( 'skin', tfuse_get_file_uri('/images/skins/tango/skin.css'), false, '0.2.8' );
        wp_enqueue_style( 'skin' );


        $tfuse_browser_detect = tfuse_browser_body_class();
        if ( $tfuse_browser_detect[0] == 'chrome')
        {
            wp_register_style( 'stylechr', tfuse_get_file_uri('/theme_config/extensions/contactform/static/css/stylechr.css') );
            wp_enqueue_style( 'stylechr' );
        }
        if ( $tfuse_browser_detect[0] == 'ie' || $tfuse_browser_detect[0] == 'ie6' || $tfuse_browser_detect[0] == 'ie7' || $tfuse_browser_detect[0] == 'ie8' || $tfuse_browser_detect[0] == 'ie9' )
        {
            wp_register_style( 'styles_ie', tfuse_get_file_uri('/css/styles_ie.css') );
            wp_enqueue_style( 'styles_ie' );
        }

    }
endif;


if ( ! function_exists( 'tfuse_add_js' ) ) :
/**
 * This function include files of javascript.
 */
    function tfuse_add_js()
    {
        $template_directory = get_template_directory_uri();

        wp_enqueue_script( 'jquery' );

        wp_register_script( 'prettyPhoto', TFUSE_ADMIN_JS . '/jquery.prettyPhoto.js', array('jquery'), '3.1.4', true );
        wp_enqueue_script( 'prettyPhoto' );

        wp_register_script( 'jcarousellite_1.3', tfuse_get_file_uri('/js/jcarousellite_1.3.min.js'), array('general'), '3.1.2', true );
        wp_enqueue_script( 'jcarousellite_1.3' );

        wp_register_script( 'jquery.jcarousel.min', tfuse_get_file_uri('/js/jquery.jcarousel.min.js'), array('general'), '3.1.2', true );
        wp_enqueue_script( 'jquery.jcarousel.min' );

        wp_register_script( 'jquery-ui-custom', tfuse_get_file_uri('/js/jquery-ui-1.9.2.custom.min.js'), array('jquery'), '1.8.23', true );
        wp_enqueue_script( 'jquery-ui-custom' );

        wp_register_script( 'jquery.tools', tfuse_get_file_uri('/js/jquery.tools.min.js'), array('jquery'), '1.2.5', true );
        wp_enqueue_script( 'jquery.tools' );

        wp_register_script( 'slides.min', tfuse_get_file_uri('/js/slides.min.jquery.js'), array('jquery'), '1.2.5', true );
        wp_enqueue_script( 'slides.min' );

        wp_register_script( 'jquery.easing', tfuse_get_file_uri('/js/jquery.easing.1.3.js'), array('jquery'), '1.3', true );
        wp_enqueue_script( 'jquery.easing' );

        wp_register_script( 'jquery.mousewheel', tfuse_get_file_uri('/js/jquery.mousewheel.min.js'), array('jquery.easing'), '1.3', true );
        wp_enqueue_script( 'jquery.mousewheel' );

        wp_register_script( 'ui.selectmenu', tfuse_get_file_uri('/js/ui.selectmenu.js'), array('jquery'), '1.1.0', true );
        wp_enqueue_script( 'ui.selectmenu' );

        wp_register_script( 'styled.selectmenu', tfuse_get_file_uri('/js/styled.selectmenu.js'), array('jquery'), '1.0', true );
        wp_enqueue_script( 'styled.selectmenu' );

        if ( !tfuse_options('disable_preload_css') )
        {
            wp_register_script( 'preloadCssImages', tfuse_get_file_uri('/js/preloadCssImages.js'), array('jquery'), '5.0', true );
            wp_enqueue_script( 'preloadCssImages' );
        }

        wp_register_script( 'columnhover', tfuse_get_file_uri('/js/jquery.columnhover.pack.js'), array('jquery'), '2.0', true );
        wp_enqueue_script( 'columnhover' );

        wp_register_script( 'innerfade', tfuse_get_file_uri('/js/jquery.innerfade.js'), array('jquery'), '2.0', true );
        wp_enqueue_script( 'innerfade' );

        // general.js can be overridden in a child theme by copying it in child theme's js folder
        wp_register_script( 'general', tfuse_get_file_uri('/js/general.js'), array('jquery'), '2.0', true );
        wp_enqueue_script( 'general' );

    }
endif;
