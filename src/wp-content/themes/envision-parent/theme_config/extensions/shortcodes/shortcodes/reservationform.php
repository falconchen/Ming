<?php
function tf_reservationform_shortcode($atts){
    global $TFUSE;
    global $select;
    $pluginfolder = get_bloginfo('url') . '/wp-includes/js/jquery/ui';
    wp_enqueue_script('jquery');
    wp_enqueue_script('jquery-ui-core');
    wp_enqueue_script('jquery-ui-datepicker', $pluginfolder . '/jquery.ui.datepicker.min.js', array('jquery', 'jquery-ui-core') );
    wp_register_script( 'reservation_forms_js', get_template_directory_uri().'/js/reservation_frontend.js', array('jquery'), '1.1.0', true );
    wp_enqueue_script( 'reservation_forms_js' );
    wp_enqueue_script('jquery-form');
    wp_register_style( 'jquery_css',TFUSE_ADMIN_CSS.'/jquery-ui-1.8.14.custom.css');
    wp_enqueue_style( 'jquery_css' );
    wp_register_style( 'reservation_forms_css', get_template_directory_uri().'/theme_config/extensions/reservationform/static/css/reservation_form.css', true, '1.1.0' );
    wp_enqueue_style( 'reservation_forms_css' );
    extract(shortcode_atts(array('tf_rf_formid' => '-1'), $atts));
    $out='';
    $form_exists=false;
	$is_preview=false;
    if($tf_rf_formid!='-1'){
        $is_preview=false;
        $form_exists = true;
        $form = get_term_by('id',$tf_rf_formid,'reservations');
        $form = unserialize($form->description);

    } elseif($TFUSE->request->isset_COOKIE('res_form_array')){
        $is_preview=true;
        $form_exists=true;
        $form = unserialize($TFUSE->request->COOKIE('res_form_array'));
        unset($_COOKIE['form_array']);
    }
    if($form_exists){

        $out .='<div class="contact-form"><div id="form_messages" class="submit_message" ></div>';
        $inputs = $TFUSE->get->ext_config('RESERVATIONFORM', 'base');
        $input_array = $inputs['input_types'];
        $out.='<h2 id="header_message">'.__(urldecode($form['header_message']),'tfuse').'</h2><a name="contact"></a><form id="reservationForm" action="" method="post" class="reservationForm" name="reservationForm">';
        $out.='<input id="this_form_id" type="hidden" value="'. $tf_rf_formid.'" />';
        $fields='';

        $fcount = 1;
        $linewidth = 0;
        $earr=array();
        $linenr = 1;
        $lines=array();
        $countForm = count($form['input']);
        $dimension=38;
        $lines[$linenr] = 0;
        foreach($form['input'] as $form_input_arr){

            $earr[$fcount]['width'] = $form_input_arr['width'];

            $linewidth += $form_input_arr['width'];
            if (isset($form_input_arr['newline'])) {
                $linewidth = $form_input_arr['width'];
                $earr[$fcount]['class'] = ' ';
                if ($fcount>1) {$linenr++;
                    $lines[$linenr] = 0;}
                $earr[$fcount]['line'] = $linenr;
                $lines[$linenr] += $dimension;
            }
            elseif ($linewidth>100) {
                $linewidth = $form_input_arr['width'];
                $linenr++;
                $lines[$linenr]=0;
                $earr[($fcount-1)]['class'] = ' omega ';
                $earr[$fcount]['class'] = ' ';
                $earr[$fcount]['line'] = $linenr;

                $lines[$linenr] += $dimension;
            }
            elseif($linewidth==100) {
                $linewidth = 0;
                $earr[$fcount]['class'] = ' omega ';
                $earr[$fcount]['line'] = $linenr;
                $lines[$linenr] += $dimension;
                $linenr++;
                $lines[$linenr]=0;
            }
            else {
                $earr[$fcount]['class'] = ' ';
                $earr[$fcount]['line'] = $linenr;
                $lines[$linenr] += $dimension;
            }

            if ($countForm==$fcount && !isset($form_input_arr['newline'])) {
                $earr[$fcount]['class'] = ' omega ';
            }
            $fcount++;
        }


        $text_type=array();
        $email_type = array();
        foreach($input_array as $input){
            if($input['name'] == 'Text line'){
                $text_type = $input;
            }
            if($input['name'] == 'Email'){
                $email_type = $input;
            }
            if(!empty($text_type) && !empty($email_type)) break;
        }
        $input_array[] = $text_type;
        $input_array[] = $text_type;
        $input_array[] = $email_type;

        $linewidth = 0;
        $fcount = 1;
        $margin=20;
        foreach($form['input'] as $form_input){
            $field='';
            $input = array();
            if(isset($input_array[$form_input['type']]))
            $input=$input_array[$form_input['type']];
            if(isset($input['properties'])){
                $proprstr='';
                foreach($input['properties'] as $key=>$value){
                    $proprstr .=$key."=".$value." ";
                }
            }
            $floating=(isset($form_input['newline']) )?'clear:left;':' ';
            if (!isset($input['properties']['class']))
                $input['properties']['class'] = '';
            $input['properties']['class'] .=(isset($input['name']) && $input['name']=='Email')?' '.TF_THEME_PREFIX.'_email':'';
            $input['properties']['class'] .=(isset($form_input['required']))?' tf_rf_required_input ':'';
            $label_text =(isset($form_input['required']))?trim(urldecode($form_input['label'])).' '.urldecode($form['required_text']):trim(urldecode($form_input['label']));
            $input['id']=(isset($input['id']))?str_replace('%%name%%',urldecode($form_input['shortcode']),$input['id']):TF_THEME_PREFIX.'_'.urldecode($form_input['shortcode']);

            $form_input['classes'] = $earr[$fcount]['class'];
            $form_input['floating'] = $floating;
            $form_input['label_text'] = $label_text;
            $label='<label for="' .TF_THEME_PREFIX."_".trim(urldecode($form_input['shortcode'])). '">'.urldecode($label_text).'</label><br/>';


            if($is_preview)
                $sidebar_position = 'full';
            else
                $sidebar_position = tfuse_sidebar_position();

            $element_line = $earr[$fcount]['line'];

            if ($sidebar_position == 'full')
            {
                if($is_preview){
                    $ewidth=640-$lines[$element_line]+$margin;}
                else
                    $ewidth=924-$lines[$element_line]+$margin;
            }
            else {
                $ewidth=598-$lines[$element_line]+$margin;
            }

            if (isset($form_input['newline']) && $form_input['newline'] == 1){
                $linewidth = $form_input['width'];
            }
            else $linewidth += $form_input['width'];


            if ($form_input['width']==100)
            {
                $form_input['ewidthpx'] = $ewidth;
                $linewidth = 0;
            }
            elseif ($linewidth>100 )
            {
                $form_input['ewidthpx'] = (int)($ewidth*$form_input['width']/100);
                $linewidth = 0;
            }
            else
            {
                $form_input['ewidthpx'] = (int)($ewidth*$form_input['width']/100);
            }

            if($lines[$element_line]==$dimension && $form_input['width']>=40 && $form_input['width']<=90){
                $form_input['ewidthpx'] = (int)(($ewidth-$dimension)*$form_input['width']/100);
            }
            elseif($lines[$element_line]==$dimension && $form_input['width']<40 && $form_input['width']>32){
                $form_input['ewidthpx'] = (int)(($ewidth-2*$dimension)*$form_input['width']/100);
            }
            elseif($lines[$element_line]==$dimension && $form_input['width']<33){
                $form_input['ewidthpx'] = (int)(($ewidth-3*$dimension)*$form_input['width']/100);
            }

            if(file_exists(TFUSE_CHILD_DIR.'/theme_config/theme_includes/THEME_FUNCTIONS.php'))
                $file = TFUSE_CHILD_DIR.'/theme_config/theme_includes/THEME_FUNCTIONS.php';
            else $file = TFUSE_THEME_DIR.'/theme_config/theme_includes/THEME_FUNCTIONS.php';
            if(!function_exists('tfuse_browser_body_class')){
                require($file);
            }
            $browser=tfuse_browser_body_class();
            if ( $browser[0]=='safari' ){
                $select=40;
            }
            else  $select=18;

            if($is_preview && $input['type'] == 'select' && $browser[0]!='safari') $form_input['ewidthpx'] -=16;
            elseif($is_preview && $input['type'] == 'select' && $browser[0]=='safari') $form_input['ewidthpx'] -=14;

            if ($is_preview && $input['type'] == 'text' && ($form_input['type']=='7' || $form_input['type']=='8') ) $form_input['ewidthpx'] +=22;


            $fcount++;
            if(in_array($form_input['type'],array(7,8)))
                $input['type'] = 'res_datepicker';
            elseif($form_input['type'] == 9)
                $input['type'] = 'res_text';
            else $input['type'] = 'res_'.$input['type'];
            $input_field=$input['type']($input,$form_input);
            if($input['type']=='checkbox'){
                $tmp=$label;
                $label=$input_field;
                $input_field=$tmp;
            }
			if (trim($earr[$fcount-1]['class'])=='omega' ) $input_field .= '<div class="clear"></div>';

            $fields .=$input_field;

        }
        $out .= $fields;
        $surse=get_template_directory_uri().'/images/ajax-loader.gif';
        $out.='<div class="clear"></div><div class="field_submit" style="clear:left;width:100%">';
        $out.='<span class="reset-link"><a onclick="resetFields(this,event)" href="#">'.__(urldecode($form['reset_button']),'tfuse').'</a></span>';
        $out.='<a href="#" id="sending" class="btn-submit2"><span>'.__('Sending ...','tfuse').'</span></a>
		<input type="submit" id="send_reservation" class="btn-submit" name="submit" title="Submit message" value="'.__(urldecode($form['submit_mess']),'tfuse').'" />
		<img id="sending_img" src="'.$surse.'" alt="Sending" style="margin-left:-55px; margin-bottom:-8px; display: none;" />
        </div></form></div>';
    } else {
        $out="<p>This Form is not defined!!</p>";
    }
        return $out;
}
$forms_name=array(-1=>'Choose Form');
$forms_term = get_terms('reservations', array('hide_empty' => 0));
$forms=array();
foreach ($forms_term as $key => $form) {
    $forms[$form->term_id] = unserialize($form->description);
}
if(!empty($forms)){
    foreach($forms as $key=>$value){
        $forms_name[$key]=urldecode($value['form_name']);
    }
}
$atts = array(
    'name' => 'Reservation Form',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 9,
    'options' => array(
        array(
            'name' => 'Type',
            'desc' => 'Select the form',
            'id' => 'tf_rf_formid',
            'value' => '',
            'options' => $forms_name,
            'type' => 'select'
        )
    )
);

tf_add_shortcode('tfuse_reservationform', 'tf_reservationform_shortcode', $atts);
function res_text($input,$form_input){
    return "<div class='row field_text alignleft ".$form_input['classes']."' style='".$form_input['floating']."'>
                <label for='" .TF_THEME_PREFIX.'_'.trim($form_input['shortcode']). "'>".__($form_input['label_text'],'tfuse')."</label><br>
                <input type='text' style='width:".$form_input['ewidthpx']."px;' class='".$input['properties']['class']."' name='".TF_THEME_PREFIX.'_'. trim($form_input['shortcode'])."'/>
            </div>";
}
function res_textarea($input,$form_input){
    return "<div class='row field_textarea alignleft ".$form_input['classes']."' style='".$form_input['floating']."'>
                <label for='" .TF_THEME_PREFIX.'_'.trim($form_input['shortcode']). "'>".__($form_input['label_text'],'tfuse')."</label><br>
                <textarea  style='width:".$form_input['ewidthpx']."px;' class='".$input['properties']['class']."' name='".TF_THEME_PREFIX.'_'.trim($form_input['shortcode'])."' rows='10' ></textarea>
            </div>";
}

function res_radio($input,$form_input){

    $checked='checked="checked"';
    $output="<div class='row field_text alignleft' style='width:".$form_input['width']."%;".$form_input['floating']."'>
                <label for='" .TF_THEME_PREFIX.'_'.trim($form_input['shortcode']). "'>".__($form_input['label_text'],'tfuse')."</label>";

    if(is_array($form_input['options'])){
        foreach ($form_input['options'] as $key => $option) {
            $output .= '<div class="multicheckbox"><input '.$checked.' id="' .TF_THEME_PREFIX.'_'. trim($form_input['shortcode']). '_'.$key.'"  type="radio" name="' .TF_THEME_PREFIX.'_'. trim($form_input['shortcode']). '"  value="' .__(urldecode($option),'tfuse'). '" /><label class="radiolabel" for="' .TF_THEME_PREFIX.'_'. trim($form_input['shortcode']). '_'.$key.'">' .__(urldecode($option),'tfuse'). '</label></div>';
            $checked='';
        }
    }

    $output .= "</div>";
    return $output;
}
function res_datepicker($input,$form_input){
    $datepickers_classes = array(7 => ' tfuse_rf_post_datepicker_in', 8 => ' tfuse_rf_post_datepicker_out');
    $input['properties']['class'] .= $datepickers_classes[$form_input['type']];
    $input['properties']['class'] .=  ' tf_rf_required_input ';
    $output="<div class='row field_text alignleft ".$form_input['classes']."' style='".$form_input['floating']."'>
                 <label for='" .TF_THEME_PREFIX.'_'.trim($form_input['shortcode']). "'>".__($form_input['label_text'],'tfuse')."</label><br>
                <input style='width:".($form_input['ewidthpx']-22)."px;' type='text' class='".$input['properties']['class']."' name='".TF_THEME_PREFIX.'_'. trim($form_input['shortcode'])."'/></div>";
    return $output;
}
function res_checkbox($input,$form_input){
    $checked = ($input['value'] == 'true') ? 'checked="checked"' : '';
    $output = "<div class='row field_text checkbox alignleft' style='width:".$form_input['width']."%;".$form_input['floating']."'>
                <input class='".$input['properties']['class']."' style='width:15px;' type='checkbox' name='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "' id='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "' value='".$form_input['label']."'" . $checked . "/>
                <label for='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "'>".__($form_input['label_text'],'tfuse')."</label>
            </div>";
    return $output;
}


function res_captcha($input,$form_input){
    $input['properties']['class']="tfuse_captcha_input";
    $out="<div class='row field_text alignleft' style='width:".$form_input['width']."%;".$form_input['floating']."'>
            <label for='" .TF_THEME_PREFIX.'_'.trim($form_input['shortcode']). "'>".__($form_input['label_text'],'tfuse')."</label><br>
            <img  src='".TFUSE_EXT_URI."/contactform/library/".$input['file_name']."?form_id=".TF_THEME_PREFIX.'_'.trim($form_input['shortcode'])."&ver=".rand(0, 15)."' class='tfuse_captcha_img' >
            <input type='button' class='tfuse_captcha_reload' />
            <input style='width:".$form_input['ewidthpx']."px;' id='".trim($input['id'])."' type='text' class='".$input['properties']['class']."' name='".TF_THEME_PREFIX.'_'.trim($form_input['shortcode'])."' />
         </div>";
    return $out;
}

function res_select($input,$form_input){
    global $select;
    $input['properties']['class'].=' tfuse_option';
    $out = "<div class='row field_text alignleft ".$form_input['classes']."'  >
                <label for='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "'>".__($form_input['label_text'],'tfuse')."</label><br>
                <select style='width:".($form_input['ewidthpx']+$select)."px !important;' class='".$input['properties']['class']."' name='" .TF_THEME_PREFIX."_".trim($form_input['shortcode']). "' id='" .trim($input['id']). "'>";
    if(is_array($form_input['options'])){
        foreach ($form_input['options'] as $key => $option) {
            $out .= "<option value='" . urldecode($option) . "'>";
            $out .= __(urldecode($option),'tfuse');
            $out .= "</option>\r\n";
        }
    }
    $out .= '</select></div>';
    return $out;

}