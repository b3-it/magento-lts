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

$email_arr = Mage::getModel('core/email_template')->getCollection();
foreach($email_arr AS $email) {
    $id  = $email->getTemplateId();
    $old = $email->getTemplateText();
    $new = str_replace(array_keys($replace), array_values($replace), $old);
    
    // Prüfen, ob der Header in allen Templates eingefügt ist
    $arr = explode("\n", trim($old));
    if ( $arr[0] != $header ) {
        $new = $header . "\n" . $new;
    }
    
    if ( $old != $new ) {
        $new .= "\n" . $footer;

        $model = Mage::getModel('core/email_template')->load($id);
        $model->setData('template_text', $new)->save();
    }
}

$installer->endSetup();