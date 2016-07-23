<?php
/**
 * Template Name: about
 *
 * This is the template that displays about
 *
 */
get_header();
?>



    <div id="page" class="hfeed site">


        <div id="content" class="site-content">
            <header class="section-header" style="text-align: center">
                <h1 class="section-title"><?php echo bloginfo('name'); ?></h1>
                <?php the_nav_bar(); ?>
            </header>
            <main id="main" class="site-main" role="main">

                <div class="container">

                    <div class="section-content post-content col-md-8 col-md-offset-2">
                        <blockquote><?php the_title();?></blockquote>
                        <?php the_content();?>

                    </div>
                </div>

            </main>
        </div>

    </div>
<?php get_footer();?>