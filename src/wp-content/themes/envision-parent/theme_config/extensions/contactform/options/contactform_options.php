<?php
$cfg['input_types']=array(
                        array(
                            'name'=>'Text Input',
                            'type'=>'text',
                            'value'=>'',
                            'id'=>TF_THEME_PREFIX.'_%%name%%',
                            'options'=>false
                            ),
                        array(
                            'name'=>'Text area',
                            'type'=>'textarea',
                            'value'=>'',
                            'id'=>TF_THEME_PREFIX.'_%%name%%',
                            'options'=>false
                             ),

                        array(
                             'name'=>'Radiobox',
                             'type'=>'radio',
                             'value'=>'',
                             'id'=>TF_THEME_PREFIX."_%%name%%",
                             'options'=>true
                             ),
                        array(
                             'name'=>'Checkbox',
                             'type'=>'checkbox',
                             'value'=>'',
                             'id'=>TF_THEME_PREFIX."_%%name%%",
                             'options'=>false
                             ),
                         array(
                             'name'=>'SelectBox',
                             'type'=>'select',
                             'value'=>'',
                             'id'=>TF_THEME_PREFIX."_%%name%%",
                             'options'=>true,
                             'properties'=>array(
                                 'class'=>'select_styled'
                             )
                              ),
                         array(
                             'name'=>'Email',
                             'type'=>'text',
                             'value'=>'',
                             'id'=>TF_THEME_PREFIX."_%%name%%",
                             'options'=>false
                             ),
                         array(
                              'name'=>'Captcha',
                              'type'=>'captcha',
                              'value'=>'',
                              'id'=>TF_THEME_PREFIX."_captcha",
                              'options'=>false,
                              'file_name'=>'captcha_gen.php'
                              )
                        );
$options_name=array();
foreach($cfg['input_types'] as $value){
    $options_name[]=$value['name'];
}
$form_name =
$options=array(
              'tabs'=>array(
                        array(
                            'name' => 'Add/Edit Forms',
                                        'id' => 'add_edit_forms', #do no t change this ID
                                        'headings' => array (
                                            array(
                                                'name' => 'Form Settings',
                                                'id'=>'form_name',
                                                'options' =>array(
                                                    array('name' => 'Form shortcode',
                                                          'desc' => 'Copy this shortcode to add the form into the page/post',
                                                          'id' => 'tf_cf_shortcode',
                                                          'value'=>'[tfuse_contactform tf_cf_formid="%%form_id%%"]',
                                                          'type'=>'selectable_code',

                                                    ),
                                                    array('name' => 'Form name',
                                                        'desc' => 'The form name will not be displayed to the users. It is for internal use only',
                                                        'type' => 'text',
                                                        'id' => 'tf_cf_formname_input',
                                                        'value' => ''),
                                                    array('name' => 'Email to',
                                                          'desc' => 'The form will be sent to this email address. We recommend you to use an email that you verify often',
                                                          'id' => 'tf_cf_email_to',
                                                          'value'=>get_bloginfo('admin_email'),
                                                          'type'=>'text'),
                                                    array('name' => 'Email subject',
                                                          'desc' => 'This text will appear in the Subject line when you receive an email from this form. Make it short and
                                                          original for easy identification',
                                                          'id' => 'tf_cf_email_subject',
                                                          'value'=>'',
                                                          'type'=>'text'),
                                                )
                                            ),
                                            array(
                                                'name' => 'Form Content',
                                                'id'=>'form_settings',
                                                'options' => array(
                                                    array('name' => 'Input type',
                                                        'desc' => 'Input type',
                                                        'id' => 'tf_cf_select[]',
                                                        'value'=>0,
                                                        'type'=>'select',
                                                        'properties'=>array(
                                                        'class'=>'medica_inp_select'
                                                         ),
                                                        'options'=>$options_name),
                                                    array('name' => 'Label',
                                                        'desc' => 'Input label',
                                                        'id' => 'tf_cf_input[]',
                                                        'value' => '',
                                                        'properties'=>array(
                                                              'class'=>'cf_input_label'
                                                             ),
                                                        'type' => 'text'),
                                                    array('name'=>'Width',
                                                          'desc'=>'fields width',
                                                          'type'=>'text',
                                                          'id'=>'tf_cf_input_width[]',
                                                          'value'=>'50',
                                                          'properties'=>array(
                                                              'class'=>'cf_input_width'
                                                          ),
                                                          'divider'=>true),
                                                    array('name'=>'Required',
                                                        'desc'=>'is this field required?',
                                                        'type'=>'checkbox',
                                                        'id'=>'tf_cf_input_required',
                                                        'value'=>'none',
                                                        'properties'=>array(
                                                            'class'=>'cf_input_required'
                                                        ),
                                                        'divider'=>true
                                                         ),
                                                    array('name'=>'New Line',
                                                        'desc'=>'show this field in new line',
                                                        'type'=>'checkbox',
                                                        'id'=>'tf_cf_input_newline',
                                                        'value'=>'none',
                                                        'properties'=>array(
                                                            'class'=>'cf_input_newline'
                                                        ),
                                                        'divider'=>true
                                                         ),
                                                    array('name'=>'',
                                                         'desc'=>'',
                                                         'id'=>'tf_cf_shortcode_row',
                                                         'type'=>'selectable_code',
                                                         'value'=>'%%code%%',
                                                         'properties'=>array(
                                                            'class'=> 'shortcode_code'
                                                         ),
                                                         'divider'=>true,
                                                         ),
                                                    array('name'=>'',
                                                         'desc'=>'',
                                                         'id'=>'tf_cf_delete_row',
                                                         'type'=>'raw',
                                                         'class'=>'tf_cf_delete_row',
                                                         'value'=>'',
                                                         'html'=>'<img src="'.tf_extimage($this->ext->contactform->_the_class_name, 'delete.png').'" rel="is_default+default_is_default" class="contactform_delete_input" style="display: none;">',
                                                         'divider'=>true,
                                                         ),
                                                    array('name'=>'',
                                                         'desc'=>'',
                                                         'id'=>'tf_cf_toggle_show',
                                                         'type'=>'raw',
                                                         'class'=>'tf_cf_toggle_show',
                                                         'value'=>'',
                                                         'html'=>'<span class="show_more_less">-Show less</span>',
                                                         'divider'=>true,
                                                         ),
                                                 'type'=>'custom_contactform_row'
                                                ),
                                            'options_row'=>array(
                                                array(
                                                    'name'=>'Option',
                                                    'desc'=>'',
                                                    'id'=>'tf_cf_input_options_label',
                                                    'type'=>'text',
                                                    'value'=>'%%value%%',
                                                    'properties'=>array(
                                                                'class'=>'tf_cf_input_options_label'
                                                        ),
                                                )
                                            )
                                            ),

                                        ),
                            'buttons'=>array(
                                array(
                                    'type'=>'button',
                                    'id'=>'cf_save_form_button',
                                    'value'=>'Save Form',
                                    'name'=>'save_form',
                                    'subtype'=>'submit',
                                    'properties'=>array(
                                        'class'=>'button'
                                    )
                                ),
                                array(
                                    'type'=>'button',
                                    'value'=>'Cancel',
                                    'id'=>'new_form_reset',
                                    'subtype'=>'button',
                                    'name'=>'cf_reset',
                                    'properties'=>array(
                                        'class'=>'reset-button button'
                                    )
                                )
                            )
                        ),
                  array(//Messages settings tab
                      'name'=>'Messages Settings',
                      'id'=>'tf_cf_messages_settings',
                      'headings'=>array(
                                array(
                                       'name' => 'Messages settings',
                                       'id'=>'message_settings',
                                       'options' => array(
                                           array('name' => 'Form header text',
                                               'desc' => 'The text that appears on the top of the form ',
                                               'id' => 'tf_cf_heading_text',
                                               'value' => 'Please fill in the form below',
                                               'type' => 'text'
                                           ),
                                           array('name' => 'Submit button text',
                                                  'desc' => 'The text that appears on the submit form button ',
                                                  'id' => 'tf_cf_mess_submit',
                                                  'value' => 'Send message',
                                                  'type' => 'text'
                                           ),
                                           array('name' => 'Reset button text',
                                               'desc' => 'The text that appears on the reset form button ',
                                               'id' => 'tf_cf_mess_reset',
                                               'value' => 'reset all fields',
                                               'type' => 'text'
                                           ),
                                           array('name' => 'Success message',
                                                 'desc' => 'This message will be displayed if the form is successfully submitted',
                                                 'id' => 'tf_cf_succ_mess',
                                                 'value'=>'Message sent.We`ll get back to you asap',
                                                 'type'=>'text'),
                                           array('name' => 'Failure message',
                                                 'desc' => 'This message will be displayed if the form failed to be submitted',
                                                 'id' => 'tf_cf_failure_mess',
                                                 'value'=>'Oops something went wrong.Please try again later',
                                                 'type'=>'text'),
                                           array('name' => 'Email from',
                                                 'desc' => 'The form will look like was sent from this address.',
                                                 'id' => 'tf_cf_email_from',
                                                 'value'=>get_bloginfo('admin_email'),
                                                 'type'=>'text'),
                                           array('name' => 'Email template',
                                                 'desc' => 'You can use this to create a nice template for the email you receive. It supports HTML and in order to display one of your form input values you need to copy/paste their shortcode in here.',
                                                 'id' => 'tf_cf_email_template',
                                                 'value'=>'',
                                                 'type'=>'textarea'),
                                           array('name' => 'Form template',
                                                 'desc' => 'This will help you change the structure of your form, control CSS on a specific input and/or add different HTML code above, in between or below your inputs. ',
                                                 'id' => 'tf_cf_form_template',
                                                 'value'=>'<span>[label]</span>
<span>[input]</span>',
                                                 'type'=>'textarea'),
                                           array('name' => 'Required text',
                                                  'desc' => 'This text apears near the inputs that are mandatory to be completed by the user ',
                                                  'id' => 'tf_cf_required_text',
                                                  'value' => '(required)',
                                                  'type' => 'text'
                                           ),





                                         ),
                          ),

                                   ),
                      'buttons'=>array(
                                   array(
                                        'type'=>'button',
                                        'id'=>'cf_save_messages_button',
                                        'value'=>'Save Messages',
                                        'name'=>'save_messages',
                                        'subtype'=>'submit',
                                        'properties'=>array(
                                                     'class'=>'button'
                                                          )
                                        ),
                                   array(
                                        'type'=>'button',
                                        'value'=>'Cancel',
                                        'id'=>'messages_reset',
                                        'subtype'=>'button',
                                        'name'=>'cf_reset',
                                        'properties'=>array(
                                        'class'=>'reset-button button'
                                         )
                                     )
                                )
                  ///end of tab
                  ),
                  array(//General settings tab
                      'name'=>"General settings",
                      'id'=>'tf_cf_general_settings',
                      'headings'=>array(
                          array(
                          'id'=>'cf_general_settings',
                          'name'=>'Email sending options',
                          'options'=>array(//Form fields
                              array(
                                  'name'=>'Email sending option',
                                  'type'=>'radio',
                                  'id'=>'tf_cf_mail_type',
                                  'value'=>'wpmail',
                                  'options'=>array(
                                    'wpmail'=>'wp-mail',
                                    'smtp'=>'smtp',
                                     ),
                                  'divider'=>true
                              ),
                              array(
                                   'name'=>'Secure connection',
                                   'type'=>'radio',
                                   'id'=>'tf_cf_secure_conn',
                                   'value'=>'no',
                                   'options'=>array(
                                   'no'=>'No',
                                   'ssl'=>'SSL',
                                   'tls'=>'TLS',
                                   ),
                                   'divider'=>true
                                    ),
                              array('name' => 'SMTP server address',
                                    'desc' => 'SMTP server address',
                                    'id' => 'tf_cf_smtp_host',
                                    'value'=>'',
                                    'type'=>'text'),
                              array('name' => 'Port',
                              'desc' => 'SMTP server port',
                              'id' => 'tf_cf_smtp_port',
                              'value'=>'25',
                              'type'=>'text'),
                              array('name' => 'Username',
                              'desc' => 'Leave blank if authentication not needed',
                              'id' => 'tf_cf_smtp_user',
                              'value'=>'',
                              'type'=>'text'),
                              array('name' => 'Password',
                               'desc' => 'Leave blank if authentication not needed',
                               'id' => 'tf_cf_smtp_pwd',
                               'value'=>'',
                               'type'=>'text'),
                          )
                      )
                          ),
                      'buttons'=>array(
                          array(
                              'type'=>'button',
                              'value'=>'Save general options',
                              'id'=>'tf_cf_save_gen_options',
                              'name'=>'save_gen_options',
                              'subtype'=>'submit',
                              'properties'=>array(
                                           'class'=>'button'
                                                )
                          ),
                          array(
                              'type'=>'button',
                              'value'=>'Reset options',
                              'id'=>'gen_options_reset',
                              'name'=>'reset_gen_options',
                              'subtype'=>'button',
                              'properties'=>array(
                                  'class'=>'reset-button button'
                              )
                          )
                      )
                  ),

              ),
);
?>