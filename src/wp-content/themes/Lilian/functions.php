<?php
/**
 *
 * Description:
 * Author: falcon
 * Date: 16/7/15
 * Time: 下午10:59
 *
 */
require_once 'admin/functions.php';
require_once 'admin/journal.php';

define('LILIAN_TEMPLATE_DIR_URI', esc_url(get_template_directory_uri()));// 模板目录url,不带 /
define('LILIAN_TEMPLATE_ASSETS_URI', LILIAN_TEMPLATE_DIR_URI . '/assets');// 主题资源目录url,不带 /

add_theme_support('post-formats', array('gallery', 'quote'));
add_image_size('daily-crop', 225, 225, true); // 每日缩略图，裁切

// 加载js和样式表
add_action('wp_enqueue_scripts', 'lilian_theme_scripts_styles');
function lilian_theme_scripts_styles()
{
    wp_enqueue_style('bootstrap', LILIAN_TEMPLATE_ASSETS_URI . '/css/bootstrap.css');
    wp_enqueue_style('fontawsome', LILIAN_TEMPLATE_ASSETS_URI . '/css/fontawsome.css');

    wp_enqueue_style('themify-icons', LILIAN_TEMPLATE_ASSETS_URI . '/css/themify-icons.css'); // 字体
    wp_enqueue_style('main', LILIAN_TEMPLATE_ASSETS_URI . '/css/main.css'); // 主样式

    wp_enqueue_script('modernizr', LILIAN_TEMPLATE_ASSETS_URI . '/js/modernizr.min.js', null, false, false);
    wp_enqueue_script('main', LILIAN_TEMPLATE_ASSETS_URI . '/js/main.min.js', array('jquery'), false, true);

}

function remove_wp_open_sans()
{
    wp_deregister_style('open-sans');
    wp_register_style('open-sans', false);
}

add_action('wp_enqueue_scripts', 'remove_wp_open_sans');
// Uncomment below to remove from admin
add_action('admin_enqueue_scripts', 'remove_wp_open_sans');


function the_nav_bar()
{
    $current_id = get_the_ID();
    $args = array(
        'post_type' => 'page',
        'posts_per_page' => -1,
        'order' => 'ASC',
        'orderby' => 'date'
    );
    $the_query = new WP_Query($args);

// 循环开始
    if ($the_query->have_posts()) :
        while ($the_query->have_posts()) : $the_query->the_post();
            ?>
            <a <?php if (get_the_ID() == $current_id): ?>class="current_page"<?php endif; ?>
               href="<?php the_permalink() ?>"><?php the_title() ?></a> &nbsp;&nbsp;&nbsp;
            <?php
        endwhile;
    endif;

// 重置文章数据
    wp_reset_postdata();
}

function local_current_date($date_format = "")
{
    if ($date_format == "") {
        $date_format = get_option('date_format');
    }

    return date("{$date_format}", current_time('timestamp'));
}

/**
 * 获取最新一篇gallery
 */


function get_latest_gallery()
{

}

/**
 * 获取最新一篇文字
 */

function get_latest_quote()
{

}


add_action('wp_head','lilian_ajaxurl');
function lilian_ajaxurl() {
?>
<script type="text/javascript">
    var ajaxurl = ajaxurl || '<?php echo admin_url('admin-ajax.php'); ?>';
</script>
<?php
}


// ajax请求处理
add_action('wp_ajax_lilian_show_more_images', 'lilian_show_more_images');
add_action('wp_ajax_nopriv_lilian_show_more_images', 'lilian_show_more_images');
function lilian_show_more_images() {

    $paged = intval($_GET['paged']);
    $args = array(
        'paged' => $paged,
        'posts_per_page' => 1,
        'order' => 'DESC',
        'orderby' => 'ID',
        'post_status' => 'publish',
        'tax_query' => array(
            array(
                'taxonomy' => 'post_format',
                'field'    => 'slug',
                'terms'    => array( 'post-format-gallery' ),
            ),
        )
    );

    $the_query = new WP_Query($args);
    if (!$the_query->have_posts()){
        wp_send_json_error(array("html"=>"","has_next_page"=>false));
    }else{
        ob_start();
?>


    <?php while ($the_query->have_posts()) : $the_query->the_post(); ?>
        <?php
        $content = get_the_content();
        $current_postid = get_the_ID();
        $regex = get_shortcode_regex(array('gallery'));
        if(preg_match_all("/$regex/",$content,$matches)) {
            $attr = shortcode_parse_atts( $matches[3][0] );
            $images_ids = $attr['ids'];
        }
        $images_ids_arr = explode(',',$images_ids);
        ?>
        <?php foreach ($images_ids_arr as $image_id): ?>
            <?php $image_info = wp_get_attachment_image_src($image_id, 'full');?>
            <div class="col-xs-6 col-md-3">
                <div class="project">
                    <a  href="<?php echo $image_info[0];?>">
                        <?php echo wp_get_attachment_image($image_id , 'daily-crop'); ?>
                    </a>
                </div>
            </div>
        <?php endforeach;?>
    <?php endwhile;?>
    <?php
        wp_reset_postdata();
        $html = ob_get_contents();
        ob_clean();

        $args = array(
            'paged' => $paged + 1,
            'posts_per_page' => 1,
            'order' => 'DESC',
            'orderby' => 'ID',
            'post_status' => 'publish',
            'tax_query' => array(
                array(
                    'taxonomy' => 'post_format',
                    'field'    => 'slug',
                    'terms'    => array( 'post-format-gallery' ),
                ),
            )
        );

        $the_query = new WP_Query($args);
        $has_next_page =  $the_query->have_posts();
        wp_send_json_success(array("html"=>$html,"has_next_page"=>$has_next_page));
    }
}


