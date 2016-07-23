<?php
/*
Plugin Name: 美女捕手
Plugin URI: https://www.cellmean.com/beauty-catcher
Description: 捕捉美女图片到Wordpress
Version: 1.0
Author: Falcon
Author URI: https://www.cellmean.com
*/

new BeautyCatcher();
class BeautyCatcher
{

    public function __construct(){

        register_activation_hook(__FILE__, 'BeautyCatcher::install');
        register_uninstall_hook(__FILE__, 'BeautyCatcher::uninstall');
        register_deactivation_hook(__FILE__, 'BeautyCatcher::deactivation', 0);
        add_action('admin_menu', array(&$this, 'admin_menu'), 2);
        add_action('wp_ajax_ajax_catch_image', array($this,'ajax_catch_image'));
        add_filter( 'mime_types', array($this,'add_mime_types' ));
        add_filter( 'post_mime_types', array($this,'custom_mime_types' ));
        add_filter('ajax_query_attachments_args',array($this,'beauty_mime_type'));
        add_action('pre-upload-ui',array($this,'is_beauty_image_btn'));

        add_action('admin_head-'.'media-new.php',array($this,'is_beauty_image_resource'));
        add_action('admin_head-'.'upload.php',array($this,'is_beauty_image_resource'));
        add_action('wp_ajax_ajax_change_is_beauty_image_option', array($this,'ajax_change_is_beauty_image_option'));
        add_filter('upload_post_params',array($this,'add_post_beauty_image_param'));
        //if ( $data = apply_filters( 'wp_update_attachment_metadata', $data, $post->ID ) )
        add_filter('wp_update_attachment_metadata',array($this,'update_beauty_image_meta'),10,2);
        add_action('admin_init',array($this,'change_upload_image_title_html')); // hack!
        add_action('wp_ajax_ajax_rename_uploaded_media_title',array($this,'ajax_rename_uploaded_media_title'));

    }


    public function  add_mime_types( $mime_types ) {
        $mime_types['bc'] = 'image/beauty';
        return $mime_types;
    }

    public function custom_mime_types( $post_mime_types ) {

        $post_mime_types['bc'] = array( __( '美女图片' ), __( 'Manage Beauties' ), _n_noop( 'Beauty <span class="count">(%s)</span>', 'Beauties <span class="count">(%s)</span>' ) );

        return $post_mime_types;
    }



    function beauty_mime_type($query){
        if(isset($query['post_mime_type']) && $query['post_mime_type'] == 'bc'){
            /*
            $arr = explode('/',$query['post_mime_type']);
            $terms = $arr[1];
            $query['tax_query'] = array(
                array(
                    'taxonomy' => 'pdf',
                    'field'    => 'slug',
                    'terms'    =>$terms,
                ),
            );
            */

            $query['meta_query'] = array(
                array(
                    'key'     => '_via_bc',
                    'value'   => '1',
                    //'compare' => 'IN',
                )
            );
            $query['post_mime_type'] = "image";
            /*
            global $wpdb;

            if(!$wpdb->get_var("SELECT 1 FROM $wpdb->posts WHERE post_mime_type = 'bc'")){
                wp_insert_attachment(
                    array('post_mime_type'=>'bc','post_status'=>'inherit')
                );
            }
            */

        }
        return $query;
    }


    public function admin_menu() {
        add_menu_page('美女捕手', '美女捕手', 'manage_options', "beauty_catcher", array(&$this, 'settings'), 'dashicons-admin-tools', 3);
        add_submenu_page('beauty_catcher', '设置', '设置', 'manage_options', "beauty_catcher", array(&$this, 'settings'));
        add_submenu_page('beauty_catcher', '抓取', '抓取', 'manage_options', 'beauty_catcher_run', array(&$this, 'run'));
        add_submenu_page('beauty_catcher', '测试', '测试', 'manage_options', 'beauty_catcher_test', array(&$this, 'test'));
    }

    static public function install() {
        self::create_tables();
    }

    static public function uninstall() {
        self::drop_tables();
    }

    static public function deactivation() {
        // self::drop_tables();
    }

    static public function create_tables()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'beauty';
        if($wpdb->get_var("SHOW TABLES LIKE ".$table_name."") != $table_name){
            $sql = 'CREATE TABLE `'.$table_name.'` (

                    `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
                    `title` VARCHAR( 1024 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                    `url` VARCHAR( 256 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                    `post_id` INT NOT NULL DEFAULT  "0" COMMENT  "对应的post_id",
                    `used_count` INT NOT NULL DEFAULT  "0" COMMENT  "使用次数",
                    `extra` TEXT NULL,


					INDEX `post_id` (`post_id`),
					INDEX `url` (`url`)
				)
				COLLATE="utf8_general_ci"
				ENGINE=MyISAM;';

            require_once(ABSPATH . "wp-admin/includes/upgrade.php");

            dbDelta($sql);
        }
    }

    static public function drop_tables() {
        global $wpdb;

        $table_name = $wpdb->prefix . 'beauty';

        $wpdb->query('DROP TABLE IF EXISTS ' . $table_name);

    }


    public function settings(){
        ?>
        <h1>设置</h1><hr/>
<?php
    }

    public function run(){
        ?>

        <h1>开始抓取</h1><hr/>
        <div id="message" class="updated fade" style="display:none;margin:5px 15px 5px 0; "></div>
        <script type="text/javascript">

            var curr_page = 1;
            var end_of_page = 60;

            function setMessage(msg) {
                jQuery("#message").html(msg);
                jQuery("#message").show();
            }

            function ajax_catch_image() {

                jQuery("#ajax_catch_image_btn").prop("disabled", true);
                jQuery('#ajax_loading').show();

                if(curr_page > end_of_page) {
                    jQuery('#ajax_loading').hide();
                    jQuery("#ajax_catch_image_btn").prop("disabled", false);
                    return ;
                }
                var url = 'http://qingbuyaohaixiu.com/page/'+curr_page;
                setMessage(url);
                jQuery.ajax({
                    url: "<?php echo admin_url('admin-ajax.php'); ?>",
                    type: "POST",
                    data: "action=ajax_catch_image&url="+encodeURIComponent(url),
                    success: function(result) {
                        var html = "";
                        for (index in result.data.images){
                            //console.log(result.data.images[index]+'>');
                            html+=result.data.images[index];
                        }
                        jQuery('#thumbs').html(html).show();

                        curr_page++;
                        ajax_catch_image();
                    },
                    error: function(){
                        ajax_catch_image();
                    }
                });
            };

            jQuery(document).ready(function($) {
                $('#ajax_catch_image_btn').on('click',function(){
                    curr_page = $('input[name=curr_page]').val();
                    end_of_page = $('input[name=end_of_page]').val();
                    ajax_catch_image();

                });
            });
        </script>
        <form method="post" action="" style="display:inline; float:left; padding-right:30px;">
            <label>开始页:<input type="text" name="curr_page" value="1"></label>
            <label>结束页:<input type="text" name="end_of_page" value="10"></label>
            <input type="button" class="button"
                   name="ajax_catch_image_btn" id="ajax_catch_image_btn"
                   value="开始捕获" />
            <img id="ajax_loading" src="<?php echo admin_url('images/loading.gif'); ?>" style="display:none;"/>
            <br />
            <div id="thumbs" style="display:none;"></div>
        </form>

        <?php
    }

    /*
     * 				'post_type' => 'attachment',
				'post_mime_type' => 'image',
				'numberposts' => -1,
				'post_status' => null,
				'post_parent' => null, // any parent
				'output' => 'object',
     */
    public function test() {
        $args = array(
            'posts_per_page' => 1,
            'post_type'  => 'attachment',
            'post_status' => 'any',
            'post_mime_type' => 'image',
            'orderby'    => 'rand',
            //'order'      => 'ASC',
            'meta_query' => array(
                array(
                    'key'     => '_via_bc',
                    'value'   => '1',
                    //'compare' => 'IN',
                ),
            ),
        );
        $query = new WP_Query( $args );
        //var_dump($query);
        while ($query->have_posts()){
            $query->the_post();
            $post_id = get_the_ID();
            echo '<li>';
            echo get_the_title();
            echo '<br/>';
            echo  get_attached_file( $post_id );
            echo '<br/>';
            echo  wp_get_attachment_url($post_id);
            echo '<br/>';
            echo  '</li>';
        }
    }

    public function ajax_catch_image() {
        set_time_limit(0);
        $url = $_POST['url'];
        $content = file_get_contents($url);
        preg_match_all('#<img width="150" height="150" src="(.*?)"#',$content,$match1);

        $images = array_map(function($item){
            return $item.'>';
        },$match1[0]);

        preg_match_all('#<h1 class="entry-title"><a.*?>(.*?)</a></h1>#',$content,$match2);


        $image_urls = array_map(function($item,$title){
            $item = str_replace('-150x150','',$item);
            $this->_fetch_image_to_local($item,$title);
        },$match1[1],$match2[1]);


        wp_send_json_success(array('url'=>$url,'images'=>$images));
        die();
    }


    protected function _fetch_image_to_local($img_url,$title="") {

        $basename = basename($img_url);
        $wp_upload_dir = wp_upload_dir() ;
        $beauty_dir = $wp_upload_dir['basedir'] . '/beauty';
        if(file_exists($beauty_dir.'/'.$basename)){
            return false;
        }
        if(!is_dir($beauty_dir)){
            @mkdir($beauty_dir,0777);
        }
        $filename = 'beauty/'.$basename;

        $path = $beauty_dir . '/'. $basename;
        if(!file_put_contents($path,file_get_contents($img_url))) {
            return false;
        }
        $url = $wp_upload_dir['baseurl'] . '/' .$filename;
        $image_type = wp_check_filetype_and_ext($path, $filename, null);
        $attachment = array(
            'post_mime_type' => $image_type['type'],
            'guid' => $url,
            'post_parent' => 0,
            'post_title' => $title,
            'post_content' => '',
        );

        $thumbnail_id = wp_insert_attachment($attachment,$filename,0);
        if (!is_wp_error($thumbnail_id)) {
            wp_update_attachment_metadata($thumbnail_id, wp_generate_attachment_metadata($thumbnail_id, $path));
            update_post_meta($thumbnail_id,'_via_bc',1);
        }else{
            return false;
        }


    }
    public function is_beauty_image_resource() {
         printf("<script src=\"%s\"></script>",plugin_dir_url( __FILE__ ) . 'is_beauty_image.js' );

    }
    public function is_beauty_image_btn() {
        add_thickbox();
        $option_state = get_option('is_beauty_image_option');
        $data_url = admin_url('admin-ajax.php?action=ajax_change_is_beauty_image_option&_wpnonce=' . wp_create_nonce('is_beauty_image_option'));
        ?>
        <p>
            <label for="is_beauty_image">是否放到美图 : </label>
            <input <?php checked($option_state);?> type="checkbox" id="is_beauty_image" value="yes" data-url="<?php echo $data_url;?>"/>
            <span id="setting_ok_word" style="display:none;color:green">  </span>
        </p>
<?php
    }

    public function ajax_change_is_beauty_image_option() {
        if ( isset($_REQUEST['state']) && check_admin_referer('is_beauty_image_option') ) {
            update_option('is_beauty_image_option',boolval($_REQUEST['state']));
            wp_send_json_success(array('state'=>get_option('is_beauty_image_option')));
        }else{
            wp_send_json_error();
        }
    }

    public function add_post_beauty_image_param($params){
        $params['is_beauty_image'] = intval(get_option('is_beauty_image_option',0));
        return $params;
    }

    public function update_beauty_image_meta($data,$post_id) {
        //var_dump($data);
        if( strpos(get_post_mime_type($post_id),'image') === 0 && $_REQUEST['is_beauty_image'] ) {
            update_post_meta($post_id,'_via_bc',1);
        }
        return $data;
    }

    public function change_upload_image_title_html() {

        if (
            isset($_REQUEST['attachment_id'])
            && ($id = intval($_REQUEST['attachment_id']))
            && $_REQUEST['fetch'] == 3
        ){
            $rename_url = admin_url('admin-ajax.php?action=ajax_rename_uploaded_media_title&post_id='. $id .'&_wpnonce=' . wp_create_nonce('ajax_rename_uploaded_media_title_'.$id));

            header( 'Content-Type: text/html; charset=' . get_option( 'blog_charset' ) );

            if ( isset( $_REQUEST['action'] ) && 'upload-attachment' === $_REQUEST['action'] ) {
                include( ABSPATH . 'wp-admin/includes/ajax-actions.php' );

                send_nosniff_header();
                nocache_headers();

                wp_ajax_upload_attachment();
                die( '0' );
            }

            if ( ! current_user_can( 'upload_files' ) ) {
                wp_die( __( 'You do not have permission to upload files.' ) );
            }

            $post = get_post( $id );
            if ( 'attachment' != $post->post_type )
                wp_die( __( 'Unknown post type.' ) );
            if ( ! current_user_can( 'edit_post', $id ) )
                wp_die( __( 'You are not allowed to edit this item.' ) );

            if ( $thumb_url = wp_get_attachment_image_src( $id, 'thumbnail', true ) ){

                $pic = $thumb_url = wp_get_attachment_image_src( $id, 'medium', true );
                //echo '<img class="pinkynail beauty_image" src="' . esc_url( $thumb_url[0] ) . '" alt="" />';
                printf('<a href="%s" class="thickbox"><img class="pinkynail beauty_image" src="%s"></a>',
                    //admin_url("async-upload.php?attachment_id=$id&fetch=2&TB_iframe=true&width=600&height=550"),
                    esc_url( $pic[0] ),
                    esc_url( $thumb_url[0] )
                );
            }
            echo '<a class="edit-attachment" href="' . esc_url( get_edit_post_link( $id ) ) . '" target="_blank">' . _x( 'Edit', 'media item' ) . '</a>';
            echo '<a onclick="rename_media_title(jQuery(this));return false;" class="edit-attachment rename-attachment" href="' . esc_url( $rename_url ) . '" target="_blank">' . _x( '改名', 'media item' ) . '</a>';

            // Title shouldn't ever be empty, but use filename just in case.
            $file = get_attached_file( $post->ID );

            $title = $post->post_title ? $post->post_title : wp_basename( $file );

            if(get_post_meta($id,'_via_bc',true)) { //
                $title = "";
            }
            printf('<div class="filename new"><input type="text" class="uploaded_media_title" name="uploaded_media_title" value="%s"/><span class="setting_ok" style="margin-left:0.5%%;display:none;color:green">OK !</span></div>',esc_attr($title));

            //echo '<div class="filename new"><span class="title">' . esc_html( wp_html_excerpt( $title, 60, '&hellip;' ) ) . '</span></div>';

            exit;
        }


    }

    function ajax_rename_uploaded_media_title() {
        if ( isset($_REQUEST['post_id'])
            && ($post_id = intval($_REQUEST['post_id']))
            && check_admin_referer('ajax_rename_uploaded_media_title_'. $post_id )) {


            $post_data =array(
                'ID' =>$post_id,
                'post_name'=>$_REQUEST['title'],
                'post_title'=>$_REQUEST['title'],
            );


            $post_id = wp_update_post($post_data,true);
            if (is_wp_error($post_id)) {
                $errors = $post_id->get_error_messages();
                wp_send_json_error(array('errors'=>implode(';',$errors)));

            }else{
                wp_send_json_success();
            }

        }


    }

}
