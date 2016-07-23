<?php
if (!function_exists('tfuse_browser_body_class')):
/* This Function Add the classes of body_class()  Function
 * To override tfuse_browser_body_class() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
*/

    add_filter('body_class', 'tfuse_browser_body_class');

    function tfuse_browser_body_class() {

        global $is_lynx, $is_gecko, $is_IE, $is_opera, $is_NS4, $is_safari, $is_chrome, $is_iphone;

        if ($is_lynx)
            $classes[] = 'lynx';
        elseif ($is_gecko)
            $classes[] = 'gecko';
        elseif ($is_opera)
            $classes[] = 'opera';
        elseif ($is_NS4)
            $classes[] = 'ns4';
        elseif ($is_safari)
            $classes[] = 'safari';
        elseif ($is_chrome)
            $classes[] = 'chrome';
        elseif ($is_IE) {
            $browser = $_SERVER['HTTP_USER_AGENT'];
            $browser = substr("$browser", 25, 8);
            if ($browser == "MSIE 7.0")
                $classes[] = 'ie7';
            elseif ($browser == "MSIE 6.0")
                $classes[] = 'ie6';
            elseif ($browser == "MSIE 8.0")
                $classes[] = 'ie8';
            else
                $classes[] = 'ie';
        }
        else
            $classes[] = 'unknown';

        if ($is_iphone)
            $classes[] = 'iphone';

        return $classes;
    } // End function tfuse_browser_body_class()
endif;

if (!function_exists('tfuse_class')) :
/* This Function Add the classes for middle container
 * To override tfuse_class() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
*/
    function tfuse_class($param, $return = false) {
        global $post,$is_tf_front_page,$is_tf_blog_page;
        $tfuse_class = '';
        $cat_templ = '';
        $sidebar_position = tfuse_sidebar_position();

        $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
        if($is_tf_front_page)
        { 
                $cat_templ = tfuse_options('template_portfolio');
        }
        elseif($is_tf_blog_page)
        {  
            $cat_templ = tfuse_options('template_portfolio_blog');
        }
        elseif ( is_tax())
        {
			
            $ID = $term->term_id;
            $cat_templ        = tfuse_options('portfolio_tax_template','',$ID);
        }


        if ($param == 'middle') { 
            if (is_front_page() || $is_tf_blog_page) {
                if ($sidebar_position == 'left' && $cat_templ != '3col' && $cat_templ != '4col'  )
                    $tfuse_class = ' class="middle homepage" id="sidebar_left"';
                elseif ($sidebar_position == 'right' && $cat_templ != '3col' && $cat_templ != '4col' )
                    $tfuse_class = ' class="middle homepage" id="sidebar_right"';
                else
                    $tfuse_class = ' class="middle homepage" id="sidebar_disable"';
            }
            else {
                if ($sidebar_position == 'left' && $cat_templ != '3col' && $cat_templ != '4col' )
                    $tfuse_class = ' class="middle" id="sidebar_left"';
                elseif ($sidebar_position == 'right' && $cat_templ != '3col' && $cat_templ != '4col' )
                {

                    $tfuse_class = ' class="middle" id="sidebar_right"';
                }
                else
                    $tfuse_class = ' class="middle" id="sidebar_disable"';
            }
        }
        elseif ($param == 'gall' && is_tax() || $param == 'gall' && $is_tf_front_page || $param == 'gall' && $is_tf_blog_page){
            if ( $cat_templ == '1col' || $cat_templ == '')
                $tfuse_class = ' class="gallery-list gl_col_1"';
            elseif ( $cat_templ == '2col')
                $tfuse_class = ' class="gallery-list gl_col_2"';
            elseif ( $cat_templ == '3col')
                $tfuse_class = ' class="gallery-list gl_col_3"';
            elseif ( $cat_templ == '4col')
                $tfuse_class = ' class="gallery-list gl_col_4"';
        }

        if ($return)
            return $tfuse_class;
        else
            echo $tfuse_class;
    }
endif;

if (!function_exists('tfuse_sidebar_position')):
/* This Function Set sidebar position
 * To override tfuse_sidebar_position() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
*/
    function tfuse_sidebar_position() {
        global $TFUSE;

        $sidebar_position = $TFUSE->ext->sidebars->current_position;
        if ( empty($sidebar_position) ) $sidebar_position = 'full';

        return $sidebar_position;
    }

// End function tfuse_sidebar_position()
endif;


if (!function_exists('tfuse_count_post_visits')) :
/**
 * tfuse_count_post_visits.
 * 
 * To override tfuse_count_post_visits() in a child theme, add your own tfuse_count_post_visits() 
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_count_post_visits()
    {
        if ( !is_single() ) return;

        global $post;

        $views = get_post_meta($post->ID, TF_THEME_PREFIX . '_post_viewed', true);
        $views = intval($views);
        tf_update_post_meta( $post->ID, TF_THEME_PREFIX . '_post_viewed', ++$views);
    }

// End function tfuse_count_post_visits()
endif;

if (!function_exists('tfuse_action_comments')) :
/**
 *  This function disable post commetns.
 *
 * To override tfuse_action_comments() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_action_comments() {
        global $post;
        if (!tfuse_page_options('disable_comments'))
            comments_template( '', true );
    }

    add_action('tfuse_comments', 'tfuse_action_comments');
endif;


if (!function_exists('tfuse_get_comments')):
/**
 *  Get post comments for a specific post.
 *
 * To override tfuse_get_comments() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_get_comments($return = TRUE, $post_ID) {
        $num_comments = get_comments_number($post_ID);

        if (comments_open($post_ID)) {
            if ($num_comments == 0) {
                $comments = __('No Comments');
            } elseif ($num_comments > 1) {
                $comments = $num_comments . __(' Comments');
            } else {
                $comments = "1 Comment";
            }
            $write_comments = '<a class="link-comments" href="' . get_comments_link() . '">' . $comments . '</a>';
        } else {
            $write_comments = __('Comments are off');
        }
        if ($return)
            return $write_comments;
        else
            echo $write_comments;
    }

endif;


if (!function_exists('tfuse_category_on_front_page')) :
    /**
     * Dsiplay homepage category
     *
     * To override tfuse_category_on_front_page() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_category_on_front_page()
    {
        if ( !is_front_page() ) return;

        global $is_tf_front_page,$homepage_categ,$wp_query;
        $is_tf_front_page = false;

        $homepage_category = tfuse_options('homepage_category');
        $homepage_category = explode(",",$homepage_category);
        foreach($homepage_category as $homepage)
        {
            $homepage_categ = $homepage;
        }

        if($homepage_categ == 'specific')
        { 
            $is_tf_front_page = true;
            $archive = 'archive.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $specific = tfuse_options('categories_select_categ');

            $items = get_option('posts_per_page');
            $ids = explode(",",$specific);
            $posts = array(); 

            $args = array(
                'cat' => $specific,
                'orderby' => 'date',
                'paged' => $paged
            );
            $posts = query_posts($args);


            include_once(locate_template($archive));

            return;
        }
        elseif($homepage_categ == 'page')
        {
            global $front_page;
            $is_tf_front_page = true;
            $front_page = true;
            $archive = 'page.php';
            $page_id = tfuse_options('home_page');

            $args=array(
                'page_id' => $page_id,
                'post_type' => 'page',
                'post_status' => 'publish',
                'posts_per_page' => 1,
                'ignore_sticky_posts'=> 1
            );
            query_posts($args);
            include_once(locate_template($archive));
            wp_reset_query();
            die();
        }
        elseif($homepage_categ == 'all')
        {
            $archive = 'archive.php';

            $is_tf_front_page = true;
            
            include_once(locate_template($archive));
            die();
        }
        elseif($homepage_categ == 'all_tax')
        {
            $archive = 'archive-portfolio.php';
            
            include_once(locate_template($archive));
            die();
        }
        elseif($homepage_categ == 'specific_tax')
        {
            $archive = 'archive-portfolio.php';
           
            include_once(locate_template($archive));
            return;
        }

    }

// End function tfuse_category_on_front_page()
endif;

function tfuse_pre_get_posts($query){
    
    if ( $query->is_home() && $query->is_main_query() ) {
        global $is_tf_front_page;
         $is_tf_front_page = true;
         $homepage_category = tfuse_options('homepage_category');
         if($homepage_category == 'all_tax') 
         {
             $cat_templ = tfuse_options('template_portfolio');
			
			if($cat_templ == '1col')
				$items = 4;
			elseif($cat_templ == '2col')
				$items = 6;
			elseif($cat_templ == '3col')
				$items = 6;
			elseif($cat_templ == '4col')
				$items = 12;
            $query->set( 'posts_per_page', $items );
            $query->set( 'post_type', array('portfolio') );
         }
         elseif($homepage_category == 'specific_tax'){
             $cat_templ = tfuse_options('template_portfolio');
			if($cat_templ == '1col')
				$items = 4;
			elseif($cat_templ == '2col')
				$items = 6;
			elseif($cat_templ == '3col')
				$items = 6;
			elseif($cat_templ == '4col')
				$items = 12;
            $homepage_tax = tfuse_options('portfolio_select_categ');
            $homepage_tax = explode(",",$homepage_tax);
            $query->set( 'posts_per_page', $items );
            $query->set( 'post_type', array('portfolio') );
            $query->set( 'tax_query', array(
                    array(
                        'taxonomy' => 'group',
                        'field' => 'id',
                        'terms' => $homepage_tax,
                    ) ));
         }

    }
    return $query;
}
add_filter('pre_get_posts', 'tfuse_pre_get_posts');

if (!function_exists('tfuse_category_on_blog_page')) :
    /**
     * Dsiplay blogpage category
     *
     * To override tfuse_category_on_blog_page() in a child theme, add your own tfuse_count_post_visits()
     * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
     */

    function tfuse_category_on_blog_page()
    {
        global $is_tf_blog_page,$blogpage_categ;
        if ( !$is_tf_blog_page ) return;
        $is_tf_blog_page = false;

        $blogpage_category = tfuse_options('blogpage_category');
        $blogpage_category = explode(",",$blogpage_category);
        foreach($blogpage_category as $blogpage)
        {
            $blogpage_categ = $blogpage;
        }

        if($blogpage_categ == 'specific')
        {
            $is_tf_blog_page = true;
            $archive = 'archive.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

            $specific = tfuse_options('categories_select_categ_blog');

            $items = get_option('posts_per_page');
            $ids = explode(",",$specific);
            $posts = array(); $num_post = 0;
            foreach ($ids as $id){
                $posts[] = get_posts(array('category' => $id));
            }
            foreach($posts as $post)
            {
                $num_posts = count($post);
                $num_post += $num_posts;
            }
            $max = $num_post/$items;
            if($num_posts%$items) $max++;

            $args = array(
                'cat' => $specific,
                'orderby' => 'date',
                'paged' => $paged
            );
            query_posts($args);
            wp_localize_script(
                'tf-load-posts',
                'nr_posts',
                array(
                    'max' => $max
                )
            );
            include_once(locate_template($archive));
            return;
        }
        elseif($blogpage_categ == 'all')
        {
            $is_tf_blog_page = true;
            $archive = 'archive.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $categories = get_categories();

            $ids = array();
            foreach($categories as $cats){
                $ids[] = $cats -> term_id;
            }
            $items = get_option('posts_per_page');
            $posts = array(); $num_post = 0;

            foreach ($ids as $id){
                $posts[] = get_posts(array('category' => $id));
            }
            foreach($posts as $post)
            {
                $num_posts = count($post);
                $num_post += $num_posts;
            }
            $max = $num_post/$items;
            if($num_posts%$items) $max++;

            $args = array(
                'orderby' => 'date',
                'paged' => $paged
            );
            query_posts($args);
            wp_localize_script(
                'tf-load-posts',
                'nr_posts',
                array(
                    'max' => $max
                )
            );
            include_once(locate_template($archive));
            return;
        }
        elseif($blogpage_categ == 'all')
        {
            $archive = 'archive.php';

            $is_tf_blog_page = true;
            
            include_once(locate_template($archive));
            die();
        }
        elseif($blogpage_categ == 'all_tax')
        {
            $archive = 'archive-portfolio.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
            $is_tf_blog_page = true;
            
            $taxonomies = get_terms('group', array('hide_empty' => 0));

            $slug=array();
            foreach($taxonomies as $tax){
                $slug[]=$tax->slug;
            }
            $cat_templ = tfuse_options('template_portfolio_blog');
			if($cat_templ == '1col')
				$items = 4;
			elseif($cat_templ == '2col')
				$items = 6;
			elseif($cat_templ == '3col')
				$items = 6;
			elseif($cat_templ == '4col')
				$items = 12;
            $args = array(
                'paged' => $paged,
                'posts_per_page' => $items,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'group',
                        'field' => 'slug',
                        'terms' => $slug,
                    ),
                )
            );
            $posts = query_posts ($args);
            wp_reset_postdata();
            include_once(locate_template($archive));
            return;
        }
        elseif($blogpage_categ == 'specific_tax')
        {   
            $is_tf_blog_page = true;
            $archive = 'archive-portfolio.php';
            $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;            
            $taxonomies = get_terms('group', array('hide_empty' => 0));
            $homepage_tax = tfuse_options('portfolio_select_categ_blog');
            $homepage_tax = explode(",",$homepage_tax);

            $slug=array();
            foreach($taxonomies as $tax){
                $slug[]=$tax->slug;
            }
            $cat_templ = tfuse_options('template_portfolio_blog');
			if($cat_templ == '1col')
				$items = 4;
			elseif($cat_templ == '2col')
				$items = 6;
			elseif($cat_templ == '3col')
				$items = 6;
			elseif($cat_templ == '4col')
				$items = 12;
            $args = array(
                'paged' => $paged,
                'posts_per_page' => $items,
                'tax_query' => array(
                    array(
                        'taxonomy' => 'group',
                        'field' => 'id',
                        'terms' => $homepage_tax,
                    ),
                )
            );
            $posts = query_posts ($args);
            wp_reset_postdata();
            include_once(locate_template($archive));
            return;
        }
    }
// End function tfuse_category_on_blog_page()
endif;

if (!function_exists('tfuse_action_footer')) :
/**
 * Dsiplay footer content
 *
 * To override tfuse_action_footer() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_action_footer() {

        $footer_shortcodes = tfuse_options('footer_shortcodes');
        if ( !tfuse_options('enable_footer_shortcodes') ) {
            ?>
        <div class="col_1_4 col">
            <div class="inner">
                <?php dynamic_sidebar('footer-1'); ?>
            </div>
        </div><!-- /.col_1_4 -->
        <div class="col_1_4 col">
            <div class="inner">
                <?php dynamic_sidebar('footer-2'); ?>
            </div>
        </div><!-- /.col_1_4 -->
        <div class="col_1_4 col">
            <div class="inner">
                <?php dynamic_sidebar('footer-3'); ?>
            </div>
        </div><!-- /.col_1_4 -->
        <div class="col_1_4 col">
            <div class="inner">
                <?php dynamic_sidebar('footer-4'); ?>
            </div>
        </div><!-- /.col_1_4 -->

            <?php
        } else {
            echo apply_filters('themefuse_shortcodes', '[raw]'.$footer_shortcodes.'[/raw]');
        }


    }

    add_action('tfuse_footer', 'tfuse_action_footer');
endif;

if ( !function_exists('tfuse_footer_social')):
/**
 * Dsiplay footer social links
 *
 * To override tfuse_footer_social() in a child theme, add your own tfuse_count_post_visits()
 * to your child theme's theme_config/theme_includes/THEME_FUNCTIONS.php file.
 */

    function tfuse_footer_social($before = '', $after = '', $returnS = false)
    {
        $tfuse_flickr      = tfuse_options('flickr');
        $tfuse_facebook = tfuse_options('facebook');
        $tfuse_twitter  = tfuse_options('twitter');
        $tfuse_deviantart  = tfuse_options('deviantart');
        $tfuse_rss  = tfuse_options('feedburner_url');
        $return = '';

        if ( $tfuse_facebook != '' ||  $tfuse_twitter != '' || $tfuse_flickr != '' || $tfuse_deviantart != '' || $tfuse_rss )
        {
            $return .=  $before;

                $return .=  ( $tfuse_twitter != '' )    ? '<a href="'.$tfuse_twitter.'" target="_blank" class="link-twitter"  title="'.__('Twitter','tfuse').'">'.__('Twitter','tfuse').'</a>' : '';
                $return .=  ( $tfuse_facebook != '' )   ? '<a href="'.$tfuse_facebook.'" class="link-fb" target="_blank"  title="'.__('Facebook','tfuse').'">'.__('Facebook','tfuse').'</a>' : '';
                $return .=  ( $tfuse_flickr != '' )     ? '<a href="'.$tfuse_flickr .'" class="link-flickr" target="_blank"  title="'.__('Flickr','tfuse').'">'.__('Flickr','tfuse').'</a>' : '';
                $return .=  ( $tfuse_deviantart != '' ) ? '<a href="'.$tfuse_deviantart .'" class="link-da" target="_blank"  title="'.__('deviantART','tfuse').'">'.__('deviantART','tfuse').'</a>' : '';
                $return .=  ( $tfuse_rss != '' )        ? '<a href="'.$tfuse_rss .'" class="link-rss" target="_blank"  title="'.__('RSS Feed','tfuse').'">'.__('RSS Feed','tfuse').'</a>' : '';

                $return .=  $after;
        }
        else
            return false;
        if ($returnS)
            return $return;
        echo $return;
    }
endif;

if ( !function_exists('tfuse_get_slider')):

    function tfuse_get_slider(){

        global $post,$is_tf_blog_page;
        if($is_tf_blog_page){
            $header_element = tfuse_options('header_element_blog');
            if ( 'slider' == $header_element )
                $slider='';
            $slider = tfuse_options('select_slider_blog');
        }
        elseif(is_front_page())
        {
            if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page')
            {
                $page_id = $post->ID;
                $header_element = tfuse_page_options('header_element','',$page_id);
                if ( 'slider' == $header_element )
                    $slider='';
                $slider = tfuse_page_options('select_slider','',$page_id);
            }
            else
            {
                $header_element = tfuse_options('header_element');
                if ( 'slider' == $header_element )
                    $slider='';
                $slider = tfuse_options('select_slider');
            }

        }
        elseif ( is_singular() )
        {
            $ID = $post->ID;
            $header_element = tfuse_page_options('header_element');
            if ( 'slider' == $header_element )
                $slider = tfuse_page_options('select_slider');
            elseif ( 'image' == $header_element )
                $header_image = tfuse_page_options('header_image');
        }
        elseif ( is_category() )
        {
            $ID = get_query_var('cat');
            $header_element = tfuse_options('header_element', null, $ID);
            if ( 'slider' == $header_element )
                $slider = tfuse_options('select_slider', null, $ID);
            elseif ( 'image' == $header_element )
                $header_image = tfuse_options('header_image', null, $ID);
        }
        elseif ( is_tax() )
        {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $ID = $term->term_id;
            $header_element = tfuse_options('header_element', null, $ID);
            if ( 'slider' == $header_element )
                $slider = tfuse_options('select_slider', null, $ID);
            elseif ( 'image' == $header_element )
                $header_image = tfuse_options('header_image', null, $ID);
        }

        if ( !empty($slider) && $header_element == 'slider')
            return $slider;
        else
            return false;
    }
endif;

if ( !function_exists('tfuse_slide_param')):

    function tfuse_slide_param($param = ''){
        global $TFUSE;$slider='';
        global $is_tf_front_page,$is_tf_blog_page,$post;
        if($is_tf_blog_page){
            $header_element = tfuse_options('header_element_blog');
            if ( 'slider' == $header_element )
                $slider='';
            $slider = tfuse_options('select_slider_blog');
        }
        elseif(is_front_page())
        {
            if(tfuse_options('use_page_options') && tfuse_options('homepage_category')=='page')
            {
                $page_id = $post->ID;
                $header_element = tfuse_page_options('header_element','',$page_id);
                if ( 'slider' == $header_element )
                    $slider='';
                $slider = tfuse_page_options('select_slider','',$page_id);
            }
            else
            {
                $header_element = tfuse_options('header_element');
                if ( 'slider' == $header_element )
                    $slider='';
                $slider = tfuse_options('select_slider');
            }

        }
        elseif(is_singular())
        {
            $header_element = tfuse_page_options('header_element');
            if ( 'slider' == $header_element )
                $slider='';
            $slider = tfuse_page_options('select_slider');
        }
        elseif (is_category())
        {
            $ID = get_query_var('cat');
            $header_element = tfuse_options('header_element', null, $ID);
            if ( 'slider' == $header_element )
                $slider='';
            $slider = tfuse_options('select_slider', null, $ID);
        }
        elseif (is_tax())
        {
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $ID = $term->term_id;
            $header_element = tfuse_options('header_element', null, $ID);
            if ( 'slider' == $header_element )
                $slider='';
            $slider = tfuse_options('select_slider', null, $ID);
        }

        $slider = $TFUSE->ext->slider->model->get_slider($slider);
        if ( $param == 'aside') echo 'id="aside2"';
        if($slider['design'] == 'animated' && $header_element=='slider') echo 'onload="load_animations()" ';
    }
endif;
function tfuse_tax_shortcode($param = 'top'){

    $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));

    @$ID = $term->term_id;
    $output = '';
    if (has_filter("tfuse_tax_shortcode_{$param}_{$ID}")) {
        return apply_filters("tfuse_tax_shortcode_{$param}_{$ID}",$output);
    }
    return apply_filters("tfuse_tax_shortcode_{$param}", $output);
}
if ( !function_exists('tfuse_themestyle')):

    function tfuse_theme_style(){
        global $TFUSE;

        $theme_style = tfuse_options('stylesheet');
        if ( $theme_style == 'default.css' ) return;
        wp_register_style( 'theme_style', get_template_directory_uri() . '/styles/' . $theme_style, false, '1.0' );
        wp_enqueue_style( 'theme_style' );

    }
    add_action('wp_enqueue_scripts', 'tfuse_theme_style');
endif;

if ( !function_exists('tfuse_img_content')):

    function tfuse_img_content(){ 
        $content = $link = '';
		$args = array(
			'numberposts'     => -1,
		); 
        $posts_array = get_posts( $args );
        $option_name = 'thumbnail_image';
		foreach($posts_array as $post):
			$featured = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID));  
			if(tfuse_page_options('thumbnail_image',false,$post->ID)) continue;
			
			if(!empty($featured))
			{
				$value = $featured[0];
				tfuse_set_page_option($option_name, $value, $post->ID);
				tfuse_set_page_option('disable_image', true , $post->ID); 
			}
			else
			{
				$args = array(
				 'post_type' => 'attachment',
				 'numberposts' => -1,
				 'post_parent' => $post->ID
				); 
				$attachments = get_posts($args);
				if ($attachments) {
				 foreach ($attachments as $attachment) { 
								$value = $attachment->guid; 
								tfuse_set_page_option($option_name, $value, $post->ID);
								tfuse_set_page_option('disable_image', true , $post->ID); 
							 }
				}
				else
				{
					$content = $post->post_content;
						if(!empty($content))
						{   
							preg_match('/< *img[^>]*src *= *["\']?([^"\']*)/i', $content,$matches);
							if(!empty($matches))
							{
								$link = $matches[1]; 
								tfuse_set_page_option($option_name, $link , $post->ID);
								tfuse_set_page_option('disable_image', true , $post->ID);
							}
						}
				}
			}
                        
		endforeach;
			tfuse_set_option('enable_content_img',false, $cat_id = NULL);
    }
endif;
if ( tfuse_options('enable_content_img'))
{ 
    add_action('tfuse_head','tfuse_img_content');
}
//for image in rss
if(!function_exists('tfuse_feedFilter')) :

    function tfuse_feedFilter($query) {
        if ($query->is_feed) {
            add_filter('the_content', 'tfuse_feedContentFilter');
        }
        return $query;
    }
    add_filter('pre_get_posts','tfuse_feedFilter');

    function tfuse_feedContentFilter($content) {
        $thumb = tfuse_page_options('single_image');
        $image = '';
        if($thumb) {
            $image = '<a href="'.get_permalink().'"><img align="left" src="'. $thumb .'" width="200px" height="150px" /></a>';
            echo $image;
        }
        $content = $image . $content;
        return $content;
    }

endif;


function tfuse_set_blog_page(){
    global $wp_query,$is_tf_blog_page;
    if(isset($wp_query->queried_object->ID)) $id_post = $wp_query->queried_object->ID;
    elseif(isset($wp_query->query['page_id'])) $id_post = $wp_query->query['page_id'];
    else $id_post = 0;
    if(tfuse_options('blog_page') != 0 && $id_post == tfuse_options('blog_page')) $is_tf_blog_page = true;
}
add_action('wp_head','tfuse_set_blog_page');