<?php
/**
 * 404 page
 *
 * This is the template that displays about
 *
 */
get_header();
?>



    <div id="page" class="hfeed site">


        <div id="content" class="site-content">
            <header class="section-header" style="text-align: center">
                <h1 class="section-title"><?php echo bloginfo('name'); ?> - 404</h1>
                <?php the_nav_bar(); ?>
            </header>
            <main id="main" class="site-main" role="main" style="margin-top:0">

                <div class="container">

                    <div class="section-content post-content col-md-6 col-md-offset-4">
                        <h2>抱歉, 没有找到这个页面. </h2>
                    </div>
                </div>

            </main>
        </div>

    </div>
<?php get_footer();?>