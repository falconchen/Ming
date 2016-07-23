<?php
get_header();
global $is_tf_front_page,$is_tf_blog_page; 
$sidebar_position = tfuse_sidebar_position();
$cat_ID = get_query_var('cat');

if(!$is_tf_front_page && !$is_tf_blog_page)
{
$term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
$ID = $term->term_id;
$tfuse_tax = array(
                'taxonomy' => 'group',
                'field' => 'id',
                'terms' => $ID
		);
}
if($is_tf_front_page )
{ 
	$cat_templ = tfuse_options('template_portfolio');
}
elseif($is_tf_blog_page)
{ 
    $cat_templ = tfuse_options('template_portfolio_blog');
}
else
	$cat_templ = tfuse_options('portfolio_tax_template','1col',$ID);
$tf_pag = tfuse_CustomQuery();
?>
<div <?php tfuse_class('middle'); ?>>
    <div class="container_12">
        <?php if ($cat_templ == '1col' || $cat_templ == '2col' ) : ?>
        <div class="wrapper">
            <div class="content">
        <?php endif;
        tfuse_tax_shortcode('top');
        ?>
        <div <?php tfuse_class('gall'); ?>>

            <?php
            if (!is_front_page())
            {
                global $wp_query; 
                if ( get_query_var('paged') ) $paged = get_query_var('paged');
                elseif ( get_query_var('page') ) $paged = get_query_var('page'); else $paged = 1;
                $args = array_merge( $wp_query->query,  array('paged' => $paged,'posts_per_page' => $tf_pag ) );
                query_posts($args);
            }
            if (have_posts()) :
            while (have_posts()) : the_post();  ?>

                    <?php get_template_part('listing', 'portfolio'); ?>

            <?php endwhile;
                /*
                 * Display pagination to next/previous pages when applicable.
                 * This function is located in theme_config/theme_includes/THEME_FUNCTIONS.php
                 * Create your own tfuse_pagination() to override in a child theme.
                 *
                 * @since Envision 2.0
                 */
                tfuse_pagination ();

                else: ?>

                <h5><?php _e('Sorry, no posts matched your criteria.', 'tfuse') ?></h5>

            <?php endif; ?>
        </div>
        <?php  tfuse_tax_shortcode('bottom');
        if ($cat_templ == '1col' || $cat_templ == '2col' ) : ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if ($sidebar_position != 'full' && ( $cat_templ == '1col' || $cat_templ == '2col' ) ) : ?>
            <div class="sidebar">
                <div class="inner">
                <?php get_sidebar(); ?>
                </div>
            </div><!--/ .sidebar -->
        <?php endif; ?>
        <div class="clear"></div>
    </div><!--/ .container_12 -->
</div><!--/ .middle -->
<?php get_footer(); ?>