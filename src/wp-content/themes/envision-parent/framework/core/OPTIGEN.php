<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

/**
 * Generate html for input types (only for backend)
 */
class TF_OPTIGEN extends TF_TFUSE
{
    public $_the_class_name = 'OPTIGEN';

    function __construct()
    {
        parent::__construct();
    }

    function _auto($opts)
    {
        if (isset($opts['type']))
            return $this->{$opts['type']}($opts);
        else
            die('Option type not set in OPTIGEN.');
    }

    /**
     * Simple input text
     */
    function text($opts)
    {
        if (!empty($opts['stepper'])) {
            wp_enqueue_script('jquery');
            if (!$this->include->type_is_registered('stepper_js')) {
                $this->include->register_type('stepper_js', TFUSE . '/static/javascript');
                $this->include->js('jquery.fs.stepper.min', 'stepper_js', 'tf_head', 10, '0.9.8');
                $this->include->js('tfuse_stepper', 'stepper_js', 'tf_head', 10, '1.1');
                $this->include->register_type('stepper_css', TFUSE . '/static/css');
                $this->include->css('jquery.fs.stepper', 'stepper_css', 'tf_head', '1.0');
            }
            $stepper_class =' tfuse-stepper ';
        }

        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        # set some defaults
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option'.(isset($stepper_class)?$stepper_class:'');
        #end set defaults
        $propstr = $this->propstr($opts['properties']);
        # properties
        $output = '<input ' . $propstr . ' name="' . esc_attr($opts['id']) . '" id="' . esc_attr($opts['id']) . '" type="text" value="' . esc_attr($opts['value']) . '" />';
        if (has_filter("tfuse_form_text_{$opts['id']}")) {
            return apply_filters("tfuse_form_text_{$opts['id']}", $output, $opts);
        }

        return apply_filters('tfuse_form_text', $output, $opts);
    }

    function addable($opts)
    {
        $output = '<input type="hidden" name="' . esc_attr($opts['id']) . '" id="' . esc_attr($opts['id']) . '" value="' . esc_attr($opts['value']) . '"/>';

        foreach ($opts['options'] as $option) {
            $output .= '' . $this->_auto($option);
        }

        if (has_filter("tfuse_form_addable_{$opts['id']}")) {
            return apply_filters("tfuse_form_addable_{$opts['id']}", $output, $opts);
        }

        return apply_filters('tfuse_form_addable', $output, $opts);
    }

    /**
     * Raw html with no value
     */
    function raw($opts)
    {
        $output = '<input type="hidden" value=""/>';
        $output.='<span class="raw_option" id="' . $opts['id'] . '">' . $opts['html'] . '</span>';
        if (has_filter("tfuse_form_raw_{$opts['id']}")) {
            return apply_filters("tfuse_form_raw_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_raw', $output, $opts);
    }

    function colorpicker($opts)
    {
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        # set some defaults
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tf_color_select tfuse_option';
        #end set defaults
        $opts['properties'] = $this->strip_props($opts['properties']);
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $output = '<input ' . $propstr . ' name="' . esc_attr($opts['id']) . '" id="' . esc_attr($opts['id']) . '" type="text" value="' . esc_attr($opts['value']) . '" />';
        if (has_filter("tfuse_form_colorpicker_{$opts['id']}")) {
            return apply_filters("tfuse_form_colorpicker_{$opts['id']}", $output, $opts);
        }

        return apply_filters('tfuse_form_colorpicker', $output, $opts);
    }

    function textarray($opts)
    {
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        # set some defaults
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option';
        #end set defaults
        $opts['properties'] = $this->strip_props($opts['properties']);
        $propstr = $this->propstr($opts['properties']);
        # properties
        $output = '<input ' . $propstr . ' name="' . esc_attr($opts['id']) . '[]" id="' . esc_attr($opts['id']) . '_w" type="text" value="' . esc_attr($opts['value'][0]) . '" />';
        $output .= ' X <input ' . $propstr . ' name="' . esc_attr($opts['id']) . '[]" id="' . esc_attr($opts['id']) . '_h" type="text" value="' . esc_attr($opts['value'][1]) . '" />';
        if (has_filter("tfuse_form_textarray_{$opts['id']}")) {
            return apply_filters("tfuse_form_textarray_{$opts['id']}", $output, $opts);
        }

        return apply_filters('tfuse_form_textarray', $output, $opts);
    }

    /**
     * Simple textarea
     */
    function textarea($opts)
    {
        $propstr = '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        # assign some default properties, if not implicitely set
        if (!isset($opts['properties']['cols']))
            $opts['properties']['cols'] = 5;
        if (!isset($opts['properties']['rows']))
            $opts['properties']['rows'] = 8;
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option';
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $output = '<textarea ' . $propstr . ' name="' . $opts['id'] . '" id="' . $opts['id'] . '">' . esc_attr($opts['value']) . '</textarea>';
        if (has_filter("tfuse_form_textarea_{$opts['id']}")) {
            return apply_filters("tfuse_form_textarea_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_textarea', $output, $opts);
    }

    /**
     * Checkbox as Yes/No image
     */
    function checkbox($opts)
    {
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        #set some default values
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' single_checkbox tfuse_option';
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $checked = (isset($opts['value']) && $opts['value'] == 'true') ? 'checked="checked"' : '';
        $on = $checked ? ' on' : '';
        if(!isset($opts['disabled'])) $opts['disabled'] = 'false';
        $disabled = ($opts['disabled'] == 'true') ? ' disabled' : '';
        $output = '<input type="hidden" '. ($opts['value']=='true' ? 'hiddenname' : 'name') .'="' . $opts['id'] . '" value="false" class="checkbox_default_hidden_value" />';
        $output .= '<input ' . $propstr . ' type="checkbox" name="' . $opts['id'] . '" id="' . $opts['id'] . '" value="true" ' . $checked . ' />';
        if($disabled) $output = '<input type="hidden" name="' . $opts['id'] . '" value="'.(in_array($opts['value'], array('true','false')) ? $opts['value'] : 'false').'" />';
        $output.='<label class="tf_checkbox_switch' . $on . $disabled . '" for="' . $opts['id'] . '"></label>';
        if (has_filter("tfuse_form_checkbox_{$opts['id']}")) {
            return apply_filters("tfuse_form_checkbox_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_checkbox', $output, $opts);
    }

    function radio($opts)
    {
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        #set some default values
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option checkbox ' . $opts['id'];
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $output = '';
        foreach ($opts['options'] as $key => $option) {
            if ($key === 0)
                continue;

            $checked = ($opts['value'] === (string) $key) ? 'checked="checked"' : '';

            $output .= '
            <div class="multicheckbox"><input ' . $propstr . ' type="radio" name="' . $opts['id'] . '"  value="' . $key . '" ' . $checked . ' />
            ' . $option . '</div>';
        }

        if (has_filter("tfuse_form_radio_{$opts['id']}")) {
            return apply_filters("tfuse_form_radio_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_radio', $output, $opts);
    }

    /**
     * Simple select
     */
    function select($opts)
    {
        $propstr = '';
        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        #set some default values
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'].=' tfuse_option';
        #end set defaults
        $propstr = $this->propstr($opts['properties']);
        # /properties
        $output = '<select ' . $propstr . ' name="' . $opts['id'] . '" id="' . $opts['id'] . '">';

        if(isset($opts['options']) && count($opts['options']) > 0)
            foreach ($opts['options'] as $key => $option) {
                $selected = ($opts['value'] == $key) ? ' selected="selected"' : '';

                $output .= '<option' . $selected . ' value="' . $key . '">';
                $output .= $option;
                $output .= '</option>';
            }

        $output .= '</select>';

        if (has_filter("tfuse_form_select_{$opts['id']}")) {
            return apply_filters("tfuse_form_select_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_select', $output, $opts);
    }

    function styles()
    {
        $styles = array();

        foreach (glob(TEMPLATEPATH . '/styles/*.css') as $style) {
            $style = basename($style);
            $styles[$style] = $style;
        }

        return apply_filters('tfuse_form_styles', $styles);
    }

    function category_template()
    {
        $templates = array();

        foreach (glob(TEMPLATE_CAT . '/*.php') as $template) {
            $templates[$template] = $template;
        }

        return apply_filters('tfuse_form_category_template', $templates);
    }

    function single_template()
    {
        $templates = array();

        foreach (glob(TEMPLATE_POST . '/*.php') as $template) {
            $templates[$template] = $template;
        }

        return apply_filters('tfuse_form_single_template', $templates);
    }

    function categories($args = array())
    {
        if (!isset($args['hide_empty']))
            $args['hide_empty'] = 0;

        $tfuse_categories = array();
        $tfuse_categories[0] = __('Select a category:', 'tfuse');
        $tfuse_categories_obj = get_categories($args);

        if (is_array($tfuse_categories_obj)) {
            foreach ($tfuse_categories_obj as $tfuse_cat) {
                $tfuse_categories[$tfuse_cat->cat_ID] = $tfuse_cat->cat_name;
            }
        }

        return apply_filters('tfuse_form_categories', $tfuse_categories, $args);
    }

    function dropdown_categories($opts)
    {
        if (isset($opts['options']))
            $args = $opts['options'];
        $args['echo'] = 0;

        if (!isset($args['selected']))
            $args['selected'] = $opts['value'];

        if (!isset($args['show_option_none']))
            $args['show_option_none'] = __('Select a category:', 'tfuse');

        if (!isset($args['name']))
            $args['name'] = $opts['id'];

        if (!isset($args['id']))
            $args['id'] = $opts['id'];

        if (!isset($args['hide_empty']))
            $args['hide_empty'] = 0;

        if (!isset($args['hierarchical']))
            $args['hierarchical'] = 1;

        $tfuse_categories = wp_dropdown_categories($args);

        return apply_filters('tfuse_form_dropdown_categories', $tfuse_categories, $opts);
    }

    function pages($args = array())
    {
        if ($args == '')
            $args = 'sort_column=post_parent,menu_order';
        $tfuse_pages = array();
        $tfuse_pages[0] = __('Select a page:', 'tfuse');
        $tfuse_pages_obj = get_pages($args);

        if (is_array($tfuse_pages_obj)) {
            foreach ($tfuse_pages_obj as $tfuse_page) {
                $tfuse_pages[$tfuse_page->ID] = $tfuse_page->post_title;
            }
        }

        return apply_filters('tfuse_form_pages', $tfuse_pages, $args);
    }

    function dropdown_pages($opts)
    {
        if (isset($opts['options']))
            $args = $opts['options'];
        $args ['echo'] = 0;

        if (!isset($args['selected']))
            $args['selected'] = $opts['value'];

        if (!isset($args['show_option_none']))
            $args['show_option_none'] = __('Select a page:', 'tfuse');

        if (!isset($args['name']))
            $args['name'] = $opts['id'];

        if (!isset($args['id']))
            $args['id'] = $opts['id'];

        if (!isset($args['hide_empty']))
            $args['hide_empty'] = 0;

        $tfuse_categories = wp_dropdown_pages($args);
        return apply_filters('tfuse_form_dropdown_pages', $tfuse_categories, $opts);
    }

    function posts($args = array(), $title = 'Select a post:')
    {
        if ($args == '')
            $args = 'numberposts=-1';
        $tfuse_posts = array();
        $tfuse_posts[0] = __($title, 'tfuse');
        $tfuse_posts_obj = get_posts($args);

        if (is_array($tfuse_posts_obj)) {
            foreach ($tfuse_posts_obj as $tfuse_post) {
                $tfuse_posts[$tfuse_post->ID] = $tfuse_post->post_title;
            }
        }
        return apply_filters('tfuse_form_posts', $tfuse_posts, $args);
    }

    function tags($args = array('get' => 'all'))
    {
        if (!isset($args ['get']))
            $args['get'] = 'all';

        $post_txt = 'posts';
        $images_txt = 'with images';

        if (isset($args['short'])) {
            $post_txt = $images_txt = '';
        }

        $all_post_tags = get_terms('post_tag', $args);
        $tfuse_tags [0] = __('Select a tag:', 'tfuse');

        if (isset($args['count_images']) or isset($args['count_posts'])) {
            //get nr of posts with images for each tag
            $posts_images_tag = array();
            foreach ($all_post_tags as $post_tags) {
                $counttagposts = get_posts('tag=' . $post_tags->slug);
                $i = 0;

                //The Loop
                foreach ($counttagposts as $post) {
                    setup_postdata($post);
                    $key = $args['imgsource'];
                    $this->load->helper('GET_IMAGE');
                    $im = new TF_GET_IMAGE;
                    $im = $im->id($post->ID)->key($key)->from_src()->get_src();
                    if ($im != '')
                        $i++;
                }

                $posts_images_tag[$post_tags->slug] = $i; //nr of posts with images for this tag

                $tfuse_tags[$post_tags->slug] = $post_tags->name . ' (' . $post_tags->count . " $post_txt/" . $posts_images_tag [$post_tags->slug] . " $images_txt)";
            }
        } //end count images
        else {
            //get nr of posts with images for each tag
            foreach ($all_post_tags as $post_tags) {
                $tfuse_tags[$post_tags->slug] = $post_tags->name;
            }
        }

        return apply_filters('tfuse_form_tags', $tfuse_tags, $args);
    }

    /**
     * Input text with search auto complete, under it a list of added elements
     */
    function multi($opts)
    {
        $subtypes   = array_map('trim', (array)explode(',', $opts['subtype']));
        $tmp = $subtypes;
        $first_type = array_shift($tmp);
        unset($tmp);

        if (taxonomy_exists($first_type))
            $type = 'taxonomy';
        elseif (post_type_exists($first_type))
            $type = 'post';

        $saved_data         = trim( ( isset($opts['value']) && $opts['value'] ) ? $opts['value'] : '');
        $saved_data_array   = array_map('trim', (array)explode(',', $saved_data));

        $valid_data     = array();
        $errors_found   = false;
        $output_values  = '';
        if ($saved_data) {
            if ($type == 'taxonomy') {
                foreach ($saved_data_array as $sid) {
                    $term = null;
                    foreach($subtypes as $key=>$subtype){
                        if(false !== ($term = get_term($sid, $subtype))){
                            break;
                        } else {
                            unset($saved_data_array[$key]);
                            continue;
                        }
                    }
                    if($term !== null)
                        $valid_data[$sid] = $sid;
                    else
                        $errors_found = true;

                    $output_values .= '<span><a rel="' . $sid . '" title="' . __('Remove', 'tfuse') . '" class="remove_multi_items ntdelbutton">x</a>&nbsp ' . ($term !== null ? $term->name : '<i style="color:#999;font-style:normal;">(no term_id='.$sid.' in '.$subtype.')</i>') . '</span>';
                }
            } elseif ($type == 'post') {
                foreach ($saved_data_array as $sid) {

                    $valid_data[$sid] = $sid;

                    $output_values .= '<span><a rel="' . $sid . '" title="' . __('Remove', 'tfuse') . '" class="remove_multi_items ntdelbutton">x</a>&nbsp ' . get_the_title($sid) . '</span>';
                }
            }
        }

        $output = '<div class="multiple_box">';
        $output .= '<input type="hidden" name="' . $opts['id'] . '" id="' . $opts['id'] . '" class="' . $opts['id'] . ' tfuse_option" value="' . implode(',', array_map('esc_attr', $valid_data) ) . '" />';
        $output .= '<input type="text" id="' . $opts['id'] . '_entries" name="' . $opts['id'] . '_entries" class="tfuse_suggest_input tfuse_' . $type . '_type tfuse_input_help_text" rel="' . esc_attr($opts['subtype']) . '" value="' . esc_attr( __('Type here to search', 'tfuse') ) . '" />';

        $output .= '<div id="' . $opts['id'] . '_titles" class="multiple_box_selected_titles tagchecklist">';
        $output .= '<span style="display:none;"><a rel="0" title="' . __('Remove', 'tfuse') . '" class="remove_multi_items ntdelbutton">x</a>&nbsp </span>';

        $output  .= $output_values;

        $output .= '</div>';
        if ($errors_found)
            $output .= '<div style="padding-top:10px;"><i style="color:#999;">'.__('Tip: Save options to get rid of invalid ids', 'tfuse').'</i></div>';
        $output .= '</div>';

        return apply_filters('tfuse_form_multi', $output, $opts);
    }

    function boxes($opts)
    {
        $output = '';
        for ($i = 1; $i <= $opts['count']; $i++) {

            $divider = ( array_key_exists('divider', $opts) && $opts['divider'] === TRUE ) ? ' divider' : '';
            $output .= '<div class="option option-' . $opts['type'] . '">';
            $output .= '<div class="option-inner">';
            $output .= '<label class="titledesc">' . $opts['name'] . ' ' . $i . '</label>';
            $output .= '<div class="formcontainer">';

            $output .= '<div class="how_to_populate">';

            //select box
            $output .= '<select name="' . $opts['id'] . $i . '" class="postform selector tfuse_option">';
            $output .= '<option value="">HTML (simple placeholder text gets applied) </option>';

            $s1 = $s2 = $s3 = '';
            $box_type = isset($opts['value'][$opts['id'] . $i]) ? $opts['value'][$opts['id'] . $i] : '';
            if ($box_type == 'post')
                $s1 = 'selected="selected"';
            if ($box_type == 'page')
                $s2 = 'selected="selected"';
            if ($box_type == 'widget')
                $s3 = 'selected="selected"';

            $output .= '<option ' . $s1 . ' value="post">Post</option>';
            $output .= '<option ' . $s2 . ' value="page">Page</option>';
            $output .= '<option ' . $s3 . ' value="widget">Widget</option>';

            $output .= '</select><br/>';

            //categories
            $s1 = $s2 = $s3 = '';
            if ($box_type != 'post')
                $s1 = 'hidden';

            $output .= '<span class="selected_post ' . $s1 . '">';

            $params['id'] = $opts['id'] . $i . '_post';
            $params['subtype'] = apply_filters('tfuse_form_boxes_categories_subtype', 'category');
            if (isset($opts['value'][$params['id']]))
                $params['value'] = $opts['value'][$params['id']];
            $output .= $this->multi($params);

            $output .= '<br/></span>';

            //pages
            if ($box_type != "page")
                $s2 = "hidden";
            $output .= '<span class="selected_page ' . $s2 . '">';

            $params['id'] = $opts['id'] . $i . '_page';
            $params['subtype'] = apply_filters('tfuse_form_boxes_pages_subtype', 'page');
            if (isset($opts['value'][$params['id']]))
                $params['value'] = $opts['value'][$params['id']];
            $output .= $this->multi($params);

            $output .= '<br/></span>';

            //widgets
            if ($box_type != 'widget')
                $s3 = 'hidden';

            $output .= '<span class="selected_widget ' . $s3 . '">';
            $output .= 'Please save this page, then head over to the <a href="widgets.php">widget page</a> and add widgets to the <a href="widgets.php">"' . $opts['name'] . ' ' . $i . ' Widget Area"</a>';
            $output .= '</span></div><br/><br/>';
            $output .= '</div>';
            $output .= '<div class="desc">' . $opts['desc'] . ' ' . $i . '</div>';
            $output .= '<div class="clear"></div>';
            $output .= '</div></div>';
            $output .= '<div class="clear' . $divider . '"></div>' . "\n";
        }

        return apply_filters('tfuse_form_boxes', $output, $opts);
    }

    /**
     * Like radio input but with images as options
     */
    function images($opts)
    {
        $i = 0;
        $output = '';

        foreach ($opts['options'] as $key => $option) {
            $i++;
            $checked = $selected = '';

            if (empty($opts['value']) && $i == 1) {
                $checked = ' checked="checked"';
                $selected = 'tfuse-meta-radio-img-selected';
            } elseif ($opts['value'] == $key) {
                $checked = ' checked="checked"';
                $selected = 'tfuse-meta-radio-img-selected';
            }

            $output .= '<div class="tfuse-meta-radio-img-box">';
            $output .= '<div class="tfuse-meta-radio-img-label">';
            $output .= '<input type="radio" id="tfuse-meta-radio-img-' . $opts['id'] . $i . '" class="checkbox tfuse-meta-radio-img-radio tfuse_option" value="' . esc_attr($key) . '" name="' . esc_attr($opts['id']) . '" ' . $checked . ' />';
            $output .= '&nbsp;' . esc_html($key) . '<div class="tfuse_spacer"></div>';
            $output .= '</div>';
            $output .= '<div class="thumb_radio_over ' . $selected . '" title="' . esc_attr($option[1]) . '"></div><img title="' . esc_attr($option[1]) . '" src="' . esc_url($option[0]) . '" alt="" class="tfuse-meta-radio-img-img" optval="' . esc_attr($key) . '" />';
            $output .= '</div>';
        }

        return apply_filters('tfuse_form_images', $output, $opts);
    }

    /**
     * Simple hidden input
     */
    function hidden($opts)
    {
        $output = '<input type="hidden" id="'.$opts['id'].'" name="'.$opts['id'].'" value="'.$opts['value'].'" />';

        return apply_filters('tfuse_form_hidden', $output, $opts);
    }

    function upload($opts)
    {
        global $post;

        wp_enqueue_script('media-upload');

        $id     = $opts['id'];
        $type   = $opts['type'];
        $upload = isset($opts['value']) ? esc_attr($opts['value']) : '';

        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        # assign some default properties
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'] = ' upload-input-text tfuse_option';
        $propstr = $this->propstr($opts['properties']);
        # /properties

        $media      = (!empty($opts['media']) ) ? $opts['media'] : 'image';
        $post_type  = ($media == 'image') ? 'tfuse_gallery_group_post' : 'tfuse_download_group_post';
        $group      = (!empty($post->ID)) ? $post->ID: $post_type($id);
        $val        = (!empty($upload) && $type == 'upload' ) ? $upload : '';
        $post_class = (isset($post))?$post->post_type  :'';

        $output = '<input '. $propstr .' name="'. $id .'" id="'. $id .'" type="text" value="'. esc_attr($val) .'" rel="'. $media .'" />';
        $output .= '<div class="upload_button_div"><a href="#" class="button upload_button '. $post_class .'" id="'. $id .'_button" rel="'. $group .'">'. __('Upload', 'tfuse') .'</a> </div>';

        return apply_filters('tfuse_form_upload', $output, $opts);
    }

    function multi_upload($opts)
    {
        global $post;

        wp_enqueue_script('media-upload');

        $id     = $opts['id'];
        $type   = $opts['type'];
        $upload = isset($opts['value']) ? esc_attr($opts['value']) : '';

        # properties
        if (!isset($opts['properties']))
            $opts['properties'] = array();
        $opts['properties'] = array_merge($opts['properties'], $this->_common_properties($opts)); #merges the common properties with the user defined properties
        $opts['properties'] = $this->strip_props($opts['properties']);
        # assign some default properties
        if (!isset($opts['properties']['class']))
            $opts['properties']['class'] = '';
        $opts['properties']['class'] = ' upload-input-text tfuse_option';
        $propstr = $this->propstr($opts['properties']);
        # /properties

        $media      = (!empty($opts['media']) ) ? $opts['media'] : 'image';
        $post_type  = ($media == 'image') ? 'tfuse_gallery_group_post' : 'tfuse_download_group_post';

        if(!isset($post->ID)){
            $post_id = $post_type($id);
        } else {
            $_token  = $id .'_'. $post->ID;
            $post_id = ($flag = check_if_tfuse_group_post_exists($_token, $post_type)) ? $flag : $post->ID;
        }

        $val = (!empty($upload) && $type == 'upload' ) ? $upload : '';

        $num_images = 0;
        if(!isset($post->ID) || $post->ID != $post_id){
            $images = get_children('post_type=attachment&post_parent='. $post_id);
            $num_images = count($images);
        }

        $tab = ($num_images) ? 'gallery' : 'type';
        $post_class  = (isset($post) ) ? $post->post_type : '';
        $button_text = ($num_images) ? __('Add/Edit Images', 'tfuse') : __('Upload Images', 'tfuse');

        $output = '<div class="upload_button_div"><span class="attachment_num">'.$num_images.'</span> Images Uploaded <a tab='. $tab .' href="#" class="multi_upload button upload_button '. $post_class .'" id="'. $id .'_button" rel="'. $post_id .'">'. $button_text .'</a> </div>';

        return apply_filters('tfuse_form_multi_upload', $output, $opts);
    }

    function callback($opts)
    {
        $output = $this->callbacks->execute($opts);
        return $output;
    }

    function strip_props($arr)
    {
        if (array_key_exists('type', $arr))
            unset($arr['type']);
        if (array_key_exists('value', $arr))
            unset($arr['value']);
        if (array_key_exists('id', $arr))
            unset($arr['id']);
        if (array_key_exists('name', $arr))
            unset($arr['name']);
        if (array_key_exists('checked', $arr))
            unset($arr['checked']);
        return $arr;
    }

    function propstr($arr)
    {
        $out = '';
        foreach ($arr as $name => $value) {
            $out.=' ' . $name . '="' . esc_attr($value) . '" ';
        }
        return $out;
    }

    protected function _common_properties(&$opts)
    {
        #Workout of common properties, such as the required property, etc
        $out = array();
        if (isset($opts['required']) && $opts['required'] === TRUE) {
            $out['required'] = 'true';
        }
        return $out;
    }

    function captcha($opts)
    {
        $out='';
        $class=$opts['properties']['class'];
        $class.="tfuse_captcha_reload";
        $propstr = $this->propstr($opts['properties']);
        $out.="<img  src='".TFUSE_EXT_URI."/". strtolower($opts["_class_name"])."/library/".$opts['file_name']."' class='tfuse_captcha_img' >";
        $out .="<input type='button'   class='".$class."' style='border:1px solid;'/>";
        $opts['properties']['class']="tfuse_captcha_input";
        $out.=$this->text($opts);
        return apply_filters('tfuse_form_captcha', $out, $opts);
    }

    function button($opts)
    {
        $propstr='';
        isset($opts['properties']['class'])?$opts['properties']['class']." button":'';
        if(isset($opts['properties'])){
            $propstr = $this->propstr($opts['properties']);
        }
        $out="<input ".$propstr." type='".$opts['subtype']."' id='".$opts['id']."' name='".$opts['name']."' value='".$opts['value']."'/>";
        return apply_filters('tfuse_form_button', $out, $opts);
    }

    function delete_row($opts)
    {
        $out="<div class='".$opts['class']."'></div>";
        return apply_filters('tfuse_form_delete', $out, $opts);
    }

    function selectable_code($opts)
    {
        $opts['properties']['class'] = isset($opts['properties']['class'])?$opts['properties']['class'].' tfuse_selectable_code':'tfuse_selectable_code';
        $propstr = $this->propstr($opts['properties']);
        $output ='<span class="raw_option" id="' . $opts['id'] . '"><code '.$propstr.'>'.$opts['value'].'</code></span>';
        if (has_filter("tfuse_form_selectable_code_{$opts['id']}")) {
            return apply_filters("tfuse_form_selectable_code_{$opts['id']}", $output, $opts);
        }
        return apply_filters('tfuse_form_selectable_code', $output, $opts);
    }

    function datepicker($opts)
    {
        $pluginfolder = get_bloginfo('url') . '/wp-includes/js/jquery/ui';
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-datepicker', $pluginfolder . '/jquery.ui.datepicker.min.js', array('jquery', 'jquery-ui-core') );
        if(!$this->include->type_is_registered('datepicker_framework_js')){
            $this->include->register_type('datepicker_framework_js', TFUSE . '/static/javascript');
            $this->include->js('datepicker', 'datepicker_framework_js','tf_footer',11);
            $this->include->register_type('datepicker_framework_css', TFUSE . '/static/css');
            $this->include->css('datepicker', 'datepicker_framework_css');
            $this->include->js('popbox.min', 'datepicker_framework_js','tf_footer',10);
        }
        $out = '<div class="tf_datepicker_holder">';
        $inp_class = (isset($opts['properties']['class'])) ? $opts['properties']['class'] : '';
        $inp_class .= (!isset($opts['popbox']) || count($opts['popbox']) == 0)? ' tfuse_datepicker' : ' tfuse_dates_holder';
        $opts['properties']['class'] = $inp_class;
        $out .=((isset($opts['inp_name']) && trim($opts['inp_name']) != '')? '<label class="titledesc">'.$opts['inp_name'].':</label>':''). $this->text($opts);
        if(isset($opts['popbox']) && count($opts['popbox']) > 0){
            $out .='<div class="popbox tfuse_datepicker_popbox '.((isset($opts['properties']['minDateCurrent']) && ($opts['properties']['minDateCurrent'] == null || $opts['properties']['minDateCurrent'] == false))?'':'minDateCurrent').'">
                          <a class="open" href="#"><div class="open_button"></div></a>
                             <div class="collapse">
                             <div class="box">
                             <div class="arrow"></div>
                             <div class="arrow-border"></div>
                             <div class="box_content">';
            foreach($opts['popbox'] as $key=>$pop_inp){
                if(!in_array(trim($key),array('with_datepickers','dependancy'))){
                    $class = (isset($pop_inp['properties']['class'])) ? $pop_inp['properties']['class'] : '';
                    $class .= (in_array($pop_inp['id'],$opts['popbox']['with_datepickers']))?' tfuse_datepicker':'';
                    if(isset($opts['popbox']['dependancy']) && count($opts['popbox']['dependancy']) > 0){
                        foreach($opts['popbox']['dependancy'] as $Dkey => $value)
                            if(trim($value) == trim($pop_inp['id']))
                                $class .= ' '.$Dkey;
                    }
                    $pop_inp['properties']['class'] = $class;
                    $out .= '<label for="'.$pop_inp['id'].'">'.$pop_inp['name'].':</label>'.$this->$pop_inp['type']($pop_inp);
                }

            }
            $out .= '</div>
    <a href="#" class="close">close</a>
    <a href="#" class="excludedate_ok">Ok</a>
    </div>
    </div>
    </div>';
        }
        $out .='</div>';
        if (has_filter("tfuse_datepicker_{$opts['id']}")) {
            return apply_filters("tfuse_datepicker_{$opts['id']}", $out, $opts);
        }
        return apply_filters('tfuse_datepicker', $out, $opts);
    }

    /*   function selectsearch($opts)
       {
           wp_enqueue_script('jquery');
           if(!$this->include->type_is_registered('chosen_js')){
               $this->include->register_type('chosen_js', TFUSE . '/static/javascript');
               $this->include->js('chosen.jquery.min', 'chosen_js', 'tf_head', 10, '0.9.8');
               $this->include->js('chosen_tfuse', 'chosen_js');
               $this->include->register_type('chosen_css', TFUSE . '/static/css');
               $this->include->css('chosen', 'chosen_css', 'tf_head', '0.9.8');
           }

           $class = ''; $style = '';
           if(isset($opts['properties']) && count($opts['properties']) > 0)
           {
               if(isset($opts['properties']['class'])) {
                   if(!is_array($opts['properties']['class']))
                       $opts['properties']['class'] = array($opts['properties']['class']);
                   $class = implode(' ', $opts['properties']['class']);
               }
               if(isset($opts['properties']['style']) and is_array($opts['properties']['style']) and count($opts['properties']['style']) > 0)
               {
                   $styles = array();
                   foreach($opts['properties']['style'] as $q=>$v)
                       $styles[] = $q.': '.$v;
                   $style = 'style="'.implode('; ', $styles).'"';
               }
           }

           if(isset($opts['multiple']) and  $opts['multiple'] === true)
               $multiple = true;
           else $multiple = false;

           if(empty($opts['def_text']))
               $def_text = $opts['name'];
           else $def_text = $opts['def_text'];

           $out = '<select data-placeholder="'.$def_text.'" name="'.$opts['id'].(($multiple === true)?'[]':'').'" id="'.$opts['id'].'" '.(($multiple === true)?'multiple':'').' class="tfuse_option tfuse-select'.((isset($opts['deselect']) && $opts['deselect'] === true)?'-deselect':'').' '.((isset($class))?$class:'').' '.((isset($opts['right']) and $opts['right'] == true)?'chzn-rtl':'').'" '.((isset($style))?$style:'').' '.((isset($opts['properties']['other']))?$opts['properties']['other']:'').'>'."\n";
           $out .= '<option value=""></option>'."\n";

           $value = array();
           if(isset($opts['value']) and !is_array($opts['value']))
               $value[] = $opts['value'];
           elseif(isset($opts['value'])) $value = $opts['value'];

           if(isset($opts['options']) and count($opts['options']) > 0)
               if(isset($opts['groups']) and $opts['groups'] === true)
               {
                   foreach($opts['options'] as $q=>$v)
                   {
                       $out .= '<optgroup label="'.$q.'">'."\n";
                       if(count($v) > 0)
                           foreach($v as $qq=>$vv)
                               $out .= '<option value="'.$qq.'" '.(count($value) > 0 && in_array($qq, $value)?'selected':'').'>'.$vv.'</option>'."\n";
                       $out .= '</optgroup>'."\n";
                   }
               } else {
                   foreach($opts['options'] as $q=>$v)
                       $out .= '<option value="'.$q.'" '.(count($value) > 0 && in_array($q, $value)?'selected':'').'>'.$v.'</option>'."\n";
               }

           $out .= '</select>'."\n";

           if (has_filter("tfuse_selectsearch_{$opts['id']}"))
               return apply_filters("tfuse_selectsearch_{$opts['id']}", $out, $opts);

           return apply_filters('tfuse_selectsearch', $out, $opts);
       } */

    function selectsearch($opts)
    {
        //FULL ARRAY WITH OPTIONS
        /*array(
            'name'          =>'the label for selectsearch',
            'desc'          => 'description of selectsearch',
            'id'            => 'unique id if is not set post_name index this value goes to name ',
            'options'       => array("ro"=>"Romanian","ru"=>"Russian"), //'array of options
            'groups'        => true, //show optgroups from entire array
            'type'          => 'selectsearch', // Type of optigen selectsearch
            'allow_single_deselect' => true, // true or false value,show close btn when select one item ,only for single search
            'value'         => array('RO','RU')|'RO', //array of indexes or simple name for multi or single selectseach
            'multiple'      =>'true', //true or false ,what type of selectseach will be multiple or single
            'properties'    => array('class'=>array('firstclass', 'secondclass'),'style'=>array('width' => '170px')),
            'show_groups'   => true //true or false value ,show groups control or not ,only for multiple selectseach
            'toggle_btn'    => true, //true or false ,enable toggle btn
            'toggle_btn_text' => array('show','hide'),//default toggle text at the button
            'toggle_container_text' => array('single'=>'Selected %%number%%  country',
                                            'multiple'=>'Selected %%number%% countries'),//toggle container text
            'enable_add' => 'saveShippingClass',//calback javascript function to add btn bind event
        );*/
        wp_enqueue_script('jquery');
        if (!$this->include->type_is_registered('chosen_js')) {
            $this->include->register_type('chosen_js', TFUSE . '/static/javascript');
            $this->include->js('chosen.jquery.min', 'chosen_js', 'tf_head', 10, '0.9.8');
            $this->include->js('chosen_tfuse', 'chosen_js', 'tf_head', 10, '1.2');
            $this->include->register_type('chosen_css', TFUSE . '/static/css');
            $this->include->css('chosen', 'chosen_css', 'tf_head', '0.2');
            $this->include->css('chosen_ext', 'chosen_css', 'tf_head', '1.0', '', array());
        }
        $class = '';
        $style = '';
        $groups = array();
        if (isset($opts['properties']) && count($opts['properties']) > 0) {
            if (isset($opts['properties']['class'])) {
                if (!is_array($opts['properties']['class']))
                    $opts['properties']['class'] = array($opts['properties']['class']);
                $class = implode(' ', $opts['properties']['class']);
            }
            if (isset($opts['properties']['style']) and is_array($opts['properties']['style']) and count($opts['properties']['style']) > 0) {
                $styles = array();
                foreach ($opts['properties']['style'] as $q => $v)
                    $styles[] = $q . ': ' . $v;
                $style = 'style="' . implode('; ', $styles) . '"';
            }
        }
        $ignored_items = empty($opts['ignored_items'])?'':'data-ignored-items="'.$opts['ignored_items'].'"';
        $callback = empty($opts['enable_add']) ? '' : 'data-callback="' . $opts['enable_add'] . '"';
        $callback_delete_btn = empty($opts['enable_delete']) ? '' : 'data-callback-delete-btn="' . $opts['enable_delete'] . '"';
        $default_toggle_text = array('single' => __('Selected %%number%%  item', 'tfuse'), 'multiple' => __('Selected %%number%% items', 'tfuse'));
        $toggle_btn = empty($opts['toggle_btn']) ? '' : 'data-toggle-btn="' . $opts['toggle_btn'] . '"';
        $multiple = empty($opts['multiple']) ? false : true;
        $allow_single_deselect = $multiple ? 'false' : (empty($opts['allow_single_deselect']) ? 'false' : 'true');
        $input_value = empty($opts['value']) ? '' : $opts['value'];
        $name = $opts['id'];
        $def_text = empty($opts['def_text']) ? $opts['name'] : $opts['def_text'];
        $show_groups = empty($opts['show_groups']) ? false : true;
        $out = '<input type="hidden"  name="' . $name . '" id="' . esc_attr($name) . '" value="' . $input_value . '" />';
        $out .= '<select single-deselect="' . $allow_single_deselect . '" data-placeholder="' . $def_text . '" ' . ($multiple ? 'multiple' : '') . ' class="tfuse_option tfuse-select' . ((isset($opts['deselect']) && $opts['deselect'] === true) ? '-deselect' : '') . ' ' . ((isset($class)) ? $class : '') . ' ' . ((isset($opts['right']) and $opts['right'] == true) ? 'chzn-rtl' : '') . '" ' . ((isset($style)) ? $style : '') . ' ' . ((isset($opts['properties']['other'])) ? $opts['properties']['other'] : '') . ' ' . $callback . '  ' .$ignored_items. '  ' . $toggle_btn . '  ' . $callback_delete_btn . '>' . "\n";
        $out .= '<option value=""></option>' . "\n";

        $value = array();

        if (isset($opts['value'])) {
            $value = explode(',', $opts['value']);
        }

        if (isset($opts['options']) and count($opts['options']) > 0)
            if (isset($opts['groups']) and $opts['groups'] === true) {
                foreach ($opts['options'] as $q => $v) {
                    if (!is_array($v)) {
                        $out .= '<option value="' . $q . '" ' . (count($value) > 0 && in_array($q, $value) ? 'selected' : '') . '>' . $v . '</option>' . "\n";
                    } else {
                        $temp = strtolower(str_replace(" ", "_", $v['title']));
                        $groups[] = $temp;

                        $out .= '<optgroup data-placeholder="' . $temp . '" label="' . $v['title'] . '">' . "\n";

                        if (count($v) > 0)
                            foreach ($v['value'] as $qq => $vv)
                                $out .= '<option value="' . $qq . '" ' . (count($value) > 0 && in_array($qq, $value) ? 'selected' : '') . '>' . $vv . '</option>' . "\n";
                        $out .= '</optgroup>' . "\n";
                    }
                }
            } else {
                if (is_array($opts['options']))
                    foreach ($opts['options'] as $q => $v)
                        $out .= '<option value="' . $q . '" ' . (count($value) > 0 && in_array($q, $value) ? 'selected' : '') . '>' . $v . '</option>' . "\n";
            }

        $out .= '</select>' . "\n";

        //Show links for optgroup and load js for this

        if ($show_groups and $multiple) {
            $str = '';
            if (!empty($opts['toggle_btn'])) {
                $str .= "<div class='tf_selectsearch_control_show_hide' style=' width:275px; display:block;'><span class ='tf-toggle-text-container' ><span class='tf-selectseach-toggle-txt-single '>" .
                    implode('</span><span class="tf-selectseach-toggle-txt-multiple" >',
                        (empty($opts['toggle_container_text']) ? $default_toggle_text : $opts['toggle_container_text'])) .
                    "</span></span><a href='#' class='tf_selectsearch_toggle_a add button'><span class='toggle_btn_on'>" .
                    implode('</span><span class="toggle_btn_off">',
                        array_slice((empty($opts['toggle_btn_text']) ? array(__('show', 'tfuse'), __('hide', 'tfuse')) : $opts['toggle_btn_text']), 0, 2)) .
                    "</span></a></div>";
            }
            $str .= '<div class="tf_multicontrol_selectsearch">' . "\n";
            $str .= '<div class="tf_groups_controls">' . "\n";
            $str .= '<a href="" class="tf_selectsearch_control_all">All</a>' . "\n";

            foreach ($groups as $group)
                $str .= '<a href="" class="tf-groups-links" data-placeholder="' . $group . '">' . ucwords(str_replace('_', ' ', $group)) . '</a>' . "\n";

            $str .= '<a href="" class="tf_selectsearch_control_none">None</a>' . "\n";
            $str .= '</div>' . "\n";
            $str .= '<div class="tf_search_dpdw">' . "\n";
            $str .= $out;
            $str .= '</div>' . "\n";
            $str .= '<div class="clear"></div></div>' . "\n";

        }

        if (has_filter("tfuse_selectsearch_{$opts['id']}"))
            return apply_filters("tfuse_selectsearch_{$opts['id']}", isset($str) ? $str : $out, $opts);

        return apply_filters('tfuse_selectsearch', isset($str) ? $str : $out, $opts);
    }

    /**
     * Google Maps input
     */
    function maps($opts)
    {
        wp_enqueue_script('jquery');

        $uniqId = 'tfgmaps-'.md5(mt_rand(1, 1000).'-'.mt_rand(1, 1000).'-'.time());
        $tmp    = (array)explode(':', $opts['value']);

        $x      = ( is_numeric( ($x = (string)(@$tmp[0])) ) ? $x : '');
        $y      = ( is_numeric( ($y = (string)( !empty($tmp[1]) ? @$tmp[1] : '')) ) ? $y : '');

        if(trim($x) && trim($y)){
            $value = $x.':'.$y;
        } else {
            $value = $x = $y = '';
        }

        $output = '';
        $output .= '<input id="'.esc_attr($opts['id']).'" name="'.esc_attr($opts['id']).'" type="hidden" value="' . esc_attr($value) . '" class="tf-optigen-input-maps '.$uniqId.'" />';
        $output .= '<div><input id="'.esc_attr($opts['id']).'_x" type="text" value="' . esc_attr($x) . '" /></div>';
        $output .= '<div><input id="'.esc_attr($opts['id']).'_y" type="text" value="' . esc_attr($y) . '" /></div>';
        $output .=        '<div id="'.esc_attr($opts['id']).'_map" class="tf-optigen-input-maps-div' . (@$opts['desc'] ? '' : ' tf-optigen-input-maps-div-big') . '" ></div>';

        $output .= '<script type="text/javascript" id="optigen-maps-'.$opts['id'].'">';
        $output .= 'jQuery(document).ready(function($){';
        $output .= 'tf_init_google_maps_input("input.'.$uniqId.'");';
        $output.= 'jQuery("script#optigen-maps-'.$opts['id'].'").remove();';
        $output .= '});';
        $output .= '</script>';

        return $output;
    }

    function multiple_input($opts)
    {
        if (!$this->include->type_is_registered('multiple_input_css')) {
            $this->include->register_type('multiple_input_css', TFUSE . '/static/css');
            $this->include->css('multi_input', 'multiple_input_css', 'tf_head', '0.9.8');
            $this->include->register_type('multi_input_js', TFUSE . '/static/javascript');
            $this->include->js('multi_input', 'multi_input_js', 'tf_head', 10, '0.9.8');
        }

        /*$opts=array(
            'name'=>'Default name',                                     //label for this optigen element
            'desc'=>'Description',                                      //Descriptiom
            'post_name'=>'minput[]',                                    //value that goes to name of input or textarea
            'class'=>array('tf_minput'),                                //array of clases for wrap div of optigen element
            'value'=>array('first value','second value','third value'), //values to inputs
            'id'=>'wrap_input',                                         //id for div that wrap this optigen element
            'input_classes'=>array('input_class'),                      //clases for each row that wrap inputs
            'type'=>'multiple_input',                                   //type of optigen
            'subtype'=>'textarea'                                       // textarea | text
        );*/

        // $post_name = empty($opts['post_name'])  ? 'tfminput[]' : $opts['post_name'];
        $class  = empty($opts['class']) ? '' : implode(' ',$opts['class']);
        $value  = empty($opts['value']) ? array('') : $opts['value'];
        $id     = empty($opts['id']) ? 'tf_multi_input_name' : $opts['id'];
        $input_class = empty($opts['input_classes']) ? '': implode(" ",$opts['input_classes']);
        $subtype     = empty($opts['subtype']) ? 'text': $opts['subtype'];

        if($subtype == 'text')
            $template ='<input type="text" name="{name}" value="{value}"  class="tfuse_option"/>';
        elseif($subtype == 'textarea')
            $template = '<textarea  name="{name}" class="tfuse_option" >{value}</textarea>';

        $patterns = array('{name}', '{value}');
        $out = '<div class="'.$class.'" id="'.$id.'" >'."\n";
        $out.= '<div class="tf_opt_multiple_content">';
        foreach ($value as $key => $val) {
            $out.= '<div class="tf_opt_multiple_input_row '.$input_class.' ">'."\n";
            $out.= str_replace($patterns,array($id.'[]',$val),$template);
            $out.= ($key==0) ? '' : '<a href="" class="tf_opt_multiple_remove_btn"></a>'."\n";
            $out.= '</div>'."\n";
        }

        $out.= '</div>';
        $out.= '<div class="clear"></div>';
        $out.= '<a href="" class="tf_opt_multiple_add_btn"></a>';
        $out.= '<div class="clear"></div>';
        $out.= '</div>';

        return $out;

    }

    /**
     * Table with columns and optigen inputs in it. And you can add or remove rows
     */
    function table($opts)
    {
        if (!$this->include->type_is_registered('tfuse_render_table_js')) {
            $this->include->register_type('tfuse_render_table_js', TFUSE . '/static/javascript');
            $this->include->register_type('tfuse_render_table_css', TFUSE . '/static/css');
            $this->include->css('tip-twitter','tfuse_render_table_css');
            $this->include->js('jquery.poshytip','tfuse_render_table_js');
            $this->include->js('tfuse_render_table', 'tfuse_render_table_js', 'tf_head', 10, '0.2');
        }

        $str = '<table class="tfuse-optigen-table '. (isset($opts['class']) ? $opts['class'] : '') .'" id="'.$opts['id'].'" style="'. (isset($opts['style']) ? $opts['style'] : '') .'">';

        $str.= '<thead>';
        foreach ($opts['columns'] as $th)
            $str.= '<th class="'.$th['id'].'">'. (isset($th['name']) ? $th['name'] : '') .(empty($th['desc'])? ' ' :' <a href="#" class="tfuse-tip-twitter" title="'.addslashes(isset($th['desc']) ? $th['desc'] : '').'" style="cursor:help">[?]</a>'). '</th>';
        $str.= '</thead>';

        /**
         * Rows with already saved data
         */
        {
            $str.= '<tbody class="tfbtq_first_body">';
            foreach ($opts['value'] as $value) {
                $str.= '<tr>';
                foreach ($opts['columns'] as $td) {
                    $str.= '<td style="overflow:visible" data-id="'.$td['id'].'" data-type="'.$td['type'].'">';
                    if (method_exists($this->optigen, $td['type'])) {
                        $str.= $this->optigen->{$td['type']}(array_merge($td, array('value' => $value[$td['id']])));
                    } else {
                        trigger_error('Method '.$td['type'].' does no exists in OPTIGEN', E_USER_ERROR);
                    }

                    $str.= '</td>';
                }
                $str.= '</tr>';
            }
            $str.= '</tbody>';
        }

        /**
         * Default add row (when click on "Add row")
         */
        {
            $str.= '<tbody class="tfbtq_last_body">';
            $str.= '<tr style="display:none" class="tfbtq-default-value-row">';
            foreach ($opts['columns'] as $key => $td) {
                $str.= '<td style="overflow:visible" data-id="'.$td['id'].'" data-type="'.$td['type'].'">';
                if (method_exists($this->optigen, $td['type'])) {
                    $str.= $this->optigen->{$td['type']}(array_merge($td, array(
                        'value' => isset($opts['default_add_value']) && isset($opts['default_add_value'][$td['id']]) ? $opts['default_add_value'][$td['id']] : ''
                    )));
                } else {
                    trigger_error('Method '.$td['type'].' does not exists in OPTIGEN', E_USER_ERROR);
                }
                $str.= '</td>';
            }
            $str.= '</tr>';
            $str.= '</tbody>';
        }

        $str.= '<tfoot>';
        foreach ($opts['columns'] as $th)
            $str.= '<th >'. (isset($th['name']) ? $th['name'] : '') .'</th>';
        $str.= '</tfoot>';

        $str.= '</table>';

        $str.= '<input type="hidden" name="'.$opts['id'].'"/>';

        $str.= '<script type="text/javascript" id="optigen-table-'.$opts['id'].'">';
        $str.= 'jQuery(document).ready(function(){';
        $str.= 'jQuery("#'.$opts['id'].'").tfuseMakeTable(); });';
        // remove scripts from html inside headings
        //// because they are cloned when dragged/moved and all scripts inside them will run again
        $str.= 'jQuery("script#optigen-table-'.$opts['id'].'").remove();';
        $str.= '</script>';

        return $str;
    }

    /**
     * Like 'table' input, but rows as divs
     */
    function div_table($opts)
    {
        if (!$this->include->type_is_registered('tfuse_div_table_js')) {
            $this->include->register_type('tfuse_div_table_js', TFUSE . '/static/javascript');
            $this->include->js('tfuse_div_table', 'tfuse_div_table_js', 'tf_head', 10, '0.9.8');
        }

        $str = '<div class="tfuse-optigen-div-table '. (isset($opts['class']) ? $opts['class'] : '') .'" id="'.$opts['id'].'" style="'. (isset($opts['style']) ? $opts['style'] : '') .'" >'."\n";
        $str.= '<div class="div-table-first-body">';

        foreach ($opts['value'] as $value) {
            $str.= '<div class="div-table-tr">';
            $str.= '<div class="div-table-td div-table-delete-checkbox-row"><input type="checkbox"/></div>'."\n";

            foreach ($opts['columns'] as $key => $td) {
                $str.= '<div class="div-table-td"  data-id="'.$td['id'].'" data-type="'.$td['type'].'">';
                $str.= $this->interface->meta_box_row_template(array_merge($td, array('value' => $value[$td['id']])));
                $str.= '<div style="clear:both"></div></div>'."\n";
            }

            $str.= '<div style="clear:both"></div></div>'."\n";
        }

        $str.= '<div style="clear:both"></div></div>'."\n";
        $str.= '<div class="div-table-last-body">';

        if(!empty($opts['default_value'])){
            $str.= '<div class="div-table-tr tfbtq-default-value-row" style="display:none">';
            $str.= '<div class="div-table-td div-table-delete-checkbox-row"><input type="checkbox"/></div>'."\n";
            foreach ($opts['columns'] as $key => $td) {
                $str.= '<div class="div-table-td" data-id="'.$td['id'].'" data-type="'.$td['type'].'">';
                $str.= $this->interface->meta_box_row_template(array_merge($td, array('value' => $opts['default_value'][$td['id']])));
                $str.= '<div style="clear:both"></div></div>'."\n";
            }
            $str.= '<div style="clear:both"></div></div>'."\n";
        }

        $str.= '<a class="add button tfbtq_shopping_add_row" href="#">'
            .(empty($opts['btn_labels'][0]) ? 'Add Row' : $opts['btn_labels'][0])
            .'</a><a class="add button tfbtq_shopping_delete_rows" href="#">'
            .(empty($opts['btn_labels'][1]) ? 'Delete Row' : $opts['btn_labels'][1])
            .'</a>';
        $str.= '<div style="clear:both"></div></div>'."\n";
        $str.= '<input type="hidden" name="'.$opts['id'].'"/>';
        $str.= '<div style="clear:both"></div></div>'."\n";
        $str.= '<script type="text/javascript" id="optigen-div_table-'.$opts['id'].'">';
        $str.= 'jQuery(document).ready(function(){';
        $str.= 'jQuery("#'.$opts['id'].'").tfuseMakeDivTable();';
        // remove scripts from html inside headings
        //// because they are cloned when dragged/moved and all scripts inside them will run again
        $str.= 'jQuery("script#optigen-div_table-'.$opts['id'].'").remove();';
        $str.= '});';
        $str.= '</script>';

        return $str;
    }
}
