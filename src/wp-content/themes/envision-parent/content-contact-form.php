<?php
/**
 * The template for displaying content in the template-contact.php template.
 * To override this template in a child theme, copy this file 
 * to your child theme's folder.
 *
 * @since Envision 2.0
 */
?>

<?php
    wp_enqueue_script( 'contactform', tfuse_get_file_uri('js/contactform.js'), array('jquery'), '2.0', true );
    
    $params = array( 'contactform_uri' => tfuse_get_file_uri('theme_config/theme_includes/CONTACTFORM.php') );
    
    wp_localize_script( 'contactform', 'ContactFormParams', $params );
    
    add_action( 'wp_footer', create_function( '', 'wp_print_scripts( "contactform" );' ) );
?>

<div class="contact-form">
    <h2><?php _e('Please fill in the form below:','tfuse');?></h2>
    <a name="contact"></a>
    <form id="contactForm" action="" method="post" class="ajax_form" name="contactForm">

        <div class="row field_text alignleft">
            <label><?php _e('Your name (required):', 'tfuse') ?></label>
            <input name="yourname" value="" id="name" class="inputtext input_middle required" size="40" type="text" />
        </div>

        <div class="row field_text alignleft omega">
            <label><?php _e('Your email (required):', 'tfuse') ?></label>
            <input name="email" value="" id="email" class="inputtext input_middle required" size="40" type="text" />
        </div>

        <div class="clear"></div>

        <div class="row field_select alignleft">
            <label><?php _e('Category', 'tfuse') ?>:</label>
            <select class="select_styled" name="contact_select_2">
                <option value="Billing_Support"><?php _e('Billing Support','tfuse'); ?></option>
                <option value="Pre_purchase_querstion"><?php _e('Pre purchase querstion','tfuse'); ?></option>
                <option value="Support_Question"><?php _e('Support Question','tfuse'); ?></option>
            </select>
        </div>

        <div class="row field_text alignleft omega">
            <label><?php _e('Subject', 'tfuse') ?>:</label>
            <input name="subject" value="" class="inputtext input_middle" size="40" type="text" id="subject"/>
        </div>

        <div class="clear"></div>

        <div class="row field_textarea">
            <label><?php _e('Your Message', 'tfuse') ?>:</label> 
            <textarea id="message" name="message" class="textarea textarea_middle required" cols="40" rows="10"><?php  if (isset($the_message)) echo $the_message ?></textarea>
        </div>

        <div class="clear"></div>

        <div class="row">
            <span class="reset-link"><a href="#" onclick="document.contactForm.reset();return false"><?php _e('reset all fields', 'tfuse') ?></a></span>
            <a href="#" id="sending" class="button_link"><img src="<?php echo get_template_directory_uri()?>/images/ajax-loader.gif" alt="sending" /> <span><?php _e('sending ...','tfuse'); ?></span></a>
            <input value="<?php _e('Send Message', 'tfuse') ?>" title="Submit message" class="contact-submit submit" id="send" type="submit" />
        </div>

    </form>

    <div id="reservation_send_ok" class="notice">
        <h2><?php _e('Your message has been sent!', 'tfuse') ?></h2>
        <?php _e('Thank you for contacting us,', 'tfuse') ?><br /><?php _e('We will get back to you within 2 business days.', 'tfuse') ?>
    </div>

    <div id="reservation_send_failure" class="notice">
        <h2><?php _e('Oops!', 'tfuse') ?></h2>
        <?php _e('Due to an unknown error, your form was not submitted, please resubmit it or try later.', 'tfuse') ?>
    </div>


</div>