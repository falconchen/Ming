<?php
/**
 * Template Name: Grid
 *
 * This is the template that content displayed in gird
 *
 */



$args = array(

    'posts_per_page' => 1,
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

wp_reset_postdata();

get_header();
?>

<div id="page" class="hfeed site">

    <div id="content" class="site-content">
        <?php get_template_part('top');?>
        <main id="main" class="site-main" role="main">

            <section id="section-skills" class="section section-skills">

                <header class="section-header daily-header">

                    <blockquote class="section-title">
                        <?php $post = get_post($current_postid);?>
                        <?php echo nl2br($post->post_excerpt);?>
                        <?php $lilian_meta = get_post_meta($post->ID,'_lilian',true);?>
                        <?php if( $lilian_meta['author'] != "" ):?>
                            <p>by <?php echo esc_html($lilian_meta['author']);?></p>
                        <?php endif?>
                        <date><?php echo local_current_date('D d M. Y')?></date>
                    </blockquote>
                </header>
                <div class="section-content">
                    <?php
                    $images = array();
                    $has_image = false;
                    $images_ids_arr = explode(',',$images_ids);
                    foreach ( $images_ids_arr as  $image_id) {
                        $attachment = get_post($image_id);
                        if(!is_object($attachment)) continue;
                        $has_image = true;
                        $thumb = wp_get_attachment_image_src($attachment->ID, 'full');
                        $images[] = array('id' => $attachment->ID, 'title' => $attachment->post_title , 'full-src'=>esc_url($thumb[0]));
                    }

                    ?>
                    <?php if ($has_image) :?>
                        <ul class="icon-box">
                            <?php foreach ($images as $k => $image): ?>
                            <?php if( $k == 3) break;?>
                            <li>
                                <a  href="<?php echo $image["full-src"];?>">
                                    <?php echo wp_get_attachment_image($image['id'] , 'daily-crop'); ?>
                                </a>
                            </li>
                            <?php endforeach;?>
                        </ul>
                        <?php if ( count($images) > 3):?>
                        <ul class="icon-box">
                            <?php foreach ($images as $k => $image): ?>
                                <?php if( $k < 3) continue;?>
                                <?php if( $k > 5) break;?>
                                <li>
                                    <a  href="<?php echo $image["full-src"];?>">
                                        <?php echo wp_get_attachment_image($image['id'] , 'daily-crop'); ?>
                                    </a>
                                </li>
                            <?php endforeach;?>
                        </ul>
                        <?php endif?>
                    <?php endif;?>
                </div>

            </section>
            </main>
    </div>

</div>
<?php get_footer(); ?>
