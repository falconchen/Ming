<?php
/**
 * The template for displaying content in the single.php template.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since Envision 2.0
 */
global $post;
?>
<div class="post-item">
    <div class="post-title">
        <?php if(!tfuse_page_options('disable_comments')): ?>
        <div class="post-comments-icon">
            <a href="<?php comments_link(); ?>" ><?php comments_number('0', '1', '%') ?></a>
        </div>
        <?php endif;
        the_title('<h1>','</h1>');
        if( !tfuse_page_options('disable_published_date')|| !tfuse_page_options('disable_post_category') ): ?>
        <div class="post-date">
            <?php
                if( !tfuse_page_options('disable_published_date'))  the_time('j F, Y');
                if( !tfuse_page_options('disable_published_date') && !tfuse_page_options('disable_post_category') ) echo '-';
                if( !tfuse_page_options('disable_post_category'))
                {
                    if ( 'portfolio' == get_post_type() )  {
                        $tf_tax =   get_the_taxonomies( '', array( 'sep' => '') );
                        $tf_taxs = explode(': ',$tf_tax['group'], 2);

                        echo $tf_taxs['1'];

                    }
                    else the_category(', ');
                }
            ?>
        </div>
        <?php endif; ?>
    </div>
    <div class="entry gallery-image">
         <?php tfuse_media(); ?>
         <?php the_content(); ?>
        <div class="clear"></div>
    </div>
</div><!--/ .post-item -->