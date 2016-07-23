<?php
$service_option = array(
    'name' => 'Newsletter service',
    'desc' => 'Please select the newsletter service you would like to use.',
    'id' => TF_THEME_PREFIX . '_newsletter_service',
    'value' => $newsletter_service,
    'type' => 'select',
    'options' => array(
        'none' => 'Disabled',
        'mailchimp' => 'MailChimp',
        'campaignmonitor' => 'CampaignMonitor'
    )
);
$api_option_campaignmonitor = array(
    'name' => '',
    'desc' => '',
    'id' => 'tfuse_campaignmonitor_api_key',
    'value' => $cm_key,
    'type' => 'text',
    'properties' => array(
        'style' => 'width:260px'
    )
);
$api_option_mailchimp = array(
    'name' => '',
    'desc' => '',
    'id' => 'tfuse_mailchimp_api_key',
    'value' => $mc_key,
    'type' => 'text',
    'properties' => array(
        'style' => 'width:260px'
    )
);
?>
<h3>Newsletter</h3>
Choose your preferred newsletter service:
<?php
echo $this->optigen->_auto($service_option);
?>
&nbsp&nbsp
<a id="tfuse_newsletter_save_api_key" class="button">Save</a>
<br /><br />
<span class="newsletter_apikey_holder mailchimp_apikey">
    MailChimp API key: 
    <?php
    echo $this->optigen->{$api_option_mailchimp['type']}($api_option_mailchimp);
    ?> 
</span>
<span class="newsletter_apikey_holder campaignmonitor_apikey">
    CampaignMonitor API key: 
    <?php
    echo $this->optigen->{$api_option_campaignmonitor['type']}($api_option_campaignmonitor);
    ?> 
</span>
