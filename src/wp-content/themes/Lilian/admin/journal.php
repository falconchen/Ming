<?php
/**
 *
 * Description:  期刊(journal)发布类型
 * Author: falcon
 * Date: 16/7/19
 * Time: 下午3:10
 *
 */

add_action( 'init', 'create_journal_type' );
function create_journal_type() {

    register_post_type( 'journal',

        array(

            'labels' => array(

                'name' => '期刊',

                'singular_name' => '期刊',

                'add_new' => '添加新期刊',

                'add_new_item' => '添加新期刊',

                'edit' => '编辑',

                'edit_item' => '编辑期刊',

                'new_item' => '新建期刊',

                'view' => '查看',

                'view_item' => '查看期刊',

                'search_items' => '搜索期刊',

                'not_found' => '没找到期刊',

                'not_found_in_trash' => '垃圾桶没有期刊',

                'parent' => '父级期刊',

                'all_items'=>'所有期刊'

            ),



            'public' => true,

            'menu_position' => 4,

            'supports' => array( 'title', 'editor', 'comments', 'thumbnail', 'custom-fields' ),

            'taxonomies' => array( 'post_tag','music_writer' ),

            'menu_icon' => 'dashicons-book',

            'has_archive' => true

        )

    );
}

add_action( 'add_meta_boxes', 'journal_add_meta_boxes' );

function journal_add_meta_boxes() {
    if( get_post_type() ==  'journal' ) {
        add_meta_box("lilian_meta_box", '<strong>期刊信息</strong>', 'journal_meta_box_callback', null, 'side');
    }
}
function journal_meta_box_callback() {
    $issue = 0;
    $post = get_post();
    if(is_object($post)) {
        $issue = get_post_meta($post->ID,'_issue',true);
    }

    if( !$issue ) {
        $issue = get_max_issue_num() + 1;
    }
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

        <span>刊号: </span>
        <label><input type="text"  readonly="true" name="issue" value="<?php echo $issue;?>" placeholder="当前期刊号"></label>
    </div>
    <?php
}


add_action('save_post_journal','journal_save_post',999,2);
function journal_save_post($id, $post) {

    $issue = isset($_POST['issue']) ? intval($_POST['issue']) : get_max_issue_num() + 1;
    if($post->post_title == "") {
        remove_all_actions('save_post_journal');
        $error = wp_update_post(
            array(
                'ID' => $id,
                'post_title' => sprintf('第 %s 期', $issue)
            ),true
        );
    }
    update_post_meta( $id,'_issue', $issue);

}


function get_max_issue_num() {
    global $wpdb;
    $issue = $wpdb->get_var("SELECT meta_value FROM $wpdb->postmeta WHERE meta_key='_issue' ORDER BY meta_value DESC");
    return intval($issue);

}

add_shortcode('issue','issue_func');
function issue_func($atts) {

    $a = shortcode_atts( array(
        'text' => '0',
        'image' => '0',
    ), $atts );

    return "foo = {$a['text']} - {$a['image']}";
}
