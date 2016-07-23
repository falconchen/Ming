// Execute when the page finishes loading, DOM ready
// loading in footer
var tf_new_taxonomy_links = null;
jQuery(document).ready(function($)
{
    // activate framework tabs
    var tf_meta_tabs = $(".tf_meta_tabs");
    if (tf_meta_tabs.length) {
        tf_meta_tabs.tabs().show();

        setTimeout(function(){
            // others can hook into this event to make something after tabs loading finished
            TFE.trigger('tf-tabs-loading-finish');
        }, 100);
    }
    $(".tf_load_meta_tabs").hide();

    // innerdocs
    $("a[rel^='prettyPhoto']").prettyPhoto({
        social_tools:false
    });

    $('#install_btn').click(function(){
        $('.demoinstall, .skipinstall').hide();
        $('.install_loading').show();
    });

    /*********************************************************/

    // disable wpbody-content overflow:hidden
    if(tf_script!=undefined && tf_script.disable_wpbodycontent_overflow)
        $('#wpbody-content').css('overflow','');

    // for home boxes
    $('.how_to_populate .selector').live('change',function()
    {
        $(this).nextAll('span').css({
            display:'none'
        });
        $(this).nextAll('.selected_'+$(this).val()).css({
            display:'block'
        });
    });

    /*********************************************************/

    // News & Promo iframe loading
    $('#newspromo_iframe').load(function()
    {
        $(this).show();

    });

    /*********************************************************/

    $(window).scroll(function()
    {
        $('#tfuse-popup-save').center();
        $('#tfuse-popup-reset').center();
        $('#tfuse-popup-fail').center();
        $('#tfuse-ajax-loading-img').center();
    });

    /*********************************************************/

    // ajax save framework options
    tf_form_bind_ajax_submit(
        $('#tfuse_admin_options_form'),
        {
            action:     'tfuse_ajax_mojax',
            tf_action:  'ajax_admin_save_options'
        }
    );
    // Prepare tabs postboxes
    $('.tfuse_fields form .postbox').removeClass('if-js-closed').addClass('closed');
    $('.tfuse_fields form .tf_meta_tabs .ui-tabs-panel .postbox:first-child', this).removeClass('closed');


    /*********************************************************/

    //When adding a new taxonomy after it has been added with AJAX to the list, go to the edit page of the new taxonomy
    /*
     $('#submit').ajaxComplete(function(evt, request, settings) {
     if (settings.data.match(/action=add\-tag&screen=/gi)) {
     matches=request.responseText.match(/<a href="([^"]+)">Edit<\/a>/gi);
     if(matches[0]!=undefined)
     window.location.href=$(matches[0]).attr('href');
     }
     })*/

    /*
     * Add onchange event to all tfuse options
     */

    $('body').on('click','.option .tfuse-meta-radio-img-img',function(){
        optid=$(this).parents('.option').attr('option');
        old_val=opt_get(optid);
        new_val=$(this).attr('optval');
        opt_set(optid, new_val);
        if(old_val!=new_val)
            $('[name="'+optid+'"][value="'+new_val+'"]').change();
    });

    (function(){
        var init_hidden_children = function(element, hidden_children)
        {
            var first_time = true;
            element.click(function(){
                var open        = element.hasClass('children-hidden');
                var elements    = $( $.map(hidden_children, function(el){ return '.tf-interface-option.'+el; }).join(', ') );

                if (open) {
                    element.removeClass('children-hidden');
                    (first_time ? elements.show() : elements.slideDown());
                } else {
                    element.addClass('children-hidden');
                    (first_time ? elements.hide() : elements.slideUp());
                }
                first_time = false;
            }).trigger('click');
        };

        $('div.tf-interface-option[tf_hidden_children]').each(function()
        {
            try {
                var hidden_children = $.parseJSON( $(this).attr('tf_hidden_children') );
                if (!hidden_children.length) {
                    return;
                }
            } catch (e) {
                console.log( 'error parsing "tf_hidden_children" attribute on element with class="'+$(this).attr('class')+'"' );
                return;
            }
            init_hidden_children($('.tf-interface-hidden-children', this).first(), hidden_children);
        });
    })();
    
    $('body').on('click', '.tf_checkbox_switch:not(.disabled)', function(){
        $(this).toggleClass('on');
         // "destruct" hidden(default) input above checbox if is checked, because on form serialize to not contain double values [val1,val2]...
         var helement = $("input.checkbox_default_hidden_value", $(this).parent());
         if ( helement.length ) {
             if ( (helement.attr('name') !== undefined) && helement.attr('name').length ) {
                 helement.attr('hiddenname', helement.attr('name'));
                 helement.removeAttr('name');
             } else {
                 helement.attr('name', helement.attr('hiddenname'));
                 helement.removeAttr('hiddenname');

             }
         }
    });
    tf_optionize();
});

function showLoading() {
    jQuery('#tfuse-ajax-loading-img').fadeIn().center();
}

function hideLoading() {
    jQuery('#tfuse-ajax-loading-img').fadeOut('fast');
}

function showFinishedLoading() {
    var success_msg = jQuery('#tfuse-popup-save' );
    hideLoading();
    success_msg.fadeIn().center();
    window.setTimeout(function(){
        success_msg.fadeOut();
    }, 2000);
}

function showFailLoading() {
    var warning_msg = jQuery('#tfuse-popup-fail' );
    hideLoading();
    warning_msg.fadeIn().center();
    window.setTimeout(function(){
        warning_msg.fadeOut();
    }, 2000);
}

function thumb_link(url) {
    var im_parts;
    if(tf_script.blog_id!=undefined) {
        im_parts=url.split('/files/');
        if(im_parts[1]!=undefined)
            url=tf_script.network_site_url+'blogs.dir/' + tf_script.blog_id + '/files/' + im_parts[1];
    }
    return url;
}

function opt_get(optid,context) {
    var $=jQuery;
    if(context==undefined)
        context=$('body');
    out='';
    if($('[name="'+optid+'"]',context).length>0) {
        $obj=$('[name="'+optid+'"]',context);
        if($obj.is('input[type="radio"]')) {
            out=$obj.filter(':checked').val();
            if(out==undefined)
                out='';
            return out;
        }
        else if($obj.is('input[type="checkbox"]')) {
            out=$obj.filter(':checked').val();
            if(out==undefined)
                out='false';
            return out;
        }
        out=$obj.val();
        if(out==undefined)
            out='';
    }
    else if($('[name="'+optid+'[]"]',context).length>0) {
        out=[];
        $('[name="'+optid+'[]"]',context).each(function(){
            val=$(this).val();
            if(val==undefined)
                val='';
            out.push(val);
        });
    }
    return out;
}

function opt_set(optid,val) {
    var $ = jQuery;
    if( $('[name="'+optid+'"]').length>0 ) {
        $obj = $('[name="'+optid+'"]');
        if( $obj.is('input[type="radio"]') ) {
            $obj.filter('[value="'+val+'"]').prop("checked", true).trigger('change');
            curr = $obj.filter(':checked');
            curr.parents('.formcontainer').find('.thumb_radio_over').removeClass('tfuse-meta-radio-img-selected');
            curr.parents('.tfuse-meta-radio-img-box').find('.thumb_radio_over').addClass('tfuse-meta-radio-img-selected');
            return true;
        }
        $obj.val(val);
        if($obj.is(':hidden')==true)
            $obj.change();
    }
    else if($('[name="'+optid+'[]"]').length>0) {
        $('[name="'+optid+'[]"]').each(function(i){
            $(this).val(val[i]);
        });
    }
    return true;
}

function opt_reset(optid,context) {
    var $=jQuery;
    if(context==undefined)
        context=$('body');
    if($('[name="'+optid+'"]',context).length>0) {
        $obj=$('[name="'+optid+'"]',context);
        if($obj.is('input[type="radio"]')) {
            $('[name="'+optid+'"]').prop("checked",false).attr('checked',false).parents('.formcontainer').find('.thumb_radio_over').removeClass('tfuse-meta-radio-img-selected');
            return true;
        }
        $obj.val('');
    }
    else if($('[name="'+optid+'[]"]',context).length>0) {
        $('[name="'+optid+'[]"]',context).each(function(i){
            $(this).val('');
        });
    }
    return true;
}

// Fix bug with thickbox and jquery ui tabs
function killTheUnloadEvent(e)
{
    e.stopPropagation();
    e.stopImmediatePropagation();
    return false;
}

function tfuse_thumb_load (itemurl,el) {
    var $ = jQuery;
    var thumb, link, vals = {};
    var external = RegExp('^((f|ht)tps?:)?//(?!' + location.host + ')');
    if(external.test(itemurl))
    {
        thumb = link = itemurl;
        vals = {};
    }
    else
    {
        var imgurl = itemurl;
        var blog_id = tf_script.blog_id;
        if(blog_id)
        {
            var imageParts = imgurl.split('/files/');
            if(imageParts[1]!=null)
                imgurl = '/blogs.dir/'+blog_id+'/files/'+imageParts[1];
        }

        link =  tf_script.template_directory_uri + '/framework/timthumb/timthumb.php';
        thumb = link + '?w=45&amp;h=45&amp;zc=1&amp;src='+imgurl;
        vals = {
            w:'45',
            h:'45',
            zc:'1',
            src: imgurl
        };
    }
    $(el).html('<img src="'+tf_script.template_directory_uri+'/framework/static/images/loading_16x16.gif" class="loading_thumb_ico" />');
    $.get(link, vals, function() {
        $(el).html('<img src="'+tf_script.template_directory_uri+'/framework/static/images/loading_16x16.gif" class="loading_thumb_ico" /><div class="thumb_over"></div><img src="'+thumb+'" width="45" height="45" class="loading_thumb" />');
    })
    .error(function() {
        var ext = link.split('.').pop().toLowerCase();
        switch (ext){
            case 'jpg': case 'gif': case 'png': case 'ico':
                if($(el).html()) $(el).html('<div class="thumb_over"></div><img src="'+thumb+'" width="45" height="45" />').find('div.thumb_over').show();
                break;
            default:
                $(el).html('');
        }
    })
    .complete(function() {
        if($(el).html()) $(el).html('<div class="thumb_over"></div><img src="'+thumb+'" width="45" height="45" />').find('div.thumb_over').show();
    });

    // BeautyTips
    $(el).bt({
        contentSelector: function(){
            return '<img src="'+itemurl+'" style="max-width:400px" />'
        },
        padding: '4px',
        positions: ['top','left'],
        fill: 'white',
        width: '400px',
        strokeStyle: '#e0e0e0',
        spikeLength: 10,
        strokeWidth: 1
    });

}

//this function prepares all custom inputs to work properly. Must be called when new options are added to the dom dynamically
function tf_optionize() {
    var $=jQuery;

    /**** Checkbox options ****/
    //$('div.option-checkbox input:checkbox:checked + .tf_checkbox_switch, tr.tfuse-tax-form-field input:checkbox:checked + .tf_checkbox_switch').addClass('on');
    /*$('.tf_checkbox_switch:not(.disabled)').each(function(){
        if($(this).prop('initialized')!==true) {
            $(this).prop('initialized',true);
            $(this).click(function() {
                $(this).toggleClass('on');

                // "destruct" hidden(default) input above checbox if is checked, because on form serialize to not contain double values [val1,val2]...
                var helement = $("input.checkbox_default_hidden_value", $(this).parent());
                if ( helement.length ) {
                    if ( (helement.attr('name') !== undefined) && helement.attr('name').length ) {
                        helement.attr('hiddenname', helement.attr('name'));
                        helement.attr('name', '');
                    } else {
                        helement.attr('name', helement.attr('hiddenname'));
                        helement.attr('hiddenname', '');
                    }
                }
            });
        }
    });*/

    /**** ColorPicker options ****/
    $('.tf_color_select').each(function(){
        if($(this).prop('initialized')!==true) {
            $(this).prop('initialized',true);
            $(this).ColorPicker({
                onSubmit: function(hsb, hex, rgb, el) {
                    $(el).val('#'+hex);
                    $(el).ColorPickerHide();
                },
                onBeforeShow: function () {
                    $(this).ColorPickerSetColor(this.value);
                },
                onChange: function (hsb, hex, rgb) {
                    $('.tf_color_selected').val('#'+hex).change();
                }
            });
            $(this).on('focus','.tf_color_select', function(){
                $('.tf_color_selected').removeClass('tf_color_selected');
                $(this).addClass('tf_color_selected');
            });
        }
    });

    /**** DatePicker options ****/
    $('.tf_date_select').each(function(){
        var formatd = ($(this).attr('rel'));
        $(this).datepicker({
            dateFormat : formatd
        });
    });

    /**** Radio Images options ****/
    $('img.tfuse-meta-radio-img-img').each(function(){
        if($(this).prop('initialized')!==true) {
            $(this).prop('initialized',true);
            $(this).click(function(){
                $(this).parents('div.formcontainer, tr.tfuse-tax-form-field').find('div.thumb_radio_over').removeClass('tfuse-meta-radio-img-selected');
                opt_set($(this).prevAll('.tfuse-meta-radio-img-label').find('input:radio').attr('name'),$(this).attr('optval'));
                $(this).prev('div.thumb_radio_over').addClass('tfuse-meta-radio-img-selected');
            });
        }
    });

    /**** Multi options ****/
    $('.tfuse_suggest_input').each(function(){
        if($(this).prop('initialized')!==true) {
            $(this).prop('initialized',true);
            $(this).one('focus',function() {
                var multiple_box    = $(this).parent('.multiple_box');
                var multiple_box_selected_titles = multiple_box.find('div.multiple_box_selected_titles');
                var li              = multiple_box_selected_titles.find('span:eq(0)');
                var input_id        = $(this).attr('id');
                var name            = $(this).attr('rel');
                var type            = ( $(this).hasClass('tfuse_taxonomy_type') ) ? 'taxonomy' : 'post';

                $('#'+input_id).suggest( 'admin-ajax.php?action=tfuse_get_suggest&type='+type+'&name='+name,
                {
                    resultsClass:   'tfuse_ac_results '+type+input_id,
                    selectClass:    'tfuse_ac_over',
                    matchClass:     'tfuse_ac_match',

                    onSelect: function()
                    {
                        var selected    = $('.tfuse_ac_results.'+type+input_id+' .tfuse_ac_over');
                        var sel_id      = selected.children('a').attr('rel');
                        var saved_val   = multiple_box.children('input:hidden');
                        var arrvals     = saved_val.val().split(',');

                        if ( $.inArray(sel_id, arrvals) == -1 && sel_id != 0 )
                        {
                            var new_li = li.clone().removeAttr('style');
                            new_li.find('a').attr('rel',sel_id);
                            new_li.append(selected.text());
                            new_li.appendTo( multiple_box_selected_titles );
                            new_vals=( saved_val.val() ) ? saved_val.val()+','+sel_id : sel_id;
                            old_vals=saved_val.val();
                            saved_val.val( new_vals );
                            if(new_vals!=old_vals)
                                saved_val.change();
                            $(this).val('');
                            //my custom addition
                            $('#'+input_id).trigger('onselect',[{
                                'value':sel_id
                            }]);
                        //end custom addition
                        }
                        else
                        {
                            $(this).blur().val('Already exists, try another ... ');
                        }
                    }
                });
            })
            .focus(function() {
                $(this).removeClass('tfuse_input_help_text').addClass('edit').val('');
            })
            .blur(function() {
                $(this).addClass('tfuse_input_help_text').removeClass('edit').val('Type here to search');
            });
            jQuery(document).ajaxSend(function(evt, request, settings) {
                if (settings.url.match(/admin-ajax.php\?action=tfuse_get_suggest/gi)) {
                    $('.tfuse_suggest_input.edit').addClass('tfuse_ac_loading');
                }
            });
            jQuery(document).ajaxComplete(function(evt, request, settings) {
                if (settings.url.match(/admin-ajax.php\?action=tfuse_get_suggest/gi)) {
                    $('.tfuse_suggest_input.edit').removeClass('tfuse_ac_loading');
                }
            });
        }
    });
    // also, do some stuff that must be done only once
    if(typeof tf_optionize.one_time=='undefined') {
        //adds functionality to the multi_items delete anchors
        $('body').on('click','a.remove_multi_items',function()
        {
            var multiple_box = $(this).parents('.multiple_box');
            var saved_val = multiple_box.children('input:hidden');
            var arrvals = saved_val.val().split(',');
            var id = $(this).attr('rel');
            arrvals = $.grep( arrvals, function(n,i)
            {
                return n != id;
            });
            new_vals=arrvals.join(',');
            old_vals=saved_val.val();
            saved_val.val( new_vals );
            if(new_vals!=old_vals)
                saved_val.change();
            $(this).parent('span').remove();
            return false;
        });
        //works out the upload buttons
        // Wordpress Media Upload
        var formfield,tab, media, formID, tfuse_title = '',button,no_tabs;
        $('.upload_button').live('click',function()
        {
            button = $(this);
            formfield = $(this).attr('id').replace('_button','');
            media = 'image';
            media = ($('#'+formfield).length > 0) ? $('#'+formfield).attr('rel') : media;
            formID = $(this).attr('rel');
            tab = $(this).attr('tab') || 'type' ;
            var change = !$(this).hasClass('sliders');
            $.ajax({
                url:ajaxurl,
                type:'post',
                dataType:'json',
                data:'action=change_gallery_id&post_id='+formID+'&input_id='+formfield+'&media='+media+'&change='+change,
                success:function(response){
                    formID = response.id;
                    button.attr('rel',formID);
                    no_tabs = (button.hasClass('multi_upload')) ? '&amp;no_tabs=1' : '' ;
                    if ( tfuse_title = $(this).parents('.option-inner').find('label').text() ) { }
                    else if ( tfuse_title = $(this).parents('.form-field').find('label').text() ) { }
                    tb_show ( tfuse_title, 'media-upload.php?post_id='+formID+'&amp;type='+media+'&amp;formfield='+formfield+'&amp;tab='+tab+no_tabs+'&amp;TB_iframe=1' );
                    $('#TB_window,#TB_overlay,#TB_HideSelect').one('unload',killTheUnloadEvent);
                    if(button.closest('.upload_button_div').find('.attachment_num').length)
                        _content = $('#TB_window').find('iframe').contents();
                    no_tabs = no_tabs.replace('&amp;','&');
                    $($('#TB_window').find('iframe')).load(function(){
                        _image_form = $(this).contents().find('#image-form');
                        _image_form.attr('action',_image_form.attr('action')+no_tabs);
                        _gallery_form = $(this).contents().find('#gallery-form');
                        _gallery_form.attr('action',_gallery_form.attr('action')+no_tabs);
                    });

                    $("#TB_window").bind('tb_unload', function () {
                        with_images = 'Add/Edit Images';
                        no_images = 'Upload Images';
                        attachments = $(this).find('iframe').contents().find('#attachments-count');
                        _placeholder = button.closest('.upload_button_div');
                        if(attachments.length){
                            _placeholder.find('.attachment_num').html(attachments.html());
                            if(button.hasClass('multi_upload'))
                            button.html(with_images);
                            button.attr('tab','gallery');
                        } else {
                            _placeholder.find('.attachment_num').html(0);
                            if(button.hasClass('multi_upload'))
                            button.html(no_images);
                            button.attr('tab','type');
                        }
                    });

                }
            });

            return false;
        });

        window.original_send_to_editor = window.send_to_editor;
        window.send_to_editor = function(html)
        {
            if (formfield)
            {
                var itemurl,el, type = 'image';
                if ( typeof $(html).attr('src') != 'undefined' )
                {
                    itemurl = $(html).attr('src');
                }
                else if ( $(html).html(html).find('img').length > 0 )
                {
                    //var fullimg = $(html).attr('href');
                    itemurl = $('img',html).attr('src');
                } else  { itemurl = $(html).attr('href'); type = 'file'; }

                if (typeof itemurl != 'undefined' && media == 'image' && type == 'image')
                {
                    var upload_el_metabox = $('#'+formfield).parents('div.option-upload').find('div.uploaded_thumb');
                    var upload_el_taxonomy = $('#'+formfield).parents('tr').find('div.uploaded_thumb');
                    if( upload_el_metabox.length > 0 ) {
                        el = upload_el_metabox;
                    }
                    else if ( upload_el_taxonomy.length > 0 ) {
                        el = upload_el_taxonomy;
                    }

                    tfuse_thumb_load (itemurl,el);
                    $obj=$('input[name="'+formfield+'"]');
                    curr_value=$obj.val();
                    $obj.val(itemurl);
                    if(curr_value!=itemurl)
                        $obj.change();
                } else if (typeof itemurl != 'undefined' && media == 'file')
                {
                    $obj=$('input[name="'+formfield+'"]');
                    curr_value=$obj.val();
                    $obj.val(itemurl);
                    if(curr_value!=itemurl)
                        $obj.change();
                }

                tb_remove();
            }
            else
            {
                window.original_send_to_editor(html);
            }
            formfield = itemurl = el = '';
        }
        //initialize the thumbs loaded with the page
        $('div.uploaded_thumb[rel]').each(function()
        {
            tfuse_thumb_load ($(this).attr('rel'),$(this));
        });
        tf_optionize.one_time=true;
    }
}