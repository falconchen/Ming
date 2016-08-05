<?php
/**
 * Template Name: Col
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

            <section id="section-portfolio" class="section section-portfolio">
                <div class="container">


                    <div class="section-content">

                        <div class="projects">
                            <div class="row">
                                <?php
                                /*
                                $attachments = get_children( array(
                                    'post_type' => 'attachment',
                                    'post_mime_type' => 'image',
                                    'numberposts' => -1,
                                    'post_status' => null,
                                    'post_parent' => 65, // any parent
                                    'output' => 'object',
                                ) );
                                $images = array();
                                foreach ( $attachments as $attachment ) {
                                    $thumb = wp_get_attachment_image_src($attachment->ID, 'full');
                                    $medium = wp_get_attachment_image_src($attachment->ID, 'daily-crop');
                                    $images[] = array('id' => $attachment->ID, 'title' => $attachment->post_title , 'full-src'=>esc_url($thumb[0]), 'medium-src'=> esc_url($medium[0]),);

                                }
                                */
                                $args = array(

                                    'posts_per_page' => 2,
                                    'order' => 'DESC',
                                    'orderby' => 'ID',
                                    'post_status' => 'publish',
                                    'tax_query' => array(
                                        array(
                                            'taxonomy' => 'post_format',
                                            'field'    => 'slug',
                                            'terms'    => array( 'post-format-gallery' ),
                                        ),
                                    )
                                );

                                $the_query = new WP_Query($args);
                                /*
                                if ($the_query->have_posts()) {
                                    while ($the_query->have_posts()) {
                                        $the_query->the_post();
                                        $content = get_the_content();
                                        $current_postid = get_the_ID();
                                    }

                                    $regex = get_shortcode_regex(array('gallery'));

                                    if(preg_match_all("/$regex/",$content,$matches)) {
                                        $attr = shortcode_parse_atts( $matches[3][0] );
                                        $images_ids = $attr['ids'];

                                    }

                                }
                                */
                                ?>
                                <?php if ($the_query->have_posts()) : ?>
                                    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
                                    <?php
                                        $content = get_the_content();
                                        $current_postid = get_the_ID();
                                        $regex = get_shortcode_regex(array('gallery'));
                                        if(preg_match_all("/$regex/",$content,$matches)) {
                                            $attr = shortcode_parse_atts( $matches[3][0] );
                                            $images_ids = $attr['ids'];

                                        }
                                        $images_ids_arr = explode(',',$images_ids);
                                        ?>
                                    <?php foreach ($images_ids_arr as $image_id): ?>
                                    <?php $image_info = wp_get_attachment_image_src($image_id, 'full');?>

                                    <div class="col-xs-6 col-md-3">
                                        <div class="project">
                                            <a  href="<?php echo $image_info[0];?>">
                                                <?php echo wp_get_attachment_image($image_id , 'daily-crop'); ?>
                                            </a>
                                        </div>
                                    </div>
                                    <?php endforeach;?>
                                    <?php endwhile;?>
                                <?php endif?>
                                <?php wp_reset_postdata();?>
                                <div class="col-xs-12 col-md-8 col-md-offset-2"><a href="javascript:void(0)"
                                                                                   id="loadmore"
                                                                                   class="btn btn-lg btn-block btn-default"> Show
                                        more photos <i class="loading fa fa-spinner fa-spin animated"></i></a></div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>


        </main>
    </div>


</div>
<?php get_footer(); ?>