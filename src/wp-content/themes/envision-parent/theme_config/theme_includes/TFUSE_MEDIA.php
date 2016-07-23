<?php
if (!function_exists('tfuse_media')) :
/**
 * Display post media.
 * 
 * To override tfuse_media() in a child theme, add your own tfuse_media() 
 * to your child theme's file.
 */
function tfuse_media($return=false, $src = false)
{
    global $post,$is_tf_front_page,$is_tf_blog_page;

    $tfuse_media['img_position'] = $tfuse_media['image'] = $tfuse_image = $tf_media_add_space = $output = '';
    $tfuse_media['img_dimensions'] = array();
    $tfuse_media['disable_image']           = tfuse_page_options('disable_image',tfuse_options('disable_image'));

    $tfuse_media['disable_listing_lightbox'] = tfuse_options('disable_listing_lightbox');
    $tfuse_media['disable_single_lightbox'] = tfuse_options('disable_single_lightbox');
    $tfuse_media['video_link']              = tfuse_page_options('video_link');
    if ( $tfuse_media['video_link'] != '' && !is_tax()  )
    {
        $tfuse_media['video_link']              = tfuse_page_options('video_link');
        $tfuse_media['disable_video']           = tfuse_page_options('disable_video',tfuse_options('disable_video'));
        $tfuse_media['video_dimensions']    = tfuse_page_options('video_dimensions',tfuse_options('video_dimensions'));
        $tfuse_media['video_position']      = tfuse_page_options('video_position',tfuse_options('video_position'));

        $output='';
        $output .= '<div class="video_embed '.$tfuse_media['video_position'].'" style="width:'.$tfuse_media['video_dimensions'][0].'px">';
        $video = new TF_GET_EMBED();
        $output .= $video->width($tfuse_media['video_dimensions'][0])->height($tfuse_media['video_dimensions'][1])->source('video_link')->get();
        $output .= '</div><!--/.video_embed  -->';
        if( is_singular() && !$tfuse_media['disable_video'] )
        { if($return)
                return $output;
            else
                echo $output;
        }
        elseif(!is_singular())
        {if($return)
                return $output;
            else
             echo $output;
        }


    }

    if (is_singular() )
    {

        if ( !$tfuse_media['disable_image'] )
        {
            $tfuse_media['image']               = tfuse_page_options('single_image',tfuse_page_options('thumbnail_image'));
            $tfuse_media['img_dimensions']      = tfuse_page_options('single_img_dimensions',tfuse_options('single_img_dimensions'));
            $tfuse_media['img_position']        = tfuse_page_options('single_img_position',tfuse_options('single_img_position'));
        }

    }
    elseif ( !is_singular() )
    {
            $tfuse_media['image']               = tfuse_page_options('thumbnail_image');
            $tfuse_media['img_dimensions']      = tfuse_page_options('thumbnail_dimensions',tfuse_options('thumbnail_dimensions'));
            $tfuse_media['img_position']        = tfuse_page_options('thumbnail_position',tfuse_options('thumbnail_position'));             

            $tfuse_media['video_link']              = tfuse_page_options('video_link');
            $tfuse_media['disable_video']           = tfuse_page_options('disable_video',tfuse_options('disable_video'));
            $tfuse_media['disable_image']           = tfuse_page_options('disable_image',tfuse_options('disable_image'));
            $tfuse_media['video_dimensions']        = tfuse_page_options('video_dimensions',tfuse_options('video_dimensions'));
            $tfuse_media['video_position']          = tfuse_page_options('video_position',tfuse_options('video_position'));

            if ( $tfuse_media['video_link'] != '' && !is_tax()) {
                $output .= '<div class="video_embed '.$tfuse_media['video_position'].'" style="width:'.$tfuse_media['video_dimensions'][0].'px">';
                $video = new TF_GET_EMBED();
                $output .= $video->width($tfuse_media['video_dimensions'][0])->height($tfuse_media['video_dimensions'][1])->source('video_link')->get();
                $output .= '</div><!--/.video_embed  -->';

                return false;
        }
    }

    if ( !empty($tfuse_media['image']) )
    {
        if($is_tf_front_page)
        {
			global $TFUSE;
            $cat_templ = tfuse_options('template_portfolio');
            if ( $cat_templ == '1col')
            {
                $height = apply_filters('portfolio1width',199);
                $width  = apply_filters('portfolio1height',361);
            }
            elseif ( $cat_templ == '2col' || $cat_templ == '3col')
            {
                $height = apply_filters('portfolio1width',157);
                $width  = apply_filters('portfolio1height',285);
            }
            elseif ( $cat_templ == '4col')
            {
                $height = apply_filters('portfolio1width',112);
                $width  = apply_filters('portfolio1height',204);
            }
        }
        elseif($is_tf_blog_page)
        {
            	global $TFUSE;
            $cat_templ = tfuse_options('template_portfolio_blog');
            if ( $cat_templ == '1col')
            {
                $height = apply_filters('portfolio1width',199);
                $width  = apply_filters('portfolio1height',361);
            }
            elseif ( $cat_templ == '2col' || $cat_templ == '3col')
            {
                $height = apply_filters('portfolio1width',157);
                $width  = apply_filters('portfolio1height',285);
            }
            elseif ( $cat_templ == '4col')
            {
                $height = apply_filters('portfolio1width',112);
                $width  = apply_filters('portfolio1height',204);
            }
        }
        elseif ( is_tax()) {
            global $TFUSE;
            $term = get_term_by('slug', get_query_var('term'), get_query_var('taxonomy'));
            $cat_templ = tfuse_options('portfolio_tax_template','1col',$term->term_id);
            if ( $cat_templ == '1col')
            {
                $height = apply_filters('portfolio1width',199);
                $width  = apply_filters('portfolio1height',361);
            }
            elseif ( $cat_templ == '2col' || $cat_templ == '3col')
            {
                $height = apply_filters('portfolio1width',157);
                $width  = apply_filters('portfolio1height',285);
            }
            elseif ( $cat_templ == '4col')
            {
                $height = apply_filters('portfolio1width',112);
                $width  = apply_filters('portfolio1height',204);
            }

        }
        else{
            $height = $tfuse_media['img_dimensions'][1];
            $width  = $tfuse_media['img_dimensions'][0];
        }
        $sidebar_position = tfuse_sidebar_position();

        if ( ($height > 690 || $height <0) && $sidebar_position == 'full')
            $height = 690;
        elseif ( ($height > 690 || $height <0) && $sidebar_position != 'full')
            $height = 454;

        if (($width > 690 || $width <0) && $sidebar_position == 'full' )
            $width = 920;
        elseif ( ($width > 690 || $width <0) && $sidebar_position != 'full')
            $width = 606;

        $image = new TF_GET_IMAGE();
        $tfuse_image = $image->width($width)->height($height)->properties(array('class'=>'frame_box '.$tfuse_media['img_position']))->src($tfuse_media['image'])->get_img();

        if (  $src == true ){
            return $tfuse_media['image'];
        }

    }
    else
        return false;

    if (  ( (!is_singular() && !$tfuse_media['disable_listing_lightbox']) || (is_singular() && !$tfuse_media['disable_single_lightbox']) ) && !empty($tfuse_image) )
    {   $output='';
        $attachments = get_children( array('post_parent' => $post->ID, 'numberposts' => -1, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
        $output .= '<span style="display:none">';
        if ( !empty($tfuse_media['video_link']) ) $output .= '<a href="'. $tfuse_media['video_link'].'" rel="prettyPhoto[gallery'.$post->ID.']">'.$tfuse_image.'</a>';
        if( !empty($attachments) )
        {
            foreach ($attachments as $att_id => $attachment)
            {
                $tfuse_src = wp_get_attachment_image_src($att_id, 'full', true);
                $tfuse_image_link_attach = $tfuse_src[0];
                $output .= '<a href="'. $tfuse_image_link_attach.'" rel="prettyPhoto[gallery'.$post->ID.']">'.$tfuse_media['image'].'</a>';
            }
        }

        $output .= '</span>';
        $output .= '<a href="'.$tfuse_media['image'].'" rel="prettyPhoto[gallery'.$post->ID.']">'.$tfuse_image.'</a>';
    }
    else
        $output .= '<a href="'.get_permalink($post->ID).'">'.$tfuse_image.'</a>';

    if( $return )
        return $output;
    else
        echo $output;
}
endif; // tfuse_media
