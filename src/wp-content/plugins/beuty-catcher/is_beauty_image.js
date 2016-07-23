/**
 * Created by falcon on 16/6/28.
 */
jQuery(document).ready(function ($) {
    // console.log($('#is_beauty_image').prop('checked'));
    $('#is_beauty_image').change(
      function() {
          var state = ($(this).attr('checked') == 'checked') ? 1 : 0;
          var url = $(this).attr('data-url');
          $.ajax(
              {
                  url: url,
                  type: "POST",
                  data: "state="+state,
                  dataType: 'json',
                  success: function(result) {
                      var ok_word;

                      if(result.data.state == true){
                          wpUploaderInit.multipart_params.is_beauty_image = 1;
                          ok_word = '放入美图';
                      }else{
                          wpUploaderInit.multipart_params.is_beauty_image = 0;
                          ok_word = '不放入美图'
                      }
                    $('#setting_ok_word').text(ok_word).show();

                  },
                  error: function(){

                  }
              }
          );

            /*
          $('.rename-attachment').live('click',function(){

                var _this = $(this);
                //console.log(_this.parent().children('.filename').children('.uploaded_media_title'));
                return false;
          }) ;
            */

      }
    );
});

function rename_media_title($elem){
    var url = $elem.attr('href');
    var title = $elem.parent().children('.filename').children('.uploaded_media_title').val();
    jQuery.ajax(
        {
            url: url,
            type: "POST",
            data: "title="+title,
            dataType: 'json',
            success: function(result) {
                if(result.success){
                    $elem.parent().children('.filename').children('.setting_ok').css('display','inline-block').show();
                }else{
                    alert('改名失败:'+result.data.errors);
                }
            },
            error: function(){
                alert('出错了');
            }
        }
    );
    return false;

}