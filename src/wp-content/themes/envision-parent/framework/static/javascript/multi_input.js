jQuery(document).ready(function(){
    var add_btn_class   = '.tf_opt_multiple_add_btn';
    var remove_btn_class= '.tf_opt_multiple_remove_btn';
    var input_row_class = '.tf_opt_multiple_input_row';
    var input_content   = '.tf_opt_multiple_content';

    jQuery(document).on('click',add_btn_class, function(){
        var content=jQuery(this).siblings(input_content);
        var input_row=content.find(input_row_class).first().clone(true).append('<a href="" class="tf_opt_multiple_remove_btn"></a>')
        input_row.find('input,textarea').val('');
        content.append(input_row);
        return false;
    });

    jQuery(document).on('click',remove_btn_class, function(){
        jQuery(this).closest(input_row_class).remove();
        return false;
    });
});