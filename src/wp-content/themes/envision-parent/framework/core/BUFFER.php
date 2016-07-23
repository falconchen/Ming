<?php

if (!defined('TFUSE'))
    exit('Direct access forbidden.');

/**
 * Description of BUFFER
 *
 */
class TF_BUFFER extends TF_TFUSE {

    protected $_filters = array();
    protected $_buffer = '';
    public $_the_class_name = 'BUFFER';
    protected $_is_end = FALSE;
    public $_no_signature = FALSE;

    public function __construct() {
        parent::__construct();
    }

    public function __init() {
        add_action('init', array($this, 'start_ob'));
        add_action('shutdown', array($this, 'end_ob'), 0);
    }

    public function start_ob() {
        ob_start();
    }

    public function add_filter($callback) {
        if (!in_array($callback, $this->_filters))
            $this->_filters[] = $callback;
    }

    public function apply_filters() {
        foreach ($this->_filters as $filter) {
            if (is_array($filter)) {
                if (is_object($filter[0]) && method_exists($filter[0], $filter[1])) {
                    $this->_buffer = $filter[0]->{$filter[1]}($this->_buffer);
                }
            } else {
                if (function_exists($filter)) {
                    $this->_buffer = $filter($this->_buffer);
                }
            }
        }
    }

    public function set_buffer($buffer = '', $flag = 'replace') {
        static $_flag = '', $_buffer = '';
        if ($this->_is_end !== TRUE) {
            $this->add_filter(array($this, 'set_buffer'));
            if (!in_array($flag, array('prepend', 'replace', 'append')))
                return FALSE;
            $_flag = $flag;
            $_buffer = $buffer;
        }
        else {
            if ($_flag === 'replace') {
                return $_buffer;
            }
            if ($_flag === 'prepend') {
                return $_buffer . $this->_buffer;
            }
            if ($_flag === 'append') {
                return ($this->_buffer . $_buffer);
            }
        }
    }

    public function set_no_signature($value){
        $this->_no_signature = (bool)$value;
    }

    protected function add_fw_signature() {
        $data = array();
        $data['elapsed_time'] = timer_stop(0, 4);
        $data['memory_usage'] = memory_get_usage(TRUE);
        $data['theme_name'] = $this->theme->theme_name;
        return $this->load->view('fw_signature', $data, TRUE);
    }

    public function end_ob() {
        $this->_is_end = TRUE;
        $this->_buffer = ob_get_clean();
        $this->apply_filters();
        echo $this->_buffer;
    }
}