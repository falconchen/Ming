<?php

/**
 * Chart
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * type: 3dpie, pie, line, bar
 * width: Enter width of chart e.g. 590
 * height: Enter height of chart e.g. 250
 * data: Enter the value area for parts of chart e.g. 65.671,60.252,31.381,47.092,37.329
 * label: Enter the name area for parts of chart e.g. Human Resource|Past Military|Current Military
 * colors: Enter the colors area for parts of char e.g. 4f762a,2c353d,999999,cccccc
 * legend: Enter the legend of charts e.g. 10%25|30%25|20%25
 */

function tfuse_chart($atts)
{
    extract(shortcode_atts(array('width'=>590,
                                'height'=>250,
                                'type'=>'',
                                'title'=>'',
                                'data'=>'',
                                'legend'=>'',
                                'label'=>'',
                                'colors'=>'',
                                'background'=>''), $atts));

    switch($type)
    {
        case '3dpie': $type = 'p3';  break;
        case 'pie':   $type = 'p';   break;
        case 'line':  $type = 'lc';  break;
        case 'bar':   $type = 'bvg'; break;
    }
    $width = (int) $width;
    $height = (int) $height;
    $data = trim($data);
    if ($type == 'p3' || $type == 'p')
        return '<p><img class="noborder" src="http://chart.apis.google.com/chart?chxs=0,555555,11.5&chxt=x&chs=' . $width . 'x' . $height . '&cht=' . $type . '&#038;chtt=' . $title . '&#038;chl=' . $label . '&#038;chco=' . $colors . '&#038;chs=' . $width . 'x' . $height . '&#038;chd=t:' . $data . '&chdl=' . $legend . '&#038;chf=bg,s,'. $background . '" alt="' . $title . '"  /></p>';
    elseif ($type == 'lc')
        return '<p><img class="noborder" src="http://chart.apis.google.com/chart?chs=' . $width . 'x' . $height . '&chf=bg,s,'. $background . '&chl=' . $label . '&cht=lc&chco=' . $colors . '&chd=t:' . $data . '&chdlp=b&chg=4,1,0,5&chls=1&chma=|0,10&chtt=' . $title . '&chts=676767,13.5" width="' . $width . '" height="' . $height . '" alt="' . $title . '" /></p>';
    elseif ($type == 'bvg')
        return '<p><img class="noborder" src="http://chart.apis.google.com/chart?chbh=a&chs=' . $width . 'x' . $height . '&chf=bg,s,'. $background . '&cht=bvs&chco=' . $colors . '&chd=t:' . $data . '&chdl=' . $legend . '&chdlp=b&chg=4,1,0,5&chma=|0,10&chtt=' . $title . '&chts=676767,13.5" width="' . $width . '" height="' . $height . '" alt="' . $title . '" /></p>';
    else
        return '<p><img class="noborder" src="http://chart.apis.google.com/chart?chxs=0,555555,11.5&chxt=x&chs=' . $width . 'x' . $height . '&cht=' . $type . '&#038;chtt=' . $title . '&#038;chl=' . $label . '&#038;chco=' . $colors . '&#038;chs=' . $width . 'x' . $height . '&#038;chd=t:' . $data . '&chdl=' . $legend . '&#038;chf=bg,s,'. $background . '" alt="' . $title . '"  /></p>';
}

$atts = array(
    'name' => 'Charts',
    'desc' => 'Here comes some lorem ipsum description for the chart shortcode.',
    'category' => 3,
    'options' => array(
        array(
            'name' => 'Width',
            'desc' => 'Specifies the width of an shortcode',
            'id' => 'tf_shc_chart_width',
            'value' => '540',
            'type' => 'text'
        ),
        array(
            'name' => 'Height',
            'desc' => 'Specifies the height of an shortcode',
            'id' => 'tf_shc_chart_height',
            'value' => '250',
            'type' => 'text'
        ),
        array(
            'name' => 'Type',
            'desc' => 'Select chart type',
            'id' => 'tf_shc_chart_type',
            'value' => '3dpie',
            'options' => array(
                '3dpie' => '3D ROUND PIE',
                'pie' => '2D ROUND PIE',
                'line' => 'LINE CHART',
                'bar' => 'BAR CHART'
            ),
            'type' => 'select'
        ),
        array(
            'name' => 'Title',
            'desc' => 'Text to display above the chart',
            'id' => 'tf_shc_chart_title',
            'value' => 'The most popularity internet browser',
            'type' => 'text'
        ),
        array(
            'name' => 'Data',
            'desc' => 'The data to use to draw the chart, separated by comma',
            'id' => 'tf_shc_chart_data',
            'value' => '40,25,5,25,5',
            'type' => 'text'
        ),
        array(
            'name' => 'Legend',
            'desc' => 'Specifies the legend of an shortcode, separated by vertical bar <b>"|"</b>',
            'id' => 'tf_shc_chart_legend',
            'value' => '40|25|5|25|5',
            'type' => 'text'
        ),
        array(
            'name' => 'Label',
            'desc' => 'A label for the chart',
            'id' => 'tf_shc_chart_label',
            'value' => 'Internet Explorer|Firefox|Safari|Chrome|Others',
            'type' => 'text'
        ),
        array(
            'name' => 'Colors',
            'desc' => 'Colors a cell according to whether the values fall within a specified range',
            'id' => 'tf_shc_chart_colors',
            'value' => 'FF9900|E40B0B|1B9A1B|3399CC|BBCCED',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('chart', 'tfuse_chart', $atts);
