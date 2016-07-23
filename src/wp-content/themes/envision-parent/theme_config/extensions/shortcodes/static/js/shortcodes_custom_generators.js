function custom_generator_faq(type,options) {
    shortcode='[faq title="'+options.title+'"]';
    for(i in options.array) {
        shortcode+='[faq_question]'+options.array[i]['question']+'[/faq_question]';
        shortcode+='[faq_answer]'+options.array[i]['answer']+'[/faq_answer]';
    }
    shortcode+='[/faq]';
    return shortcode;
}

function custom_obtainer_faq(data) {
    cont=jQuery('.tf_shortcode_option:visible');
    sh_options={};
    sh_options['array']=[];
    sh_options['title']=opt_get('tf_shc_faq_title',cont);
    cont.find('[name="tf_shc_faq_question"]').each(function(i) {
        question=jQuery(this).val();
        answer=jQuery(this).parents('.option').nextAll('.option').find('[name="tf_shc_faq_answer"]:first').val();
        tmp={};
        tmp['question']=question;
        tmp['answer']=answer;
        sh_options['array'].push(tmp);
    })
    return sh_options;
}

function custom_generator_tabs(type,options) {
    shortcode='[tabs class="'+options['class']+'"]';
    for(i in options.array) {
        shortcode+='[tab title="'+options.array[i]['title']+'"]'+options.array[i]['content']+'[/tab]';
    }
    shortcode+='[/tabs]';
    return shortcode;
}

function custom_obtainer_tabs(data) {
    cont=jQuery('.tf_shortcode_option:visible');
    sh_options={};
    sh_options['array']=[];
    sh_options['class']= opt_get('tf_shc_tabs_class',cont);
    cont.find('[name="tf_shc_tabs_title"]').each(function(i) {
        div=jQuery(this).parents('.option');
        title=opt_get(jQuery(this).attr('name'),div);
        div=jQuery(this).parents('.option').nextAll('.option').find('[name="tf_shc_tabs_content"]').first().parents('.option');
        content=opt_get(jQuery(this).parents('.option').nextAll('.option').find('[name="tf_shc_tabs_content"]').first().attr('name'),div);
        tmp={};
        tmp['title']=title;
        tmp['content']=content;
        sh_options['array'].push(tmp);
    })
    console.log(sh_options)
    return sh_options;
}

function custom_generator_icon_tabs(type,options) {
    shortcode='[icon_tabs class="'+options['class']+'" title="'+options['title']+'" width="'+options['width']+'" height="'+options['height']+'"]';
    for(i in options.array) {
        shortcode+='[icon_tab icon="'+options.array[i]['icon']+'"]'+options.array[i]['content']+'[/icon_tab]';
    }
    shortcode+='[/icon_tabs]';
    return shortcode;
}

function custom_obtainer_icon_tabs(data) {
    var jQuery = jQuery;
    cont=jQuery('.tf_shortcode_option:visible');
    sh_options={};
    sh_options['array']=[];
    sh_options['title']= opt_get('tf_shc_icon_tabs_title',cont);
    sh_options['class']= opt_get('tf_shc_icon_tabs_class',cont);
    sh_options['width']= opt_get('tf_shc_icon_tabs_width',cont);
    sh_options['height']= opt_get('tf_shc_icon_tabs_height',cont);
    cont.find('[name="tf_shc_icon_tabs_icon"]').each(function(i) {
        div=jQuery(this).parents('.option');
        icon=opt_get(jQuery(this).attr('name'),div);
        div=jQuery(this).parents('.option').nextAll('.option').find('[name="tf_shc_icon_tabs_content"]').first().parents('.option');
        content=opt_get(jQuery(this).parents('.option').nextAll('.option').find('[name="tf_shc_icon_tabs_content"]').first().attr('name'),div);
        tmp={};
        tmp['icon']=icon;
        tmp['content']=content;
        sh_options['array'].push(tmp);
    })
    console.log(sh_options)
    return sh_options;
}
