<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

/**
 * Description of INIT
 *
 */
class TF_INIT extends TF_TFUSE {

    public $_the_class_name = 'INIT';

    public function __construct() {
        parent::__construct();
    }

    public function __init() {
        $this->init_theme();
        $this->init_ajax();
        $this->init_options();
        $this->init_framework();
        $this->init_hooks();
        $this->timthumb_extra();
    }

    protected function init_theme() {
        foreach (glob(TFUSE_CONFIG_COMMON_INCLUDES . '/*.php') as $filename) {
            locate_template(TFUSE_CONFIG_COMMON_INCLUDES_DIR . '/' . basename($filename), TRUE);
        }
        if (is_admin()) {
            foreach (glob(TFUSE_CONFIG_ADMIN_INCLUDES . '/*.php') as $filename) {
                locate_template(TFUSE_CONFIG_ADMIN_INCLUDES_DIR . '/' . basename($filename), TRUE);
            }
        }
        if (!is_admin() || $this->input->is_ajax_request()) {
            foreach (glob(TFUSE_CONFIG_THEME_INCLUDES . '/*.php') as $filename) {
                locate_template(TFUSE_CONFIG_THEME_INCLUDES_DIR . '/' . basename($filename), TRUE);
            }
        }
        foreach (glob(TFUSE_CONFIG_WIDGETS . '/*.php') as $filename) {
            locate_template(TFUSE_CONFIG_WIDGETS_DIR . '/' . basename($filename), TRUE);
        }

        add_action('init', array($this, 'wp_init_action'));
    }

    public function wp_init_action(){
        if ($this->get->option('admin', TF_THEME_PREFIX . '_remove_wp_versions') == 'true') {
            remove_action('wp_head', 'wlwmanifest_link');
            remove_action('wp_head', 'rsd_link');
            add_filter('the_generator', array($this, 'voidling'));
        }
    }

    protected function init_ajax() {
        $this->load->model('MOJAX');
        $this->ajax->_add_action('tfuse_ajax_mojax', $this->mojax);
    }

    protected function init_options() {
        $this->load->model('MOJAX');
        //if need to resset options reset!
        if ($this->request->isset_POST('reset') && $this->request->POST('tfuse_save') == 'reset')
            $this->mojax->ajax_admin_reset_options();

        $this->load->model('FWOPTIONS');

        if ('editpost' == $this->theme->action) {
            add_action('edit_post', array(&$this->fwoptions, 'save_post_options_init'), 10, 2);
        }

        if ('editedtag' == $this->theme->action) {
            add_action('edited_term', array(&$this->fwoptions, 'save_taxonomy_options_init'), 10, 3);
        }

        add_action($this->theme->taxonomy . '_edit_form_fields', array(&$this->interface, 'create_taxonomy_options'), 10, 2);
    }

    protected function init_framework() {
        load_theme_textdomain('tfuse');
        load_theme_textdomain('tfuse', TFUSE_THEME_DIR . '/languages');
        if (function_exists('load_child_theme_textdomain'))
            load_child_theme_textdomain('tfuse');
        add_action('init', 'tfuse_register_gallery_group_post_type');
        add_action('init', 'tfuse_register_download_group_post_type');
        add_action('wp_ajax_tfuse_get_suggest', 'tfuse_get_suggest');
        add_filter('themefuse_shortcodes', 'do_shortcode');
        add_filter('widget_text', 'do_shortcode');
        # This sets the HTML Editor as default #
        add_filter('wp_default_editor', create_function('', 'return "html";'));
    }

    protected function check_cache_folder() {
        $cache_path = wp_upload_dir();
        $cache_path = $cache_path['basedir'];
        if (!file_exists($cache_path . '/tfuse_cache/')) {
            mkdir($cache_path . '/tfuse_cache/');
            mkdir($cache_path . '/tfuse_cache/minimizer/');
            mkdir($cache_path . '/tfuse_cache/timthumb/');
        }
        file_put_contents(TFUSE . '/config/cache_dir.php', $cache_path);
    }

    protected function init_hooks() {
        add_action('admin_footer', array($this, 'add_ajax_notificators'));
    }

    function add_ajax_notificators() {
        $this->load->view('ajax_notificators');
    }

    protected function timthumb_extra() {
        //adds blog_id to tf_script so that thimthumb worked
        global $blog_id;
        if (is_multisite() && isset($blog_id) && $blog_id > 0)
            $this->include->js_enq('blog_id', $blog_id);
        $this->include->js_enq('network_site_url', network_site_url());
    }

    public function voidling() {
        return '';
    }

}