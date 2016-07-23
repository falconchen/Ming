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
        <?php get_template_part('top');?>
        <main id="main" class="site-main" role="main">

                <div class="container">

                    <div class="section-content post-content col-md-8 col-md-offset-2">

                        <?php the_content();?>

                    </div>
                </div>

        </main>
    </div>

</div>
<?php get_footer();?>