<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

// ScopeID für Ticketshop ermitteln
//$scopeId = Mage::getModel('core/store')->load('papercut', 'code')->getWebsiteId();

// eMail-Einstellungen anpassen
$text1 = "<style type=\"text/css\">\n        tr.summary-details td {font-size: 10px; color: #626465; }\n</style>";

$text2 = '<td valign="top"><a href="{{store url=""}}"><img src="{{skin url="images/logo_email.gif" _area=\'\'frontend\'\'}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a></td>';
$text3 = '<td valign="top"><a href="{{store url=""}}" style="color:#1E7EC8;"><img src="{{skin url="images/logo_mail_papercut.jpg" _area=\'frontend\'}}" alt="{{var store.getFrontendName()}}" border="0"/></a></td>';
$text4 = "<td valign=\"top\">\n                                <a href=\"{{store url=\"\"}}\" style=\"color:#1E7EC8;\"><img src=\"{{skin url=\"images/logo_mail_papercut.jpg\" _area='frontend'}}\" alt=\"{{var store.getFrontendName()}}\" border=\"0\"/></a>\n                            </td>";
$text5 = "<td valign=\"top\" align=\"right\" style=\"margin-bottom:15px:\">
  <a href=\"{{store url=''}}\">
    <img width=\"{{if logo_width}}{{var logo_width}}{{else}}165{{/if}}\"
		 height=\"{{if logo_height}}{{var logo_height}}{{else}}48{{/if}}\"
		 src=\"{{var logo_url}}\"
		 alt=\"{{var logo_alt}}\"
		 border=\"0\" />
  </a>
</td>";

$header = '{{template config_path="design/email/header"}}';
$footer = '{{template config_path="design/email/footer"}}';

$replace = array(
    $text1 => $header,
    $text2 => $text5,
    $text3 => $text5,
    $text4 => $text5,

    // Template-Code bereinigen
    '{{store url=""}}'                             => "{{store url=''}}",
    '{{store url="customer/account/"}}'            => "{{store url='customer/account/'}}",
    '{{block type="imprint/field" value="email"}}' => "{{block type='imprint/field' value='email'}}",

    '<body style="background:#F6F6F6; font-family:Arial, Helvetica, Verdana, sans-serif; font-size:12px; margin:0; padding:0;">' => '',
    '</body>' => '',
    'cellspacing="0" cellpadding="0" border="0" height="100%" width="100%"' => 'style="width:100%;"',
    'cellspacing="0" cellpadding="0" border="0" width="650"' => 'style="width:650px;"'
);

$email_logos = array(
    0 => array(
        'scope'       => 'default',
        'scope_id'    => '0',
        'default'     => 'logo_email_chemnitz.png',
        'data'        => array(
            'logo'        => 'logo_email_chemnitz_default.png',
            'logo_alt'    => 'Logo TU Chemnitz',
            'logo_width'  => '240',
            'logo_height' => '122',
        )
    ),
);

$email_templates = array(
    0 => array(
        'template' => 'header.htm',
        'name'     => 'eMail-Header',
        'topic'    => 'Email - Kopfzeile',
        'path'     => 'design/email/header'
    ),
    1 => array(
        'template' => 'support.htm',
        'name'     => 'eMail-Support',
        'topic'    => 'E-Mail - Support',
        'path'     => 'design/email/support'
    ),
    2 => array(
        'template' => 'footer.htm',
        'name'     => 'eMail-Footer',
        'topic'    => 'E-Mail - Fußzeile',
        'path'     => 'design/email/footer'
    ),
);

/* @var $mailSetup Egovs_Base_Helper_Emailsetup_Data */
$mailSetup = Mage::helper('egovsbase_emailsetup');

$mailSetup->replaceEmailTemplateContent($replace, $header, $footer, 3);
$mailSetup->setEmailConfig($email_logos, implode(DS, array('chemnitz', 'default', 'email', 'images')), $installer);
$mailSetup->setEmailTemplates($email_templates, implode(DS, array('chemnitz', 'default', 'email', 'templates')), $installer);

$installer->endSetup();