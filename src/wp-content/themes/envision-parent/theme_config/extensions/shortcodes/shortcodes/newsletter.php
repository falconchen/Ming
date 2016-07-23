<?php

/**
 * Newsletter
 * 
 * To override this shortcode in a child theme, copy this file to your child theme's
 * theme_config/extensions/shortcodes/shortcodes/ folder.
 * 
 * Optional arguments:
 * title: e.g. Newsletter signup
 * text: e.g. Thank you for your subscribtion.
 * action: URL where to send the form data.
 * rss_feed:
 */

function tfuse_newsletter($atts, $content = null)
{
    global $TFUSE;

    extract(shortcode_atts(array('title' => '', 'text' => '', 'rss_feed' => ''), $atts));

    if ( empty($title) ) $title = __('Stay in touch with us!','tfuse');
    if ( empty($text) ) $text = __('Thank you for your subscription.','tfuse');

    $out = '
    <div class="newsletter_subscription_box newsletterBox">
    <div class="bg">
    <div class="ribbon"></div>
    <h2>'. $title . '</h2>';

    if ( $TFUSE->request->isset_POST('newsletter') && is_email($TFUSE->request->POST('newsletter')) )
        $out .= '<div class="before-text">' . $text . '</div>';
    else
    {
        $out .= '
        <div class="newsletter_subscription_messages before-text">
            <div class="newsletter_subscription_message_initial">' . $text . '</div>
            <div class="newsletter_subscription_message_success">' . __('Thank you for your subscribtion.','tfuse') . '</div>
            <div class="newsletter_subscription_message_wrong_email">' . __('Your email format is wrong!','tfuse') . '</div>
            <div class="newsletter_subscription_message_failed">' . __('Sad, but we couldn\'t add you to our mailing list ATM.','tfuse') . '</div>
        </div>

        ';
        $out .= '<form action="#" method="post" id="subscribe">';
        $out .= "<input type='text' value='".__('ENTER your email address', 'tfuse')."' name='newsletter' onFocus=\"if (this.value == '".__('ENTER your email address', 'tfuse')."') {this.value = '';}\" onBlur=\"if (this.value == '') {this.value = '".__('ENTER your email address', 'tfuse')."';}\" name='email' class='inputField newsletter_subscription_email' />";
        $out .= '<input type="submit" value="" name="" class="btn-submit newsletter_subscription_submit" />
        <div class="newsletter_text">';
        if ( !empty($rss_feed) )
        {
            $out .='<a href=" ';
            $out .= tfuse_options('feedburner_url', get_bloginfo_rss('rss2_url'));
            $out .= ''.'" class="link-news-rss" >'. __('You can also folow us','tfuse') .' <span>'. __('on RSS','tfuse') .'</span></a>';
        }
        $out .='</div></form><div class="newsletter_subscription_ajax">'.__('Loading...', 'tfuse').'</div>';
    }

    $out .= '</div>
    </div>';

    return $out;

}
$atts = array(
    'name' => 'Newsletter',
    'desc' => 'Here comes some lorem ipsum description for the box shortcode.',
    'category' => 11,
    'options' => array(
        array(
            'name' => 'Title',
            'desc' => 'Enter the title of the Newsletter form',
            'id' => 'tf_shc_newsletter_title',
            'value' => 'Newsletter signup',
            'type' => 'text'
        ),
        array(
            'name' => 'Rss Feed',
            'desc' => 'Enable rss feed.',
            'id' => 'tf_shc_newsletter_rss_feed',
            'value' => 'false',
            'type' => 'checkbox'
        ),
        array(
            'name' => 'Text',
            'desc' => 'Description of newsletter',
            'id' => 'tf_shc_newsletter_color',
            'value' => '',
            'type' => 'text'
        )
    )
);

tf_add_shortcode('newsletter', 'tfuse_newsletter', $atts);
