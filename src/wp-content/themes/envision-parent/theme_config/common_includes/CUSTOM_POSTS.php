<?php
/**
 * Create custom posts types
 *
 * @since Envision 2.0
 */

if ( !function_exists('tfuse_create_custom_post_types') ) :
/**
 * Retrieve the requested data of the author of the current post.
 *  
 * @param array $fields first_name,last_name,email,url,aim,yim,jabber,facebook,twitter etc.
 * @return null|array The author's spefified fields from the current author's DB object.
 */
    function tfuse_create_custom_post_types()
    {

		//reservation_form
        $labels = array(
                        'name' => _x('Reservation', 'post type general name', 'tfuse'),
                        'singular_name' => _x('Reservation', 'post type singular name', 'tfuse'),
                        'add_new' => __('Add New', 'tfuse'),
                        'add_new_item' => __('Add New Reservation', 'tfuse'),
                        'edit_item' => __('Edit Reservation info', 'tfuse'),
                        'new_item' => __('New Reservation', 'tfuse'),
                        'all_items' => __('All Reservations', 'tfuse'),
                        'view_item' => __('View Reservation info', 'tfuse'),
                        'parent_item_colon' => ''
                );
                $reservationform_rewrite=apply_filters('tfuse_reservationform_rewrite','reservationform_list');
                $res_args = array(
                                'labels' => $labels,
                                'public' => true,
                                'publicly_queryable' => false,
                                'show_ui' => false,
                                'query_var' => true,
                                'exclude_from_search'=>true,
                                //'menu_icon' => get_template_directory_uri() . '/images/icons/doctors.png',
                                'has_archive' => true,
                                'rewrite' => array('slug'=> $reservationform_rewrite),
                                'menu_position' => 6,
                                'supports' => array(null)
                        );
               register_taxonomy('reservations', array('reservations'), array(
                            'hierarchical' => true,
                            'labels' => array(
                                'name' => _x('Reservation Forms', 'post type general name', 'tfuse'),
                                'singular_name' => _x('Reservation Form', 'post type singular name', 'tfuse'),
                                'add_new_item' => __('Add New Reservation Form', 'tfuse'),
                            ),
                            'show_ui' => false,
                            'query_var' => true,
                            'rewrite' => array('slug' => $reservationform_rewrite)
                        ));
                        register_post_type( 'reservations' , $res_args );
		
        // Portfolio
        $labels = array(
                'name' => _x('Portfolio', 'post type general name', 'tfuse'),
                'singular_name' => _x('Portfolio', 'post type singular name', 'tfuse'),
                'add_new' => __('Add New Portfolio', 'tfuse'),
                'add_new_item' => __('Add New Portfolio', 'tfuse'),
                'edit_item' => __('Edit Portfolio info', 'tfuse'),
                'new_item' => __('New Portfolio', 'tfuse'),
                'all_items' => __('Portfolio', 'tfuse'),
                'view_item' => __('View Portfolio info', 'tfuse'),
                'search_items' => __('Search Portfolio', 'tfuse'),
                'not_found' =>  __('Nothing found', 'tfuse'),
                'not_found_in_trash' => __('Nothing found in Trash', 'tfuse'),
                'parent_item_colon' => ''
        );

        $portfoliolist_rewrite = apply_filters('tfuse_portfoliolist_rewrite','all-portfolio-list');
        $args = array(
                'labels' => $labels,
                'public' => true,
                'publicly_queryable' => true,
                'show_ui' => true,
                'query_var' => true,
                'has_archive' => true,
                'rewrite' => array('slug'=> $portfoliolist_rewrite),
                'menu_position' => 5,
                'supports' => array('title','editor','excerpt','comments')
        );

        // Add new taxonomy, make it hierarchical (like categories)
        $labels = array(
            'name' => _x('Categories', 'taxonomy general name'),
            'singular_name' => _x('Category', 'taxonomy singular name'),
            'search_items' => __('Search Categories'),
            'all_items' => __('All Categories'),
            'parent_item' => __('Parent Category'),
            'parent_item_colon' => __('Parent Category:'),
            'edit_item' => __('Edit Category'),
            'update_item' => __('Update Category'),
            'add_new_item' => __('Add New Category'),
            'new_item_name' => __('New Category Name')
        );

        $portfoliolist_taxonomy_rewrite = apply_filters('tfuse_portfoliolist_taxonomy_rewrite','group-list');
        register_taxonomy('group', array('portfolio'), array(
            'hierarchical' => true,
            'labels' => $labels,
            'show_ui' => true,
            'query_var' => true,
            'rewrite' => array('slug' => $portfoliolist_taxonomy_rewrite)
        ));

        register_post_type( 'portfolio' , $args );


        // TESTIMONIALS
        $labels = array(
                'name' => _x('Testimonials', 'post type general name', 'tfuse'),
                'singular_name' => _x('Testimonial', 'post type singular name', 'tfuse'),
                'add_new' => __('Add New', 'tfuse'),
                'add_new_item' => __('Add New Testimonial', 'tfuse'),
                'edit_item' => __('Edit Testimonial', 'tfuse'),
                'new_item' => __('New Testimonial', 'tfuse'),
                'all_items' => __('All Testimonials', 'tfuse'),
                'view_item' => __('View Testimonial', 'tfuse'),
                'search_items' => __('Search Testimonials', 'tfuse'),
                'not_found' =>  __('Nothing found', 'tfuse'),
                'not_found_in_trash' => __('Nothing found in Trash', 'tfuse'),
                'parent_item_colon' => ''
        );

        $args = array(
                'labels' => $labels,
                'public' => false,
                'publicly_queryable' => false,
                'show_ui' => true,
                'query_var' => true,
                //'menu_icon' => get_template_directory_uri() . '/images/icons/testimonials.png',
                'rewrite' => true,
                'menu_position' => 5,
                'supports' => array('title','editor')
        ); 

        register_post_type( 'testimonials' , $args );

    }
    tfuse_create_custom_post_types();

endif;

add_action('category_add_form', 'taxonomy_redirect_note');
add_action('group_add_form', 'taxonomy_redirect_note');
function taxonomy_redirect_note($taxonomy){
    echo '<p><strong>Note:</strong> More options are available after you add the '.$taxonomy.'. <br />
        Click on the Edit button under the '.$taxonomy.' name.</p>';
}
