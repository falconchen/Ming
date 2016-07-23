<?php

/**
 * Testimonials
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * title:
 * order: RAND, ASC, DESC
 */
function tfuse_testimonials($atts, $content = null) {
    global $testimonials_uniq;
    extract(shortcode_atts(array('title' => '', 'order ' => 'RAND'), $atts));

    $slide = $nav = $single = '';

    $testimonials_uniq = rand(1, 300);

    if (!empty($title))
        $title = '<h3>' . $title . '</h3>';

    if (!empty($order) && ($order == 'ASC' || $order == 'DESC'))
        $order = '&order=' . $order;
    else
        $order = '&orderby=rand';

    query_posts('post_type=testimonials&posts_per_page=-1' . $order);
    $k = 0;
    if (have_posts()) {
        while (have_posts()) {
            $k++;
            the_post();
            global $more; $more = 0;
            $positions = '';
            $terms = get_the_terms(get_the_ID(), 'positions');

            if (!is_wp_error($terms) && !empty($terms))
                foreach ($terms as $term)
                    $positions .= ', ' . $term->name;

            $slide .= '
                <div class="slide">
                    <div class="quote-text">' . get_the_content() . '</div>
                    <div class="quote-author"><span>'.get_the_title().'</span>'.$positions.'</div></div>
        ';
        } // End WHILE Loop
    } // End IF Statement
    wp_reset_query();

    $output = '
    <div id="testimonials' . $testimonials_uniq . '" class="slide slideshow slideQuotes quoteBox-big">
        '.$title.'<div class="slides_container"'.$single.'>'.$slide.'</div></div>';
     $output .= '<script language="javascript" type="text/javascript">
		jQuery(document).ready(function($){
            $("#testimonials' . $testimonials_uniq . '").slides({
                play: 8000,
                autoHeight: true,
                pagination: false,
                generatePagination: false,
                effect: "fade",
                fadeSpeed: 150});
        });
    </script>';
    return $output;
}

$atts = array(
    'name' => 'Testimonials',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Specifies the title of an shortcode',
            'id' => 'tf_shc_testimonials_title',
            'value' => 'Testimonials',
            'type' => 'text'
        ),
        array(
            'name' => 'Order',
            'desc' => 'Select display order',
            'id' => 'tf_shc_testimonials_order',
            'value' => 'DESC',
            'options' => array(
                'RAND' => 'Random',
                'ASC' => 'Ascending',
                'DESC' => 'Descending'
            ),
            'type' => 'select'
        )
    )
);

tf_add_shortcode('testimonials', 'tfuse_testimonials', $atts);
