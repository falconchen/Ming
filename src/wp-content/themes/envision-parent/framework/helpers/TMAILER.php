<?php
class TFUSE_MAILER{

    static $instance = NULL;

    public static function getInstance(){

        if(self::$instance == NULL)
            self::$instance = new self();
         return self::$instance;
    }

    public function __construct(){
        $this->add_actions();
    }

    private function add_actions(){

        add_action('tf_mailer_send_mail',array($this,'sendMail'),10,3);
    }


    function sendSmtp($email_to,$message,Array $from = array())
    {
        require_once ABSPATH.WPINC . '/class-phpmailer.php';
        $mail = new PHPMailer();
        $mail->isSMTP();
        $mail->IsHTML(true);
        $mail->Port = tfuse_options('general_smtp_port');
        $mail->Host = tfuse_options('general_smtp_host');
        $mail->SMTPAuth = TRUE;
        $mail->SMTPDebug = 2;
        $mail->SMTPSecure = (tfuse_options('general_secure_connection') != 'no') ? tfuse_options('general_secure_connection') : NULL;
        $mail->Username = tfuse_options('general_smtp_username');
        $mail->Password = tfuse_options('general_smtp_password');
        $mail->From = isset($from['email_from']) ? $from['email_from'] : tfuse_options('general_mailfrom_address');
        $mail->FromName = (isset($form['email_from_name']))?$from['email_from_name']:tfuse_options('general_mailfrom_name');
        $mail->Subject = $from['email_subject'];
        if($bcc_option = tfuse_options('general_message_bcc')){
            $bccs = explode(',',$bcc_option);
            foreach($bccs as $bcc)
            {
                $mail->AddBCC($bcc);
            }
        }
        if(is_array($email_to))
            foreach($email_to as $mail)
                $mail->AddAddress($mail);
        else
            $mail->AddAddress($email_to);

        $mail->Body = $message;
        if (!$mail->send()) {
            return array('mail'=>$email_to,'error' => true);
        } else {
            return array('mail'=>$email_to,'error' => false);
        }
        $mail->ClearAddresses();
        $mail->ClearAllRecipients();

    }
     function sendMail($email,$message,$form = array()){
        $mail_type=tfuse_options('general_mail_type')?'send'.ucwords(tfuse_options('general_mail_type')):'sendWpmail';
        return $this->$mail_type($email,$message,$form);
    }
    function sendWpmail($email,$message,$form)
    {
        $from_email = isset($from['email_from']) ? $from['email_from'] : tfuse_options('general_mailfrom_name');
        $from_name  = (isset($form['email_from_name']))?$from['email_from_name']:tfuse_options('general_mailfrom_name');
        $headers[]  = "From:" .$from_name . " <" . $from_email . ">";
        if($bcc_option = tfuse_options('general_message_bcc')){
            $bccs = explode(',',$bcc_option);
            foreach($bccs as $bcc)
            {
                $headers[]  = "BCC: <" . $bcc . ">";
            }
        }
        add_filter('wp_mail_content_type', create_function('', 'return "text/html";'));
        if (wp_mail($email, $form['email_subject'], $message, $headers))
            return array('mail'=>$email, 'error' => false);
        else
            return array('mail'=>$email, 'error' => true);
    }

}