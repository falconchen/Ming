/**
 * Contact Form
 *
 * To override this function in a child theme, copy this file to your child theme's
 * js folder.
 * /js/contactform.js
 * 
 * @version 2.0
 */

jQuery(document).ready(function(){
	tfuse_contact_form();
});

function tfuse_contact_form()
{
    jQuery('#send').bind('click', function()
    {
        var my_error = false;
	jQuery('#contactForm input, #contactForm textarea, #contactForm radio, #contactForm select').each(function(i)
	{
            var surrounding_element = jQuery(this);
            var value               = jQuery(this).attr('value');
            var check_for           = jQuery(this).attr('id');
            var required            = jQuery(this).hasClass('required');

            if(check_for == 'email')
            {
                surrounding_element.removeClass('error valid');
                baseclases = surrounding_element.attr('class');
                if(!value.match(/^\w[\w|\.|\-]+@\w[\w|\.|\-]+\.[a-zA-Z]{2,4}$/)) {
                    surrounding_element.attr('class',baseclases).addClass('error');
                    my_error = true;
                } else {
                    surrounding_element.attr('class',baseclases).addClass('valid');
                }
            }

            if(required && check_for != 'email')
            {
                surrounding_element.removeClass('error valid');
                baseclases = surrounding_element.attr('class');
                if(value == '') {
                    surrounding_element.attr('class',baseclases).addClass('error');
                    my_error = true;
                } else {
                    surrounding_element.attr('class',baseclases).addClass('valid');
                }
            }

            if(jQuery('#contactForm input, #contactForm textarea, #contactForm radio, #contactForm select').length  == i+1 && my_error == false)
            {
                jQuery('#contactForm #send, #contactForm .reset-link').hide();
                jQuery('#contactForm #sending').css('display','inline-block');

                var $datastring = 'ajax=true';
                jQuery('#contactForm input, #contactForm textarea, #contactForm radio, #contactForm select').each(function(i)
                {
                    var $name = jQuery(this).attr('name');
                    var $value = encodeURIComponent(jQuery(this).attr('value'));
                    $datastring = $datastring + '&' + $name + '=' + $value;
                });

                jQuery.ajax({
                type: 'POST',
                url: ContactFormParams.contactform_uri,
                data: $datastring,
                    success: function(response)
                    {
                        jQuery('#contactForm').hide();

                        if ( response == 'true' )
                        {
                            jQuery('#reservation_send_ok').show();
                        }
                        else
                        {
                            jQuery('#reservation_send_failure').show();
                        }
                        jQuery('#contactForm input[type="text"], #contactForm textarea, #contactForm radio, #contactForm select').val('');
                    }
                });
                
            }

        });
        return false;
    });
}
