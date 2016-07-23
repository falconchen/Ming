<?php

/**
 * Minigallery
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * id: post/page id
 * order: ASC, DESC
 * orderby:
 * include:
 * exclude:
 * pretty: true/false use or not prettyPhoto
 * icon_plus:
 * class: css class e.g. boxed
 * carousel: jCarousel Configuration. http://sorgalla.com/projects/jcarousel/
 */

function tfuse_minigallery($attr, $content = null)
{
    global $post;

    if (isset($attr['orderby'])) {
        $attr['orderby'] = sanitize_sql_orderby($attr['orderby']);
        if (!$attr['orderby'])
            unset($attr['orderby']);
    }

    extract(shortcode_atts(array(
            'order'      => 'ASC',
            'orderby'    => 'menu_order ID',
            'id' => isset($post->ID) ? $post->ID : $attr['id'],
            'include'    => '',
            'exclude'    => '',
            'pretty'     => true,
            'icon_plus'  => '<span></span>',
            'carousel'   => 'easing: "easeInOutQuint",animation: 600',
            'class'      => 'boxed'
    ), $attr));

    if ( !empty($include) ) {
        $include = preg_replace('/[^0-9,]+/', '', $include);
        $_attachments = get_posts(array('include' => $include, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));

        $attachments = array();
        foreach ($_attachments as $key => $val) {
            $attachments[$val->ID] = $_attachments[$key];
        }
    } elseif ( !empty($exclude) ) {
        $exclude = preg_replace('/[^0-9,]+/', '', $exclude);
        $attachments = get_children(array('post_parent' => $id, 'exclude' => $exclude, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    } else {
        $attachments = get_children(array('post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $order, 'orderby' => $orderby));
    }

    if ( empty($attachments) )
        return '';

    $uniq = rand(1, 200);

    $out = '';

    $out .= '
    <div class="minigallery-list ' . $class . '">
		<a class="prev">prev</a><a class="next">next</a><div class="minigallery">
        <ul>';

    if ($icon_plus)
        $out .= '<span></span>';

    foreach ($attachments as $id => $attachment)
    {

        $link = wp_get_attachment_image_src($id, 'full', true);
        $image_link_attach = $link[0];
        $imgsrc = wp_get_attachment_image_src($id, array(139, 90), false);
        $image_src = $imgsrc[0];

        $image = new TF_GET_IMAGE();
        $img = $image->width(139)->height(90)->properties(array('alt' => $attachment->post_title))->src($image_src)->get_img();

        if ( $pretty )
            $out .= '<li><a href="' . $image_link_attach . '" rel="prettyPhoto[gallery' . $uniq . ']">'
                    . $img . $icon_plus . '</a></li>';
        else
            $out .= '<li>' . $img . '</li>';
    }

    $out .= '</ul></div><div class="clear"></div></div>';

    return $out;
}

$atts = array(
    'name' => 'Minigallery',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 6,
    'options' => array(
        array(
            'name' => 'ID',
            'desc' => 'Specifies the post or page ID. For more detail about this shortcode follow the <a href="http://codex.wordpress.org/Template_Tags/get_posts" target="_blank">link</a>',
            'id' => 'tf_shc_minigallery_id',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode. To specify multiple classes,<br /> separate the class names with a space, e.g. <b>"left important"</b>',
            'id' => 'tf_shc_minigallery_class',
            'value' => '',
            'type' => 'text'
        )

    )
);

tf_add_shortcode('minigallery', 'tfuse_minigallery', $atts);
