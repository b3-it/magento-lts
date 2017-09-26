<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$tab = "\t";

$text1 = "<style type=\"text/css\">\n        tr.summary-details td {font-size: 10px; color: #626465; }\n</style>";
$text2 = "<style type=\"text/css\">\n" . $tab .
         "body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }\n" . $tab .
         "a { color:#1E7EC8; }\n</style>";
$text3 = "<style type=\"text/css\">\n    body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }\n</style>";

$text4 = '<td valign="top"><a href="{{store url=""}}"><img src="{{skin url="images/sabre_logo_14_mail.png" _area=\'\'frontend\'\'}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a></td>';
$text5 = '<td valign="top"><a href="{{store url=""}}"><img src="{{skin url="images/logo_email.gif" _area=\'\'frontend\'\'}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a></td>';
$text6 = "<td valign=\"top\">
  <a href=\"{{store url=\"\"}}\">
    <img {{if logo_width}}width=\"{{var logo_width}}\" {{else}}width=\"165\"{{/if}} {{if logo_height}}height=\"{{var logo_height}}\" {{else}}height=\"48\"{{/if}} src=\"{{var logo_url}}\" alt=\"{{var logo_alt}}\" border=\"0\"/>
  </a>
</td>";

$header = '{{template config_path="design/email/header"}}';
$footer = '{{template config_path="design/email/footer"}}';

$replace = array(
    // Header
    '<html>'  => '<style type="text/css">',   // "Mogeln", damit der Header sauber eingebunden wird :) [siehe Template 41]
    $text1    => $header,
    $text2    => $header,
    $text3    => $header,
    // Footer
    '</html>' => '',                          // Löschen, damit der Footer nicht doppelt ist
    $text4    => $text6,
    $text5    => $text6
);

/* @var $mailSetup Egovs_Base_Helper_Emailsetup_Data */
$mailSetup = Mage::helper('egovsbase_emailsetup');
$mailSetup->replaceEmailTemplateContent($replace, $header, $footer, 4);

$installer->endSetup();