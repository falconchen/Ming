<?php
/**
 * The template for displaying posts on archive pages.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since Envision 2.0
 */
?>
<div class="post-item">
    <div class="post-title">
        <?php if(!tfuse_page_options('disable_comments')): ?>
        <div class="post-comments-icon">
            <a href="<?php comments_link(); ?>" ><?php comments_number('0', '1', '%') ?></a>
        </div>
        <?php endif; ?>
        <h2><a href="<?php the_permalink() ?>"><?php the_title();?></a></h2>
        <div class="post-date">
            <?php
                the_time('j F, Y');
                echo '-';
                the_category(', ');
            ?>
        </div>
    </div>
    <div class="entry">
        <?php
            tfuse_media();
           if ( tfuse_options('post_content') == 'content' )
               the_content('');
           else
               the_excerpt();
        ?>
        <div class="clear"></div>
    </div>
    <div class="post-meta">
        <a href="<?php the_permalink() ?>"><?php _e('Continue reading', 'tfuse'); ?></a> |  <a href="<?php comments_link(); ?>"><?php _e('Join the discussion', 'tfuse'); ?></a>
    </div>

</div><!--/ .post-item -->