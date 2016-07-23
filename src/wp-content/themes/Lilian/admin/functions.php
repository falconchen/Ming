<?php
/**
 *
 * Description:
 * Author: falcon
 * Date: 16/7/18
 * Time: 下午9:21
 *
 */

/**
 *
 */
add_action( 'add_meta_boxes', 'lilian_add_meta_boxes' );

function lilian_add_meta_boxes(){
    $post_type = get_post_type();

    if( in_array( $post_type ,array('post','page') ) ) {
        //加入一个metabox
        add_meta_box( "lilian_meta_box", '<strong>其他信息</strong>', 'lilian_meta_box_post_callback',null,'side') ;
    }



}

function lilian_meta_box_post_callback() {

    $defaults = array(
        "author" => "",
        "keywords" => "",
        "link" => ""
    );
    $post = get_post();
    if(is_object($post)) {
        $lilian = get_post_meta($post->ID,'_lilian',true);
        $daily_num = get_post_meta($post->ID,'_daily_num',true);
    }
    $lilian = is_array($lilian) ? $lilian :$defaults;
    //var_dump($lilian['link']);
    $daily_num = $daily_num >0 ? $daily_num : get_max_daily_num() + 1;

?>
    <style>
        .lilian_meta_div{
            line-height: 2.5em;
            height: 2.5em;

        }
        .lilian_meta_div span{
            display: inline-block;
            width: 20%;
        }
        .lilian_meta_div label{
            display: inline-block;
            width: 70%;
        }
        .lilian_meta_div input {
            display: inline-block;
            width: 100%;
        }
    </style>
    <div class="lilian_meta_div">
        <span>作者:</span>
        <label><input type="text"  name="lilian[author]" value="<?php echo esc_attr($lilian['author']);?>" placeholder="可留空"></label>
    </div>
    <div class="lilian_meta_div">
        <span>关键字:</span>
        <label><input type="text"  name="lilian[keywords]" value="<?php echo esc_attr($lilian['keywords']);?>" placeholder="留空为作者名"></label>
    </div>
    <div class="lilian_meta_div">
        <span>链接:<?php echo $lilian['link'];?></span>
        <label><input type="text"  name="lilian['link']" value="<?php echo $lilian['link'];?>" placeholder="可留空"></label>
    </div>
    <div class="lilian_meta_div">

        <span>期号: </span>
        <label><input type="text"  readonly="true" name="daily_num" value="<?php echo $daily_num;?>" placeholder="期号"></label>
    </div>

<?php
}

function get_max_daily_num() {
    global $wpdb;
    $issue = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='_daily_num' ORDER BY meta_value DESC LIMIT 1");
    return intval($issue);

}



add_filter('wp_insert_post_data','lilian_insert_post_data', 10,2) ;
function lilian_insert_post_data($data,$post_arr) {

    if(@$post_arr['lilian']['author'] == ""
        && (($via_pos = strrpos($data['post_excerpt'],'via ')) > 0 || ($by_pos = strrpos($data['post_excerpt'],'by '))  > 0) ) {

        $_POST['lilian']['author']  = substr($data['post_excerpt'], $via_pos > 0 ? $via_pos + 4 : $by_pos + 3);
        $data['post_excerpt'] = substr($data['post_excerpt'], 0, $via_pos > 0 ? $via_pos : $by_pos);
    }

    if(@$post_arr['lilian']['keywords'] == "") {
        $_POST['lilian']['keywords'] = $_POST['lilian']['author'] ;
    }

    if($data['post_title'] == "" && $data['post_excerpt'] != "") {
        $data['post_title'] = $data['post_excerpt'];
    }

    return $data;
}


// 更新作者和期数等
add_action('save_post','lilian_save_post',999,2);
function lilian_save_post($id, $post) {

    $lilian = $_POST['lilian'];
    update_post_meta($id,'_lilian',$lilian);
    $daily_num = isset($_POST['daily_num']) ? intval($_POST['daily_num']) : get_max_daily_num() + 1;
    update_post_meta($id,'_daily_num',intval($daily_num));
}

//
add_action ('publish_post', 'lilian_publish_post', 10, 2);
function lilian_publish_post($id, $post) {

    if(get_post_format($id) == 'gallery') {
        $regex = get_shortcode_regex(array('gallery'));
        if(!preg_match("/$regex/",$post->post_content)){
            wp_update_post(
              array('ID'=>$id,'post_status'=>'pending')
            );
        }
    }
}

// 新文章默认使用相册发布形式
add_action('admin_head-'.'post-new.php','lilian_checked_gallery');
function lilian_checked_gallery(){

?>
<script>
    jQuery(document).ready(function ($) {
       $('#post-format-gallery').attr('checked',"checked");
    });
</script>
<?php
}