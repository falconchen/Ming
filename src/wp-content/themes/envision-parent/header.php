<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>; charset=<?php bloginfo('charset'); ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE7" />
	<title><?php
		if(tfuse_options('disable_tfuse_seo_tab'))
			{wp_title( '|', true, 'right' );bloginfo( 'name' );
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
			echo " | $site_description";}
		else wp_title('');?>
	</title>
    <?php tfuse_meta(); ?>

    <link rel="profile" href="http://gmpg.org/xfn/11" />
    <link href="<?php bloginfo('stylesheet_url') ?>" rel="stylesheet" type="text/css" />
	<link rel="stylesheet" type="text/css" media="screen" href="<?php echo get_template_directory_uri() ?>/styles/default.css" />
    <link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="<?php echo tfuse_options('feedburner_url', get_bloginfo_rss('rss2_url')); ?>" />
    <link rel="pingback" href="<?php bloginfo('pingback_url'); ?>" />

    <?php
        if ( is_singular() && get_option( 'thread_comments' ) )
                wp_enqueue_script( 'comment-reply' );

        tfuse_head();
        wp_head();
    ?>
</head>
<body <?php body_class();?> <?php tfuse_slide_param('animation'); ?>>
	<div class="header_img" <?php tfuse_slide_param('aside'); ?>>
		<div class="topnav">
			<div class="container_12">
                <div class="logo">
                    <a href="<?php bloginfo('url'); ?>" title="<?php bloginfo('description'); ?>">
                        <img src="<?php echo tfuse_logo(); ?>" alt="<?php bloginfo('name'); ?>"  border="0" />
                    </a>
                </div><!--/ .logo -->
				 <?php  tfuse_menu('default');  ?>
			</div>
		</div><!--/ .topnav -->
        <?php tfuse_header_content(); ?>
    </div>
		<!--/ header -->
        <?php echo tfuse_welcome_bar(); ?>
        <?php global $is_tf_blog_page;
            if($is_tf_blog_page) tfuse_category_on_blog_page();
        ?>