<?php
function tfuse_CustomQuery()
{
    global $post_per_page,$is_tf_front_page,$is_tf_blog_page;
        $tfuse_query_str = array();
        //$homepage_category = tfuse_options('homepage_category');

        $tf_term = get_query_var('term');
        if ( get_term_by('slug',$tf_term,'category') )
        {
            $taxonomy = 'category';
        }
        elseif ( get_term_by('slug',$tf_term,'group') )
        {
            $taxonomy = 'group';
        }
		if(!$is_tf_front_page && !$is_tf_blog_page)
		{
			$term = get_term_by('slug', $tf_term, $taxonomy);

			$ID = $term->term_id;
		}
		if($is_tf_front_page)
		{
			$category_template = tfuse_options('template_portfolio');
		}
                elseif($is_tf_blog_page)
		{
			$category_template = tfuse_options('template_portfolio_blog');
		}
		else
			$category_template = tfuse_options('portfolio_tax_template','',$ID);

        switch ($category_template) {
            case '1col':
                $tfuse_query_str = 4;
                break;
            case '2col':
                $tfuse_query_str = 6;
                break;
            case '3col':
                $tfuse_query_str = 6;
                break;
            case '4col':
                $tfuse_query_str = 12;
                break;
            default:
                $tfuse_query_str = $post_per_page;
        }
	return $tfuse_query_str;
}

function tfuse_pagination($query = '', $args = array()){

    global $wp_rewrite, $wp_query;

    if ( $query ) {
        $wp_query = $query;

    } // End IF Statement

    /* If there's not more than one page, return nothing. */
    if ( 1 >= $wp_query->max_num_pages )
        return false;

    /* Get the current page. */
    $current = ( get_query_var( 'paged' ) ? absint( get_query_var( 'paged' ) ) : 1 );

    /* Get the max number of pages. */
    $max_num_pages = intval( $wp_query->max_num_pages ); 


    /* Set up some default arguments for the paginate_links() function. */
    $defaults = array(
        'base' => add_query_arg( 'paged', '%#%' ),
        'format' => '',
        'total' => $max_num_pages,
        'current' => $current,
        'prev_next' => true,
        'prev_text'    => __('&nbsp;'),
        'next_text'    => __('&nbsp;'),
        'show_all' => false,
        'end_size' => 1,
        'mid_size' => 1,
        'add_fragment' => '',
        'type' => 'plain',
        'before' => '<div align="center" class="clearpagination"><span class="pagination"><span class="inner">',
        'after' => '</span></span></div>',
        'echo' => true,
    );

    /* Add the $base argument to the array if the user is using permalinks. */
    if( $wp_rewrite->using_permalinks() )
	{ 
        $defaults['base'] = user_trailingslashit( trailingslashit( get_pagenum_link() ) . 'page/%#%' );
	}

    /* If we're on a search results page, we need to change this up a bit. */
    if ( is_search() ) {
        $search_permastruct = $wp_rewrite->get_search_permastruct();
        if ( !empty( $search_permastruct ) )
            $defaults['base'] = user_trailingslashit( trailingslashit( get_search_link() ) . 'page/%#%' );
    }

    /* Merge the arguments input with the defaults. */
    $args = wp_parse_args( $args, $defaults );

    /* Don't allow the user to set this to an array. */
    if ( 'array' == $args['type'] )
        $args['type'] = 'plain';

    /* Get the paginated links. */
    $page_links = paginate_links( $args );

    /* Remove 'page/1' from the entire output since it's not needed. */
    $page_links = str_replace( array( '&#038;paged=1\'', '/page/1\'' ), '\'', $page_links );

    /* Wrap the paginated links with the $before and $after elements. */
    $page_links = $args['before'] . $page_links . $args['after'];

    /* Return the paginated links for use in themes. */
    if ( $args['echo'] )
        echo $page_links;
    else
        return $page_links;

}
