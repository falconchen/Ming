<?php
/*
Template Name: Contact
*/

get_header();
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
                        get_template_part( 'content', 'contact-form' );
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