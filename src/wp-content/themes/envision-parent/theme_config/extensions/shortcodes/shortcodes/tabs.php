<?php
// **************************Framed Tabs
function tfuse_framed_tabs($atts, $content = null)
{
	global $framedtabsheading;
	$framedtabsheading = '';
	extract(shortcode_atts(array('title' => '', 'class' => ''), $atts));

	$get_tabs = do_shortcode($content);

	$k = 0;
	$out = '
<!-- tab box -->
<div class="tabFrameBox '. $class.'">
	<ul class="tabs">
';
	while(isset($framedtabsheading[$k]))
	{
		$out .= $framedtabsheading[$k];
		$k++; 
	}
	$out .= '</ul>' . $get_tabs . '</div><!--/ tab box -->';
	return $out;
}
$atts = array(
    'name' => 'Tabs',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 8,
    'options' => array(
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode. To specify multiple classes,<br /> separate the class names with a space, e.g. <b>"left important"</b>',
            'id' => 'tf_shc_framed_tabs_class',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Title',
            'desc' => '',
            'id' => 'tf_shc_tabs_title',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_0 tf_shc_addable'),
            'type' => 'text'
        ),
        array(
            'name' => 'Content',
            'desc' => '',
            'id' => 'tf_shc_tabs_content',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_1 tf_shc_addable tf_shc_addable_last'),
            'divider' => TRUE,
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('tabs', 'tfuse_framed_tabs', $atts);

function tfuse_tab($atts, $content = null)
{
	global $framedtabsheading;
	extract(shortcode_atts(array('title' => ''), $atts));
    $k = 0;
	while(isset($framedtabsheading[$k])) { $k++;}
	( $title != '' ) ? $alt = 'alt="' . $title . '" title="' . $title . '"' : $alt = '';
	$framedtabsheading[] = '<li><a href="#"><span>' . $title . '</span></a></li>';
   
   $out = '<div id="tf_tabs_'.($k+1).'" class="tabcontent">';
    $out .= '
    <div class="inner">
    ' . do_shortcode($content) . '
    <div class="clear"></div>
    </div>
</div>';
	return $out;
}

$atts = array(
    'name' => 'Tab',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 8,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Specifies the title of an shortcode',
            'id' => 'tf_shc_tab_title',
            'value' => '',
            'type' => 'text'
        ),
        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter the tabs in this format:<i>[tab]Tab content[/tab]...</i>',
            'id' => 'tf_shc_tab_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);

add_shortcode('tab', 'tfuse_tab', $atts);
function tfuse_icon_tabs($atts, $content = null)
{
	global $tf_tabsheading;
	$tf_tabsheading = '';
	extract(shortcode_atts(array('title' => ''), $atts));

	$get_tabs = do_shortcode($content);

	$k = 0;
	$out = '
<!-- tab box -->
<div class="tabBox">
	<div class="tabTitle"><h3>' . $title . '</h3></div>
	<ul class="tabs">
';
	while(isset($tf_tabsheading[$k]))
	{
		$out .= $tf_tabsheading[$k];
		$k++;
	}
	$out .= '
	</ul>
' . $get_tabs . '
</div>
<!--/ tab box -->
';
	return $out;
}
$atts = array(
    'name' => 'Icon Tabs',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 8,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Specifies the title of an shortcode',
            'id' => 'tf_shc_icon_tabs_title',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Class',
            'desc' => 'Specifies one or more class names for an shortcode. To specify multiple classes,<br /> separate the class names with a space, e.g. <b>"left important"</b>',
            'id' => 'tf_shc_icon_tabs_class',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Width',
            'desc' => 'Specifies the width of an image',
            'id' => 'tf_shc_icon_tabs_width',
            'value' => '51',
            'type' => 'text'
        ),
        array(
            'name' => 'Height',
            'desc' => 'Specifies the height of an image',
            'id' => 'tf_shc_icon_tabs_height',
            'value' => '42',
            'type' => 'text'
        ),
        array(
            'name' => 'Icon',
            'desc' => 'Specifies the icon of an shortcode',
            'id' => 'tf_shc_icon_tabs_icon',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_0 tf_shc_addable'),
            'type' => 'text'
        ),
        array(
            'name' => 'Content',
            'desc' => '',
            'id' => 'tf_shc_icon_tabs_content',
            'value' => '',
            'properties' => array('class' => 'tf_shc_addable_1 tf_shc_addable tf_shc_addable_last'),
            'divider' => TRUE,
            'type' => 'textarea'
        )
    )
);

tf_add_shortcode('icon_tabs', 'tfuse_icon_tabs', $atts);

function tfuse_icon_tab($atts, $content = null)
{
	global $tf_tabsheading;
	extract(shortcode_atts(array('icon' => 'icon.png', 'width' => '51', 'height' => '42' ), $atts));
    $k = 0;
	while(isset($tf_tabsheading[$k])) { $k++;}
	$tf_tabsheading[] = '<li><a href="#"><img src="' . $icon . '" width="' . $width . '" height="' . $height . '"/></a></li>';

   $out = '<div id="tf_tabs_'.($k+1).'" class="tabcontent">';
    $out .= '
    <div class="inner">
    ' . do_shortcode($content) . '
    <div class="clear"></div>
    </div>
</div>';
	return $out;
}

$atts = array(
    'name' => 'Icon Tab',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 8,
    'options' => array(
        array(
            'name' => 'Icon',
            'desc' => 'Specifies the icon of an shortcode',
            'id' => 'tf_shc_icon_tab_icon',
            'value' => '',
            'type' => 'text'
        ),
        array(
            'name' => 'Width',
            'desc' => 'Specifies the width of an image',
            'id' => 'tf_shc_icon_tab_width',
            'value' => '51',
            'type' => 'text'
        ),
        array(
            'name' => 'Height',
            'desc' => 'Specifies the height of an image',
            'id' => 'tf_shc_icon_tab_height',
            'value' => '42',
            'type' => 'text'
        ),

        /* add the fllowing option in case shortcode has content */
        array(
            'name' => 'Content',
            'desc' => 'Enter the tabs in this format:<i>[icon_tab]Tab content[/icon_tab]...</i>',
            'id' => 'tf_shc_icon_tab_content',
            'value' => '',
            'type' => 'textarea'
        )
    )
);
add_shortcode('icon_tab', 'tfuse_icon_tab', $atts);

?>