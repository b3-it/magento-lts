<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$text1 = "<style type=\"text/css\">\n        tr.summary-details td {font-size: 10px; color: #626465; }\n</style>";

$text2 = '<td valign="top"><a href="{{store url=""}}"><img src="{{skin url="images/logo_email.gif" _area=\'\'frontend\'\'}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a></td>';
$text3 = "<td valign=\"top\">
  <a href=\"{{store url=\"\"}}\">
    <img {{if logo_width}}width=\"{{var logo_width}}\" {{else}}width=\"165\"{{/if}} {{if logo_height}}height=\"{{var logo_height}}\" {{else}}height=\"48\"{{/if}} src=\"{{var logo_url}}\" alt=\"{{var logo_alt}}\" border=\"0\"/>
  </a>
</td>";

$header = '{{template config_path="design/email/header"}}';
$footer = '{{template config_path="design/email/footer"}}';

$replace = array(
    $text1 => $header,
    $text2 => $text3
);

/* @var $mailSetup Egovs_Base_Helper_Emailsetup_Data */
$mailSetup = Mage::helper('egovsbase_emailsetup');
$mailSetup->replaceEmailTemplateContent($replace, $header, $footer, 0);

$installer->endSetup();