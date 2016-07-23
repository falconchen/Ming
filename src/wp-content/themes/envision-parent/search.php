<?php
get_header();
$sidebar_position = tfuse_sidebar_position();
$cat_ID = get_query_var('cat');
?>
<div <?php tfuse_class('middle'); ?>>
    <div class="container_12">
        <div class="wrapper">
            <div class="content">
                <div class="text">

            <?php if (have_posts()) : $count = 0; ?>
                <?php while (have_posts()) : the_post(); $count++; ?>

                    <?php get_template_part('listing', 'blog'); ?>

                    <?php
                    global $wp_query;
                    if ($count < $wp_query->post_count)
                        echo '<div class="divider_dots"></div>';
                    ?>

            <?php endwhile;
                /*
                 * Display pagination to next/previous pages when applicable.
                 * This function is located in theme_config/theme_includes/THEME_FUNCTIONS.php
                 * Create your own tfuse_pagination() to override in a child theme.
                 *
                 * @since Envision 2.0
                 */
                tfuse_pagination();

                else: ?>

                <h5><?php _e('Sorry, no posts matched your criteria.', 'tfuse') ?></h5>

            <?php endif; ?>
                </div>
            </div>
        </div>
        <?php if ($sidebar_position != 'full') : ?>
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