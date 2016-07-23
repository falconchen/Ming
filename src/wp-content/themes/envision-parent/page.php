<?php
    global $is_tf_blog_page;
    get_header();
    if ($is_tf_blog_page)die;
    $sidebar_position = tfuse_sidebar_position();
?>
<div <?php tfuse_class('middle'); ?>>
	<div class="container_12">
        <div class="wrapper">
            <div class="content">
                <div class="text">
                    <?php
                    while ( have_posts() ) :
                        the_post();
                        the_content();
                        tfuse_comments();
						break;
                    endwhile; // end of the loop.
                    ?>
                </div><!--/ .text -->
            </div><!--/ .content -->
        </div><!--/ .wrapper -->
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