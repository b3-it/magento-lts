<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$tab = "\t";

$text1 = "<style type=\"text/css\">\n        tr.summary-details td {font-size: 10px; color: #626465; }\n</style>";
$text2 = "<style type=\"text/css\">\n" . $tab .
         "body,td { color:#2f2f2f; font:11px/1.35em Verdana, Arial, Helvetica, sans-serif; }\n" . $tab .
         "a { color:#1E7EC8; }\n</style>";

$text3 = '<td valign="top"><a href="{{store url=""}}"><img src="{{skin url="images/sabre_logo_14_mail.png" _area=\'\'frontend\'\'}}" alt="{{block type="imprint/field" value="shop_name"}}"  style="margin-bottom:10px;" border="0"/></a></td>';
$text4 = "<td valign=\"top\">
  <a href=\"{{store url=\"\"}}\">
    <img {{if logo_width}}width=\"{{var logo_width}}\" {{else}}width=\"165\"{{/if}} {{if logo_height}}height=\"{{var logo_height}}\" {{else}}height=\"48\"{{/if}} src=\"{{var logo_url}}\" alt=\"{{var logo_alt}}\" border=\"0\"/>
  </a>
</td>";

$header = '{{template config_path="design/email/header"}}';
$footer = '{{template config_path="design/email/footer"}}';

$replace = array(
    $text1 => $header,
    $text2 => $header,
    $text3 => $text4
);

$email_arr = Mage::getModel('core/email_template')->getCollection();
foreach($email_arr AS $email) {
    $code = $email->getTemplateCode();

    if ( ($code == 'eMail-Header') OR ($code == 'eMail-Footer') ) {
        // nicht in sich selbst eintragen
        continue;
    }

    $id  = $email->getTemplateId();
    $old = $email->getTemplateText();
    $new = str_replace(array_keys($replace), array_values($replace), $old);

    // Prüfen, ob der Header in allen Templates eingefügt ist
    $arr = explode("\n", trim($old));
    // falls der Tablulator im Template wird nicht erkannt
    if ( ($arr[0] == '<style type="text/css">') AND ($arr[3] == '</style>') ) {
        unset($arr[0], $arr[1], $arr[2], $arr[3]);
    }

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