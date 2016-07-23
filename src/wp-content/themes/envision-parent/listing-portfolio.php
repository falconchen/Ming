<?php
/**
 * The template for displaying posts on archive pages.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since Envision 2.0
 */
$tf_img = tfuse_media(true, true);

?>
<div class="gallery-item">
    <?php if (!empty($tf_img)): ?>
    <div class="gallery-image">
        <?php
        tfuse_media();
        $video_link              = tfuse_page_options('video_link');

        if ( !tfuse_options('disable_listing_lightbox') ) {
        ?>
            <a href="<?php if ($video_link!='') {echo $video_link;} else {echo tfuse_media(true, true);} ?>" rel="prettyPhoto[gallery]" class="gallery-zoom" title="<?php the_title(); ?>">
                <img src="<?php bloginfo('template_directory'); ?>/images/icon_zoom.png" alt="" width="42" height="42" border="0"/>
            </a>
        <?php
        }
        if ( tfuse_page_options('disable_ribbon_post') )
            echo '<span class="ribbon-new">'.__('NEW','tfuse').'</span>';
        ?>
    </div>
     <?php endif; ?>
        <div class="gallery-text">
            <div class="gallery-item-name"><h2><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h2></div>
            <div class="gallery-description">
            <?php
               if ( tfuse_options('post_content') == 'content' )
                   the_content('');
               else
                   the_excerpt();
            ?>
            </div>
            <div class="gallery-more">
                <a href="<?php the_permalink() ?>">
                    <span><?php _e('View project', 'tfuse'); ?></span>
                </a>
            </div>
       </div>
    <div class="clear"></div>
</div><!--/ .gallery-item -->