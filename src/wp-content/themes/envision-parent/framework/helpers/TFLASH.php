<?php

/**
 * Allow to set flash messages
 **
 * Stored in session and shown between refreshes and redirects
 */
class TFLASH
{
    protected static $instance  = null;

    const INFO     = 0;
    const ERROR    = 1;
    const SUCCESS  = 2;

    protected static $framework         = null; // framework
    protected static $availableTypes    = array('info', 'error', 'success');
    protected static $sessionKey        = 'tf_flash_messages';

    public function __construct()
    {
        if (self::$instance !== null)
            return;
        else
            self::$instance =& $this;

        global $TFUSE;

        self::$framework =& $TFUSE;

        add_filter('the_content', array($this, '_print_messages_frontEnd'));
        add_action('admin_notices', array($this, '_print_messages_backEnd'));
    }

    protected static function getMessages()
    {
        $messages = self::$framework->session->get(self::$sessionKey);

        if (!is_array($messages)) {
            $messages = array_fill_keys(self::$availableTypes, array());
        }

        return $messages;
    }

    protected static function setMessages($messages)
    {
        self::$framework->session->set(self::$sessionKey, $messages);
    }

    /**
     * Add flash message
     **
     * @param string $message    Message (can be html)
     * @param    int $type       Type of the message (info, error, success)
     * @param string $id         Prevent multiply same message
     * @param   bool $visibility Null - No restrictions, True - Only BackEnd, False - Only FrontEnd
     **
     * Examples:
     *
     * TFLASH::add('Success message', TFLASH::SUCCESS);
     * TFLASH::add('Error message', TFLASH::ERROR);
     * TFLASH::add('Info message', TFLASH::INFO);
     */
    public static function add($message, $type = TFLASH::INFO, $id = null, $visibility = null)
    {
        if ($type === TFLASH::INFO)
            $type = 'info';
        elseif ($type === TFLASH::ERROR)
            $type = 'error';
        elseif ($type === TFLASH::SUCCESS)
            $type = 'success';
        else {
            trigger_error('Invalid flash message type', E_USER_ERROR);
            $type = 'info';
        }

        if ($visibility !== null)
            $visibility = (bool)$visibility;

        $messages = self::getMessages();

        if ($id !== null)
            $messages[$type][$id] = array(
                'message'    => $message,
                'visibility' => $visibility
            );
        else
            $messages[$type][] = array(
                'message'    => $message,
                'visibility' => $visibility
            );

        self::setMessages($messages);
    }

    public function _print_messages_frontEnd($content)
    {
        $info    = '';
        $error   = '';
        $success = '';

        $allMessages = self::getMessages();
        foreach ($allMessages as $type => $messages) {
            if (!empty($messages)) {
                $$type = '';

                foreach ($messages as $id => $data) {
                    if (!($data['visibility'] === null || $data['visibility'] === false))
                        continue;

                    $message = $data['message'];

                    $$type .= apply_filters('tflash_frontend_message_html', '<div class="tf-flash-message"><p>'. nl2br($message) .'</p></div>', array(
                        'type'      => $type,
                        'message'   => $message,
                        'id'        => $id
                    ));

                    unset($allMessages[$type][$id]);
                }

                $$type = '<div class="tf-flash-type-'.$type.'">'.$$type.'</div>';
            }
        }

        $content = '<div class="tf-flash-messages">'. $success . $error . $info .'</div>'. $content;

        self::setMessages($allMessages);

        return $content;
    }

    public function _print_messages_backEnd()
    {
        $info    = '';
        $error   = '';
        $success = '';

        $allMessages = self::getMessages();
        foreach ($allMessages as $type => $messages) {
            if (!empty($messages)) {
                $$type = '';

                foreach ($messages as $id => $data) {
                    if (!($data['visibility'] === null || $data['visibility'] === true))
                        continue;

                    $message = $data['message'];

                    $$type .= '<div class="'. ($type == 'error' ? 'error' : 'updated') .' tf-flash-message"><p>'.$message.'</p></div>';

                    unset($allMessages[$type][$id]);
                }

                $$type = '<div class="tf-flash-type-'.$type.'">'.$$type.'</div>';
            }
        }

        echo '<div class="tf-flash-messages">'. $success . $error . $info .'</div>';

        self::setMessages($allMessages);
    }
}

new TFLASH();

/**
 * Easier alternative to TFLASH::add()
 **
 * @param string $message    Message (can be html)
 * @param string $type       Type of the message (info, error, success)
 * @param string $id         Prevent multiply same message
 * @param   bool $visibility Null - No restrictions, True - Only BackEnd, False - Only FrontEnd
 */
function tflash($message, $type = 'info', $id = null, $visibility = null) {
    switch ($type) {
        case 'info':
            $type = TFLASH::INFO;
            break;
        case 'success':
            $type = TFLASH::SUCCESS;
            break;
        case 'error':
            $type = TFLASH::ERROR;
            break;
        default:
            trigger_error('Invalid TFLASH message type "'.$type.'" (allowed: info, success, error)', E_USER_WARNING);
            $type = 'info';
    }

    TFLASH::add($message, $type, $id, $visibility);
}