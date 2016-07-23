<?php
/**
 * Template Name: Speech
 *
 * This is the template that displays speech, tweets or quotes
 *
 */

get_header();

?>



<div id="page" class="hfeed site">


    <div id="content" class="site-content">
        <?php get_template_part('top');?>
        <main id="main" class="site-main" role="main">
            <section id="section-testimonials" class="section section-testimonials text-center">
                <div class="container">
                    <div class="section-content">

                        <div class="carousel slide" data-ride="carousel" id="testimonial-carousel">
                            <div class="row">
                                <div class="col-md-8 col-md-offset-2">
                                    <div class="carousel-inner">


                                        <?php

                                        $args = array(

                                            'posts_per_page' => -1,
                                            'order' => 'DESC',
                                            'orderby' => 'ID',
                                            'post_status' => 'publish',
                                            'tax_query' => array(
                                                'relation' =>'OR',
                                                array(
                                                    'taxonomy' => 'post_format',
                                                    'field'    => 'slug',
                                                    'terms'    => array( 'post-format-quote' ),
                                                ),
                                                array(
                                                    'taxonomy' => 'post_format',
                                                    'field'    => 'slug',
                                                    'terms'    => array( 'post-format-gallery' ),
                                                ),
                                            )
                                        );
                                        $the_query = new WP_Query( $args );
                                        $k = 0;
                                        ?>
                                        <?php if ( $the_query->have_posts() ) : ?>
                                            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>

                                                <div class="item <?php if($k==0) echo 'active'; $k++?>">
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <p class="testimonial-content">
                                                                &ldquo;
                                                                <?php echo (nl2br($post->post_excerpt));?>
                                                                <?php $lilian_meta = get_post_meta(get_the_ID(),'_lilian',true);?>
                                                                &rdquo;
                                                            </p>
                                                             <?php if(@$lilian_meta['author'] != ""):?>
                                                            <p>
                                                                <br/>
                                                                <B>by <a href="https://gg.cellmean.com?q=<?php echo $lilian_meta['author']?>"><?php echo $lilian_meta['author']?></a>
                                                                </B>
                                                                 <?php if(@$lilian_meta['link'] != ""):?>
                                                                 , <small><a target="_blank" href="<?php echo $lilian_meta['link'] ;?>">SEE More</a>

                                                                </small>
                                                                 <?php endif;?>
                                                            </p>
                                                            <?php endif?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php endwhile;?>
                                        <?php endif;?>

                                    </div>
                                </div>
                            </div>
                            <a class="left carousel-control" href="#testimonial-carousel" role="button"
                               data-slide="prev">
                                <span class="ti-arrow-left" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="right carousel-control" href="#testimonial-carousel" role="button"
                               data-slide="next">
                                <span class="ti-arrow-right" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>

                    </div>
                </div>
            </section>
        </main>
    </div>

</div>
<?php get_footer();?>