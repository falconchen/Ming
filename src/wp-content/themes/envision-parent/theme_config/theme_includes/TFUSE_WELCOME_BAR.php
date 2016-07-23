<?php
if ( !function_exists('tfuse_welcome_bar')):

    function tfuse_welcome_bar($before = '', $after = '', $echo = true){

        global $TFUSE,$is_tf_front_page,$is_tf_blog_page;

        $tf_wlc_opt = array();
        if ( $is_tf_blog_page ){
            $tf_wlc_opt['welcome']   = tfuse_options('header_welcome_bar_blog');
            $tf_wlc_opt['template']  = tfuse_options('header_welcome_template_blog');
            $tf_wlc_opt['cust_txt']  = tfuse_options('header_your_template_blog');
            $tf_wlc_opt['our_txt']   = apply_filters('themefuse_shortcodes',tfuse_options('header_our_template_blog'));
            $tf_wlc_opt['title']     = tfuse_options('header_welcome_title_blog');
            $tf_wlc_opt['subtitle']  = tfuse_options('header_welcome_subtitle_blog');
            $tf_wlc_opt['icon']      = tfuse_options('header_welcome_icon_blog');
        }
        elseif ( $is_tf_front_page ){
            if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page'){
                $tf_wlc_opt['welcome']   = tfuse_page_options('header_welcome_bar');
                $tf_wlc_opt['template']  = tfuse_page_options('header_welcome_template');
                $tf_wlc_opt['cust_txt']  = tfuse_page_options('header_your_template');
                $tf_wlc_opt['our_txt']   = apply_filters('themefuse_shortcodes',tfuse_page_options('header_our_template'));
                $tf_wlc_opt['title']     = tfuse_page_options('header_welcome_title');
                $tf_wlc_opt['subtitle']  = tfuse_page_options('header_welcome_subtitle');
                $tf_wlc_opt['icon']      = tfuse_page_options('header_welcome_icon');
            }
            else{
                $tf_wlc_opt['welcome']   = tfuse_options('header_welcome_bar');
                $tf_wlc_opt['template']  = tfuse_options('header_welcome_template');
                $tf_wlc_opt['cust_txt']  = tfuse_options('header_your_template');
                $tf_wlc_opt['our_txt']   = apply_filters('themefuse_shortcodes',tfuse_options('header_our_template'));
                $tf_wlc_opt['title']     = tfuse_options('header_welcome_title');
                $tf_wlc_opt['subtitle']  = tfuse_options('header_welcome_subtitle');
                $tf_wlc_opt['icon']      = tfuse_options('header_welcome_icon');
            }
        }
        elseif ( is_singular() ){
            $tf_wlc_opt['welcome']   = tfuse_page_options('header_welcome_bar');
            $tf_wlc_opt['template']  = tfuse_page_options('header_welcome_template');
            $tf_wlc_opt['cust_txt']  = tfuse_page_options('header_your_template');
            $tf_wlc_opt['our_txt']   = apply_filters('themefuse_shortcodes',tfuse_page_options('header_our_template'));
            $tf_wlc_opt['title']     = tfuse_page_options('header_welcome_title');
            $tf_wlc_opt['subtitle']  = tfuse_page_options('header_welcome_subtitle');
            $tf_wlc_opt['icon']      = tfuse_page_options('header_welcome_icon');
        }
        elseif ( is_category()){
             $cat_ID = get_query_var('cat');
             $tf_wlc_opt['welcome']   = tfuse_options('header_welcome_bar','',$cat_ID);
             $tf_wlc_opt['template']  = tfuse_options('header_welcome_template','',$cat_ID);
             $tf_wlc_opt['cust_txt']  = tfuse_options('header_your_template','',$cat_ID);
             $tf_wlc_opt['our_txt']   = apply_filters('themefuse_shortcodes',tfuse_options('header_our_template','',$cat_ID));
             $tf_wlc_opt['title']     = tfuse_options('header_welcome_title','',$cat_ID);
             $tf_wlc_opt['subtitle']  = tfuse_options('header_welcome_subtitle','',$cat_ID);
             $tf_wlc_opt['icon']      = tfuse_options('header_welcome_icon','',$cat_ID);
        }
        elseif ( is_tax()){
             $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
             $cat_ID = $term->term_id;
             $tf_wlc_opt['welcome']   = tfuse_options('header_welcome_bar','',$cat_ID);
             $tf_wlc_opt['template']  = tfuse_options('header_welcome_template','',$cat_ID);
             $tf_wlc_opt['cust_txt']  = tfuse_options('header_your_template','',$cat_ID);
             $tf_wlc_opt['our_txt']   = apply_filters('themefuse_shortcodes',tfuse_options('header_our_template','',$cat_ID));
             $tf_wlc_opt['title']     = tfuse_options('header_welcome_title','',$cat_ID);
             $tf_wlc_opt['subtitle']  = tfuse_options('header_welcome_subtitle','',$cat_ID);
             $tf_wlc_opt['icon']      = tfuse_options('header_welcome_icon','',$cat_ID);
        }
        elseif( is_search() ){
            $tf_wlc_opt['welcome']   = true;
            $tf_wlc_opt['template']  = 'genr';
            $tf_wlc_opt['cust_txt']  = '';
            $tf_wlc_opt['our_txt']   = '';
            $search = get_search_query();
            $tf_wlc_opt['title']     = __('Search Results for ', 'tfuse') . '<span>' . sprintf(__('\'%s\''), $search) . '</span>';
            $allsearch = new WP_Query( "s={$search}&showposts=-1" );
            $count = $allsearch->post_count;
            $breadcrumbs = "Your search generated $count results";
            $tf_wlc_opt['subtitle']  = "Your search generated $count results";
            $tf_wlc_opt['icon']      = get_template_directory_uri() . '/images/icon_search.png';
        }
        elseif( is_day() || is_month() || is_year() ){
            $tf_wlc_opt['welcome']   = true;
            $tf_wlc_opt['template']  = 'genr';
            $tf_wlc_opt['cust_txt']  = '';
            $tf_wlc_opt['our_txt']   = apply_filters('themefuse_shortcodes','[search]');
            $tf_wlc_opt['title']     = __('Archive for', 'tfuse') . ' <span>' . get_the_time('F, Y'). '</span>';
            $tf_wlc_opt['subtitle']  = '';
            $tf_wlc_opt['icon']      = '';
        }
        elseif( is_404() ){
            $tf_wlc_opt['welcome']   = true;
            $tf_wlc_opt['template']  = 'genr';
            $tf_wlc_opt['cust_txt']  = '';
            $tf_wlc_opt['our_txt']   = apply_filters('themefuse_shortcodes','[search]');
            $tf_wlc_opt['title']     = __('Page Not Found - <span>404 error</span>', 'tfuse');
            $tf_wlc_opt['subtitle']  = '';
            $tf_wlc_opt['icon']      = '';
        }
        else
            $tf_wlc_opt['welcome']   = false;

        $return = '';

        $return .= '<div class="welcome_bar">';
        if ( $tf_wlc_opt['welcome']  ){
            $return .= '<div class="container_12 bar">';

            if ( $tf_wlc_opt['template'] == 'our' || $tf_wlc_opt['template'] == 'genr' ){

                    $return .= ($tf_wlc_opt['icon'] != '') ? '<div class="bar-icon"><img src="'.$tf_wlc_opt['icon'].'" width="72" height="60" /></div>' : '';

                    $return .= '<div class="bar-title">';
                        $return .= ($tf_wlc_opt['title'] != '') ? '<h1>'.$tf_wlc_opt['title'].'</h1>' : '';
                        $return .= ($tf_wlc_opt['subtitle'] != '') ? '<div class="breadcrumbs">'.$tf_wlc_opt['subtitle'].'</div>' : '';
                    $return .= '</div>';

                    $return .= ($tf_wlc_opt['our_txt'] != '') ? '<div class="bar-right">'.$tf_wlc_opt['our_txt'].'</div>' : '';
            }
            elseif ( $tf_wlc_opt['template'] == 'your' )
                $return .= apply_filters('themefuse_shortcodes',$tf_wlc_opt['cust_txt']);
            else
                return false;

             $return .= '<div class="clear"></div>';
            $return .= '</div>';
        }
        $return .= '</div>';

        if ( $echo )
            echo $return;
        else
            return $return;
    }
endif;
