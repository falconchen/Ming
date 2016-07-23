<?php

/**
 * List Styles
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 */

function tfuse_check_list($atts, $content = null)
{

    $content = str_replace('<ul>', '<ul class="list_check">', do_shortcode($content));
    return $content;

}

$atts = array(
    'name' => 'Check List',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 2,
    'options' => array(
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Use the &lt;ul&gt; tag together with the &lt;li&gt; tag to create check lists',
            'id' => 'tf_shc_check_list_content',
            'value' => '
<ul>
    <li>item 1</li>
    <li>item 2</li>
    <li>item 3</li>
</ul>
            ',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('check_list', 'tfuse_check_list', $atts);

function tfuse_delete_list($atts, $content = null) {

    $content = str_replace('<ul>', '<ul class="list_delete">', do_shortcode($content));
    return $content;
}

$atts = array(
    'name' => 'Delete List',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 2,
    'options' => array(
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Use the &lt;ul&gt; tag together with the &lt;li&gt; tag to create delete lists',
            'id' => 'tf_shc_delete_list_content',
            'value' => '
<ul>
    <li>item 1</li>
    <li>item 2</li>
    <li>item 3</li>
</ul>
            ',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('delete_list', 'tfuse_delete_list', $atts);

function tfuse_arrow_list($atts, $content = null)
{
	$content = str_replace('<ul>', '<ul class="list_arrows">', do_shortcode($content));
	return $content;
}
$atts = array(
    'name' => 'Arrow List',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 2,
    'options' => array(
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Use the &lt;ul&gt; tag together with the &lt;li&gt; tag to create delete lists',
            'id' => 'tf_shc_arrow_list_content',
            'value' => '
<ul>
    <li>item 1</li>
    <li>item 2</li>
    <li>item 3</li>
</ul>
            ',
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('arrow_list', 'tfuse_arrow_list', $atts);
