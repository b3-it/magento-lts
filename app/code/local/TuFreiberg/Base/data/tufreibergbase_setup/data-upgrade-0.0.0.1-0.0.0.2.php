<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

$text1 = "<style type=\"text/css\">\n        tr.summary-details td {font-size: 10px; color: #626465; }\n</style>";

$text2 = '<td valign="top"><a href="{{store url=""}}"><img src="{{skin url="images/logo_email.gif" _area=\'\'frontend\'\'}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a></td>';
$text3 = "<td valign=\"top\">
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
    $text2 => $text3,

    // Template-Code bereinigen
    '{{store url=""}}'                             => "{{store url=''}}",
    '{{store url="customer/account/"}}'            => "{{store url='customer/account/'}}",
    '{{block type="imprint/field" value="email"}}' => "{{block type='imprint/field' value='email'}}"
);

/* @var $mailSetup Egovs_Base_Helper_Emailsetup_Data */
$mailSetup = Mage::helper('egovsbase_emailsetup');
$mailSetup->replaceEmailTemplateContent($replace, $header, $footer, 0);

$installer->endSetup();