jQuery(document).ready(function($) {

     $('.tfuse_selectable_code').live('click', function () {
        var r = document.createRange();
        var w = $(this).get(0);
        r.selectNodeContents(w);
        var sel = window.getSelection();
        sel.removeAllRanges();
        sel.addRange(r);
    });
    $(document).bind({reservationform_preview:function(){
        $('select.select_styled').selectmenu({
            style:'dropdown'
        });
    },
        contact_form_preview_open:function(){
            $('select.select_styled').selectmenu({
                style:'dropdown'
            });
        }
    });
    $('#tf_rf_form_name_select').change(function(){
        $_get=getUrlVars();
        if($(this).val()==-1 && 'formid' in $_get){
            delete $_get.formid;
        } else if($(this).val()!=-1){
            $_get.formid=$(this).val();
        }
        $_url_str='?';
        $.each($_get,function(key,val){
            $_url_str +=key+'='+val+'&';
        })
        $_url_str = $_url_str.substring(0,$_url_str.length-1);
        window.location.href=$_url_str;
    });


    function getUrlVars() {
        urlParams = {};
        var e,
            a = /\+/g,
            r = /([^&=]+)=?([^&]*)/g,
            d = function (s) {
                return decodeURIComponent(s.replace(a, " "));
            },
            q = window.location.search.substring(1);
        while (e = r.exec(q))
            urlParams[d(e[1])] = d(e[2]);
        return urlParams;
    }


    var options = new Array();

    options['envision_header_element'] = jQuery('#envision_header_element').val();
    jQuery('#envision_header_element').bind('change', function() {
        options['envision_header_element'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['envision_header_welcome_template'] = jQuery('#envision_header_welcome_template').val();
    jQuery('#envision_header_welcome_template').bind('change', function() {
        options['envision_header_welcome_template'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['envision_header_welcome_bar'] = jQuery('#envision_header_welcome_bar').attr('checked')?1:0;

    options['envision_homepage_category'] = jQuery('#envision_homepage_category').val();
    jQuery('#envision_homepage_category').bind('change', function() {
        options['envision_homepage_category'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['envision_header_element_blog'] = jQuery('#envision_header_element_blog').val();
    jQuery('#envision_header_element_blog').bind('change', function() {
        options['envision_header_element_blog'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['envision_header_welcome_template_blog'] = jQuery('#envision_header_welcome_template_blog').val();
    jQuery('#envision_header_welcome_template_blog').bind('change', function() {
        options['envision_header_welcome_template_blog'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });

    options['envision_blogpage_category'] = jQuery('#envision_blogpage_category').val();
    jQuery('#envision_blogpage_category').bind('change', function() {
        options['envision_blogpage_category'] = jQuery(this).val();
        tfuse_toggle_options(options);
    });
    options['envision_header_welcome_bar_blog'] = jQuery('#envision_header_welcome_bar_blog').attr('checked')?1:0;

    tfuse_toggle_options(options);

    jQuery('#envision_header_welcome_bar').bind('change', function() {
        options['envision_header_welcome_bar'] = jQuery('#envision_header_welcome_bar').attr('checked')?1:0;
        tfuse_toggle_options(options);
    });

    jQuery('#envision_header_welcome_bar_blog').bind('change', function() {
        options['envision_header_welcome_bar_blog'] = jQuery('#envision_header_welcome_bar_blog').attr('checked')?1:0;
        tfuse_toggle_options(options);
    });

    function tfuse_toggle_options(options)
    {

        jQuery('#envision_portfolio_select_categ_blog,#envision_template_portfolio_blog,#envision_portfolio_select_categ,#envision_template_portfolio,#envision_select_slider, #envision_header_image, #envision_header_image_link, #envision_header_image_target, ' +
        ' #envision_header_welcome_template, #envision_header_your_template, #envision_header_welcome_title, #envision_header_welcome_subtitle,' +
        ' #envision_header_welcome_icon, #envision_header_our_template, #slider_type').parents('.option-inner').hide();

        jQuery('#envision_portfolio_select_categ_blog,#envision_template_portfolio_blog,#envision_portfolio_select_categ,#envision_template_portfolio,#envision_select_slider, #envision_header_image, #envision_header_image_link, #envision_header_image_target, ' +
        ' #envision_header_welcome_template, #envision_header_your_template, #envision_header_welcome_title, #envision_header_welcome_subtitle,' +
        ' #envision_header_welcome_icon, #envision_header_our_template, #slider_type').parents('.form-field').hide();


        if(options['envision_header_element'] == 'slider')
        {
            jQuery('#envision_select_slider').parents('.option-inner').show();
            jQuery('#envision_select_slider').parents('.form-field').show();
        }
        else if(options['envision_header_element'] == 'image')
        {
            jQuery('#envision_header_image, #envision_header_image_link, #envision_header_image_target').parents('.option-inner').show();
            jQuery('#envision_header_image, #envision_header_image_link, #envision_header_image_target').parents('.form-field').show();

        }
        if ( options['envision_header_welcome_bar'] ){

            jQuery('#envision_header_welcome_template').parents('.option-inner').show();
            jQuery('#envision_header_welcome_template').parents('.form-field').show();

            if ( options['envision_header_welcome_template'] == 'your' ){
                jQuery('#envision_header_your_template').parents('.option-inner').show();
                jQuery('#envision_header_your_template').parents('.form-field').show();
            }
            else {
                jQuery('#envision_header_welcome_title, #envision_header_welcome_subtitle, #envision_header_welcome_icon, #envision_header_our_template').parents('.option-inner').show();
                jQuery('#envision_header_welcome_title, #envision_header_welcome_subtitle, #envision_header_welcome_icon, #envision_header_our_template').parents('.form-field').show();
            }
        }

        if(options['envision_homepage_category']=='all'){
            jQuery('.envision_use_page_options,.envision_categories_select_categ,.envision_home_page').hide();
            jQuery('#homepage-slider,#homepage-header').show();
        }
        else if(options['envision_homepage_category']=='specific'){
            jQuery('#homepage-slider,#homepage-header,.envision_categories_select_categ').show();
            jQuery('.envision_use_page_options,.envision_home_page').hide();
        }
		else if(options['envision_homepage_category']=='all_tax'){
            jQuery('#envision_template_portfolio').parents('.option-inner').show();
            jQuery('#envision_template_portfolio').parents('.form-field').show();
			jQuery('.envision_use_page_options,.envision_home_page').hide();
			jQuery('.envision_categories_select_categ').hide();
        }
		else if(options['envision_homepage_category']=='specific_tax'){
            jQuery('#envision_template_portfolio,#envision_portfolio_select_categ').parents('.option-inner').show();
            jQuery('#envision_template_portfolio,#envision_portfolio_select_categ').parents('.form-field').show();
			jQuery('.envision_use_page_options,.envision_home_page').hide();
			jQuery('.envision_categories_select_categ').hide();
        }
        else if(options['envision_homepage_category']=='page'){
            jQuery('.envision_use_page_options,.envision_home_page').show();
            jQuery('.envision_categories_select_categ').hide();
            if($('#envision_use_page_options').is(':checked')) jQuery('#homepage-slider,#homepage-header').hide();
            jQuery('#envision_use_page_options').live('change',function () {
                if(jQuery(this).is(':checked'))
                    jQuery('#homepage-slider,#homepage-header').hide();
                else
                    jQuery('#homepage-slider,#homepage-header').show();
            });
        }

        if(options['envision_header_element_blog'] == 'slider')
        {
            jQuery('.envision_header_image_blog,.envision_header_image_link_blog,.envision_header_image_target_blog').hide();
            jQuery('.envision_select_slider_blog').show();
        }
        else if(options['envision_header_element_blog'] == 'image')
        {
            jQuery('.envision_header_image_blog,.envision_header_image_link_blog,.envision_header_image_target_blog').show();
            jQuery('.envision_select_slider_blog').hide();
        }

        if ( options['envision_header_welcome_bar_blog'] ){
            jQuery('.envision_header_welcome_title_blog,.envision_header_welcome_subtitle_blog,.envision_header_welcome_icon_blog,.envision_header_our_template_blog,.envision_header_your_template_blog,.envision_header_welcome_template_blog').show();
            if ( options['envision_header_welcome_template_blog'] == 'our' ){
                jQuery('.envision_header_welcome_title_blog,.envision_header_welcome_subtitle_blog,.envision_header_welcome_icon_blog,.envision_header_our_template_blog').show();
                jQuery('.envision_header_your_template_blog').hide();
            }
            else {
                jQuery('.envision_header_your_template_blog').show();
                jQuery('.envision_header_welcome_title_blog,.envision_header_welcome_subtitle_blog,.envision_header_welcome_icon_blog,.envision_header_our_template_blog').hide();
            }
        }
        else {
            jQuery('.envision_header_welcome_title_blog,.envision_header_welcome_subtitle_blog,.envision_header_welcome_icon_blog,.envision_header_our_template_blog,.envision_header_your_template_blog,.envision_header_welcome_template_blog').hide();
        }

        if(options['envision_blogpage_category']=='all')
            jQuery('.envision_categories_select_categ_blog').hide();
		else if (options['envision_blogpage_category']=='all_tax')
		{
			jQuery('#envision_template_portfolio_blog').parents('.option-inner').show();
            jQuery('#envision_template_portfolio_blog').parents('.form-field').show();
			 jQuery('.envision_categories_select_categ_blog').hide();
		}
		else if (options['envision_blogpage_category']=='specific_tax')
		{
			jQuery('#envision_template_portfolio_blog').parents('.option-inner').show();
            jQuery('#envision_template_portfolio_blog').parents('.form-field').show();
			jQuery('#envision_portfolio_select_categ_blog').parents('.option-inner').show();
            jQuery('#envision_portfolio_select_categ_blog').parents('.form-field').show();
			 jQuery('.envision_categories_select_categ_blog').hide();
		}
        else
            jQuery('.envision_categories_select_categ_blog').show();


    }
});