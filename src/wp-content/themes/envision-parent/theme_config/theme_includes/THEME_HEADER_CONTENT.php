<?php

if ( ! function_exists( 'tfuse_get_header_content' ) ):
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which runs
 * before the init hook. The init hook is too late for some features, such as indicating
 * support post thumbnails.
 *
 * To override tfuse_slider_type() in a child theme, add your own tfuse_slider_type to your child theme's
 * functions.php file.
 */

    function tfuse_get_header_content()
    {
        global $TFUSE, $post, $header_image,$is_tf_front_page,$is_tf_blog_page;
        $posts = $header_element = $header_image = $slider = null;

        if ( $is_tf_blog_page )
        {
            $header_element = tfuse_options('header_element_blog');
            if ( 'slider' == $header_element )
                $slider = tfuse_options('select_slider_blog');
            elseif ( 'image' == $header_element ){
                $header_image['src']    = tfuse_options('header_image_blog');
                $header_image['url']    = tfuse_options('header_image_link_blog');
                $header_image['target'] = tfuse_options('header_image_target_blog');
            }
        }
        elseif ( $is_tf_front_page )
        {
            if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page'){
                $page_id = $post->ID;
                $header_element = tfuse_page_options('header_element','',$page_id);
                if ( 'slider' == $header_element )
                    $slider = tfuse_page_options('select_slider','',$page_id);
                elseif ( 'image' == $header_element ){
                    $header_image['src']    = tfuse_page_options('header_image','',$page_id);
                    $header_image['url']    = tfuse_page_options('header_image_link','',$page_id);
                    $header_image['target'] = tfuse_page_options('header_image_target','',$page_id);
                }
            }
            else{
                $header_element = tfuse_options('header_element');
                if ( 'slider' == $header_element )
                    $slider = tfuse_options('select_slider');
                elseif ( 'image' == $header_element ){
                    $header_image['src']    = tfuse_options('header_image');
                    $header_image['url']    = tfuse_options('header_image_link');
                    $header_image['target'] = tfuse_options('header_image_target');
                }
            }
        }
        elseif ( is_singular() )
        {
            $ID = $post->ID;
            $header_element = tfuse_page_options('header_element');
            if ( 'slider' == $header_element )
                $slider = tfuse_page_options('select_slider');
            elseif ( 'image' == $header_element ){
                $header_image['src']    = tfuse_page_options('header_image');
                $header_image['url']    = tfuse_page_options('header_image_link');
                $header_image['target'] = tfuse_page_options('header_image_target');
            }
        }
        elseif ( is_category() )
        {
            $ID = get_query_var('cat');
            $header_element = tfuse_options('header_element', null, $ID);
            if ( 'slider' == $header_element )
                $slider = tfuse_options('select_slider', null, $ID);
            elseif ( 'image' == $header_element ){
                $header_image['src']    = tfuse_options('header_image', null, $ID);
                $header_image['url']    = tfuse_options('header_image_link', null, $ID);
                $header_image['target'] = tfuse_options('header_image_target', null, $ID);
            }
        }
        elseif ( is_tax() )
        {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $ID = $term->term_id;
            $header_element = tfuse_options('header_element', null, $ID);
            if ( 'slider' == $header_element )
                $slider = tfuse_options('select_slider', null, $ID);
            elseif ( 'image' == $header_element ){
                $header_image['src']    = tfuse_options('header_image', null, $ID);
                $header_image['url']    = tfuse_options('header_image_link', null, $ID);
                $header_image['target'] = tfuse_options('header_image_target', null, $ID);
            }
        }

        if ( $header_element != 'slider' )
        {
            get_template_part( 'header', 'image' );
            return;
        }
        elseif ( !$slider )
            return;

        $slider = $TFUSE->ext->slider->model->get_slider($slider);

        if ( is_array($slider['slides']) ) :
            $slider_image_resize = ( isset($slider['general']['slider_image_resize']) && $slider['general']['slider_image_resize'] == 'true' ) ? true : false;
            foreach ($slider['slides'] as $k => $slide) :
                $image = new TF_GET_IMAGE();

                if ( $slider['design'] == 'nivo')
                    $slider['slides'][$k]['slide_src'] = $image->width(898)->height(362)->src($slide['slide_src'])->resize($slider_image_resize)->get_src();
                elseif( $slider['design'] == 'animated')
                    $slider['slides'][$k]['slide_src'] = $image->width(960)->height(468)->src($slide['slide_src'])->resize($slider_image_resize)->get_src();
                elseif( $slider['design'] == 'flash')
                    $slider['slides'][$k]['slide_src'] = $image->width(360)->height(295)->src($slide['slide_src'])->resize($slider_image_resize)->get_src();
                elseif( $slider['design'] == 'text_content' && $slide['slide_align_img'] == 'afullwidth')
                    $slider['slides'][$k]['slide_src'] = $image->width(885)->height(360)->src($slide['slide_src'])->resize($slider_image_resize)->get_src();
                else
                    @$slider['slides'][$k]['slide_src'] = $image->width(960)->height(368)->src($slide['slide_src'])->resize($slider_image_resize)->get_src();
            endforeach;
        endif;

        if ( empty($slider['slides']) ) return;

        include_once(locate_template( '/theme_config/extensions/slider/designs/'.$slider['design'].'/template.php' ));
    }

endif;
add_action('tfuse_header_content', 'tfuse_get_header_content');
