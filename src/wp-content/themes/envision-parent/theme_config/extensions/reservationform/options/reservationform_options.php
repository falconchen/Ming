<?php
$cfg['input_types'] = array(
    array(
        'name' => 'Text Input',
        'type' => 'text',
        'value' => '',
        'id' => TF_THEME_PREFIX . '_%%name%%',
        'options' => false
    ),
    array(
        'name' => 'Text area',
        'type' => 'textarea',
        'value' => '',
        'id' => TF_THEME_PREFIX . '_%%name%%',
        'options' => false
    ),

    array(
        'name' => 'Radiobox',
        'type' => 'radio',
        'value' => '',
        'id' => TF_THEME_PREFIX . "_%%name%%",
        'options' => true
    ),
    array(
        'name' => 'Checkbox',
        'type' => 'checkbox',
        'value' => '',
        'id' => TF_THEME_PREFIX . "_%%name%%",
        'options' => false
    ),
    array(
        'name' => 'SelectBox',
        'type' => 'select',
        'value' => '',
        'id' => TF_THEME_PREFIX . "_%%name%%",
        'options' => true,
        'properties' => array(
            'class' => 'select_styled'
        )
    ),
    array(
        'name' => 'Email',
        'type' => 'text',
        'value' => '',
        'id' => TF_THEME_PREFIX . "_%%name%%",
        'options' => false
    ),
    array(
        'name' => 'Captcha',
        'type' => 'captcha',
        'value' => '',
        'id' => TF_THEME_PREFIX . "_captcha",
        'options' => false,
        'file_name' => 'captcha_gen.php'
    )
);
$options_name = array();
foreach ($cfg['input_types'] as $value) {
    $options_name[] = $value['name'];
}
$form_name =
$options = array(
    'tabs' => array(
        array(
            'name' => 'Add/Edit Forms',
            'id' => 'add_edit_forms', #do no t change this ID
            'headings' => array(
                array(
                    'name' => 'Form Settings',
                    'id' => 'form_name',
                    'options' => array(
                        array('name' => 'Form shortcode',
                            'desc' => 'Copy this shortcode to add the form into the page/post',
                            'id' => 'tf_rf_shortcode',
                            'value'=>'[tfuse_reservationform tf_rf_formid="%%form_id%%"]',
                            'type'=>'selectable_code',

                        ),
                        array('name' => 'Form name',
                            'desc' => 'The form name will not be displayed to the users. It is for internal use only',
                            'type' => 'text',
                            'id' => 'tf_rf_formname_input',
                            'value' => ''),
                        array('name' => 'Date Pickers',
                            'desc' => 'Does your reservation form require one calendar (only check in) or two calendards (check in & check out)',
                            'id' => 'tf_rf_datepickers_count',
                            'value' => '',
                            'type' => 'select',
                            'options'=>array(
                                1 => 'Check In',
                                2 => 'Check In & Check Out'
                            )
                        ),
                        array('name' => 'User reservation title',
                            'desc' => 'It will appear in the user reservation table under User reservations. You can also copy shortcodes from the form content below in order to display them in the user reservation table',
                            'id' => 'tf_rf_res_title',
                            'value' => 'New reservation',
                            'type' => 'text'),
                    )
                ),
                array(
                    'name' => 'Form Content',
                    'id' => 'form_settings',
                    'options' => array(
                        array('name' => 'Input type',
                            'desc' => 'Input type',
                            'id' => 'tf_rf_select[]',
                            'value' => 0,
                            'type' => 'select',
                            'properties' => array(
                                'class' => TF_THEME_PREFIX.'_inp_select medica_inp_select'
                            ),
                            'options' => $options_name),
                        array('name' => 'Label',
                            'desc' => 'Input label',
                            'id' => 'tf_rf_input[]',
                            'value' => '',
                            'properties' => array(
                                'class' => 'rf_input_label'
                            ),
                            'type' => 'text'),
                        array('name' => 'Width',
                            'desc' => 'fields width',
                            'type' => 'text',
                            'id' => 'tf_rf_input_width[]',
                            'value' => '50',
                            'properties' => array(
                                'class' => 'rf_input_width'
                            ),
                            'divider' => true),
                        array('name' => 'Required',
                            'desc' => 'is this field required?',
                            'type' => 'checkbox',
                            'id' => 'tf_rf_input_required',
                            'value' => 'none',
                            'properties' => array(
                                'class' => 'rf_input_required'
                            ),
                            'divider' => true
                        ),
                        array('name' => 'New Line',
                            'desc' => 'show this field in new line',
                            'type' => 'checkbox',
                            'id' => 'tf_rf_input_newline',
                            'value' => 'none',
                            'properties' => array(
                                'class' => 'rf_input_newline'
                            ),
                            'divider' => true
                        ),
                        array('name'=>'',
                            'desc'=>'',
                            'id'=>'tf_rf_shortcode_row',
                            'type'=>'selectable_code',
                            'value'=>'%%code%%',
                            'properties'=>array(
                                'class'=> 'shortcode_code'
                            ),
                            'divider'=>true,
                        ),
                        array('name' => '',
                            'desc' => '',
                            'id' => 'tf_rf_delete_row',
                            'type' => 'raw',
                            'class' => 'tf_rf_delete_row',
                            'value' => '',
                            'html' => '<img src="' . tf_extimage($this->ext->contactform->_the_class_name, 'delete.png') . '" rel="is_default+default_is_default" class="reservationform_delete_input" style="display: none;">',
                            'divider' => true,
                        ),
                        array('name' => '',
                            'desc' => '',
                            'id' => 'tf_rf_toggle_show',
                            'type' => 'raw',
                            'class' => 'tf_rf_toggle_show',
                            'value' => '',
                            'html' => '<span class="show_more_less">+Show more</span>',
                            'divider' => true,
                        ),
                        array('name' => '',
                            'desc' => '',
                            'id' => 'tf_rf_is_datepicker[]',
                            'type' => 'text',
                            'value' => 'false',
                            'divider' => true,
                            'properties' => array(
                                'class'=> 'tfuse_is_datepicker_flag'
                            )
                        ),
                        'type'=>'custom_reservationform_row'
                    ),
                    'options_row' => array(
                        array(
                            'name' => 'Option',
                            'desc' => '',
                            'id' => 'tf_rf_input_options_label',
                            'type' => 'text',
                            'value' => '%%value%%',
                            'properties' => array(
                                'class' => 'tf_rf_input_options_label'
                            ),
                        )
                    )
                ),

            ),
            'buttons' => array(
                array(
                    'type' => 'button',
                    'id' => 'rf_save_form_button',
                    'value' => 'Save Form',
                    'name' => 'save_form',
                    'subtype' => 'submit',
                    'properties' => array(
                        'class' => 'button'
                    )
                ),
                array(
                    'type' => 'button',
                    'value' => 'Cancel',
                    'id' => 'new_form_reset',
                    'subtype' => 'button',
                    'name' => 'rf_reset',
                    'properties' => array(
                        'class' => 'reset-button button'
                    )
                )
            )
        ),
        array( //Messages settings tab
            'name' => 'Messages Settings',
            'id' => 'tf_rf_messages_settings',
            'headings' => array(
                array(
                    'name' => 'Messages settings',
                    'id' => 'message_settings',
                    'options' => array(
                        array('name' => 'Form header text',
                            'desc' => 'The text that appears on the top of the form ',
                            'id' => 'tf_rf_heading_text',
                            'value' => 'Please fill in the reservation form below',
                            'type' => 'text'
                        ),
                        array('name' => 'Submit button text',
                            'desc' => 'The text that appears on the submit form button ',
                            'id' => 'tf_rf_mess_submit',
                            'value' => 'Submit reservation',
                            'type' => 'text'
                        ),
                        array('name' => 'Reset button text',
                            'desc' => 'The text that appears on the reset form button ',
                            'id' => 'tf_rf_mess_reset',
                            'value' => 'reset all fields',
                            'type' => 'text'
                        ),
                        array('name' => 'Success message',
                            'desc' => 'This message will be displayed if the form is successfully submitted',
                            'id' => 'tf_rf_succ_mess',
                            'value' => 'Reservation successfully sent. We\'ll get back to you shortly.',
                            'type' => 'text'),
                        array('name' => 'Failure message',
                            'desc' => 'This message will be displayed if the form failed to be submitted',
                            'id' => 'tf_rf_failure_mess',
                            'value' => 'Oops something went wrong. Please try again later',
                            'type' => 'text'),
                        array('name' => 'Email from',
                            'desc' => 'The reservation confirmation, approval or rejection email will appear that was sent from this email address. Please use an email that you verify often because you will also receive users replies on this email address',
                            'id' => 'tf_rf_email_from',
                            'value' => '',
                            'type' => 'text'),
                        array('name' => 'Email subject',
                            'desc' => 'This text will appear in the Subject line when the users receive a confirmation, approval or rejection email. Use the <strong>[resnumber]</strong> shortcode to include the reservation number in the subject line.',
                            'id' => 'tf_rf_email_subject',
                            'value' => 'Your reservation number is [resnumber]',
                            'type' => 'text'),
                        array('name' => 'New reservation admin email template',
                            'desc' => 'This email is automatically sent to the email address provided in `Email from` field when a user makes a reservation. ',
                            'id' => 'tf_rf_new_res_admin_email_template',
                            'value' => 'Your reservation [resnumber] has entered in our system and one of our guys will process it in a short while.<br>You will receive an email if the reservation is approved or denied shortly.<br><br>For further inquires please reply to this email.',
                            'type' => 'textarea'),
                        array('name' => 'Reservation approved email template',
                            'desc' => 'This email is received by the user after a reservation was confirmed from the User reservations page. It supports HTML and in order to display one of your form input values you need to copy/paste their shortcode in here.',
                            'id' => 'tf_rf_confirm_email_template',
                            'value' => 'Your reservation [resnumber] was approved.<br>We are waiting for you on [checkin].<br><br>For further assistance please reply to this email.',
                            'type' => 'textarea'),
                        array('name' => 'Reservation rejected email template',
                            'desc' => 'This email is received by the user after a reservation was rejected from the User reservations page. It supports HTML and in order to display one of your form input values you need to copy/paste their shortcode in here.',
                            'id' => 'tf_rf_reject_email_template',
                            'value' => 'Your reservation [resnumber] was rejected.<br><br>For further assistance please reply to this email.',
                            'type' => 'textarea'),
                        array('name' => 'Reservation confirmation email template',
                            'desc' => 'This email is automatically sent when a user makes a reservation. This is not an Approval or Rejection email but only a confirmation that the reservation is registered in the system with a certain unique number for easy identification which can also be attached to the email with the <strong>[resnumber]</strong> shortcode.',
                            'id' => 'tf_rf_new_res_email_template',
                            'value' => 'Your reservation [resnumber] has entered in our system and one of our guys will process it in a short while.<br>You will receive an email if the reservation is approved or denied shortly.<br><br>For further inquires please reply to this email.',
                            'type' => 'textarea'),
                        array('name' => 'Form template',
                            'desc' => 'This will help you change the structure of your form, control CSS on a specific input and/or add different HTML code above, in between or below your inputs. ',
                            'id' => 'tf_rf_form_template',
                            'value' => '<span>[label]</span>
<span>[input]</span>',
                            'type' => 'textarea'),
                        array('name' => 'Required text',
                            'desc' => 'This text apears near the inputs that are mandatory to be completed by the user ',
                            'id' => 'tf_rf_required_text',
                            'value' => '(required)',
                            'type' => 'text'
                        ),


                    ),
                ),

            ),
            'buttons' => array(
                array(
                    'type' => 'button',
                    'id' => 'rf_save_messages_button',
                    'value' => 'Save Form',
                    'name' => 'save_messages',
                    'subtype' => 'submit',
                    'properties' => array(
                        'class' => 'button'
                    )
                ),
                array(
                    'type' => 'button',
                    'value' => 'Cancel',
                    'id' => 'messages_reset',
                    'subtype' => 'button',
                    'name' => 'rf_reset',
                    'properties' => array(
                        'class' => 'reset-button button'
                    )
                )
            )
            ///end of tab
        ),
        array( //Dates settings tab
            'name'=>'Dates settings',
            'id'=>'tf_rf_dates_settings',
            'headings'=>array(
                array(
                    'name'=>'Dates to exclude',
                    'id'=>'tf_rf_dates_toexclude',
                    'options'=>array(
                        'type'=>'custom_reservationform_dates_row',
                        //datepicker
                        array(
                            'id' => 'tf_rf_exclude_date[]',
                            'type'=> 'datepicker',
                            'inp_name'=>'Exclude dates',
                            'desc' => '',
                            'value'=>'',
                            'properties'=>array(
                                'class' => 'tf_rf_exclude_interval',
                            ),
                            'popbox' =>array(
                                'with_datepickers' => array('tfuse_datepicker_from','tfuse_datepicker_to'),
                                'dependancy' => array(
                                    'tfuse_datepicker_from' => 'tfuse_datepicker_from',
                                    'tfuse_datepicker_to' => 'tfuse_datepicker_to'
                                ),
                                array(
                                    'type' => 'text',
                                    'name' => 'Date From',
                                    'id' => 'tfuse_datepicker_from',
                                    'value' => '',
                                    'desc' => '',
                                    'properties' => array(
                                        'class' => 'tf_exclude_from_datepicker'
                                    )
                                ),
                                array(
                                    'type' => 'text',
                                    'name' => 'Date To',
                                    'id' => 'tfuse_datepicker_to',
                                    'value' => '',
                                    'desc' => '',
                                    'properties' => array(
                                        'class' => 'tf_exclude_to_datepicker'
                                    )
                                ),
                                array('name' => 'Repeat',
                                    'desc' => '',
                                    'id' => 'interval_repeat',
                                    'value' => 0,
                                    'type' => 'select',
                                    'properties' => array(
                                        'class' => 'tf_exclude_repeat_datepicker'
                                    ),
                                    'options' => array ('Do not repeat','Every week','Every month','Every year' )
                                ),
                            ),
                        ),
                        //end datepicker
                        array('name' => '',
                            'desc' => '',
                            'id' => 'tf_rf_delete_dates_row',
                            'type' => 'raw',
                            'class' => 'tf_rf_delete_dates_row',
                            'value' => '',
                            'html' => '<img src="' . tf_extimage($this->ext->reservationform->_the_class_name, 'delete.png') . '" rel="is_default+default_is_default" class="reservationform_delete_excludedatesinput" style="display: none;">',
                            'divider' => true,
                        ),
                    )
                ),

            ),
            'buttons' => array(
                array(
                    'type' => 'button',
                    'id' => 'rf_save_dates_button',
                    'value' => 'Save Form',
                    'name' => 'save_dates',
                    'subtype' => 'submit',
                    'properties' => array(
                        'class' => 'button'
                    )
                ),
                array(
                    'type' => 'button',
                    'value' => 'Cancel',
                    'id' => 'messages_reset',
                    'subtype' => 'button',
                    'name' => 'rf_reset',
                    'properties' => array(
                        'class' => 'reset-button button'
                    )
                )
            )

        ),
        array( //General settings tab
            'name' => "General settings",
            'id' => 'tf_rf_general_settings',
            'headings' => array(
                array(
                    'id' => 'rf_general_settings',
                    'name' => 'Email sending options',
                    'options' => array( //Form fields
                        array(
                            'name' => 'Email sending option',
                            'type' => 'radio',
                            'id' => 'tf_rf_mail_type',
                            'value' => 'wpmail',
                            'options' => array(
                                'wpmail' => 'wp-mail',
                                'smtp' => 'smtp',
                            ),
                            'divider' => true
                        ),
                        array(
                            'name' => 'Secure connection',
                            'type' => 'radio',
                            'id' => 'tf_rf_secure_conn',
                            'value' => 'no',
                            'options' => array(
                                'no' => 'No',
                                'ssl' => 'SSL',
                                'tls' => 'TLS',
                            ),
                            'divider' => true
                        ),
                        array('name' => 'SMTP server address',
                            'desc' => 'SMTP server address',
                            'id' => 'tf_rf_smtp_host',
                            'value' => '',
                            'type' => 'text'),
                        array('name' => 'Port',
                            'desc' => 'SMTP server port',
                            'id' => 'tf_rf_smtp_port',
                            'value' => '25',
                            'type' => 'text'),
                        array('name' => 'Username',
                            'desc' => 'Leave blank if authentication not needed',
                            'id' => 'tf_rf_smtp_user',
                            'value' => '',
                            'type' => 'text'),
                        array('name' => 'Password',
                            'desc' => 'Leave blank if authentication not needed',
                            'id' => 'tf_rf_smtp_pwd',
                            'value' => '',
                            'type' => 'text'),
                    )
                )
            ),
            'buttons' => array(
                array(
                    'type' => 'button',
                    'value' => 'Save general options',
                    'id' => 'tf_rf_save_gen_options',
                    'name' => 'save_gen_options',
                    'subtype' => 'submit',
                    'properties' => array(
                        'class' => 'button'
                    )
                ),
                array(
                    'type' => 'button',
                    'value' => 'Reset options',
                    'id' => 'gen_options_reset',
                    'name' => 'reset_gen_options',
                    'subtype' => 'button',
                    'properties' => array(
                        'class' => 'reset-button button'
                    )
                )
            )
        ),

    ),
);
?>