<?php
get_header();
$sidebar_position = tfuse_sidebar_position();
?>
<div <?php tfuse_class('middle'); ?>>
	<div class="container_12">
        <div class="wrapper">
            <div class="content">
                <div class="text">
                    <p><?php _e('Page not found', 'tfuse') ?></p>
                    <p><?php _e('The page you were looking for doesn&rsquo;t seem to exist', 'tfuse') ?>.</p>
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