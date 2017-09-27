<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;
$installer->startSetup();

// {{block type="cms/block" block_id="sym_agb"}}
// {{block type="cms/block" block_id="sym_widerruf"}}

$block_address = '<p>{{block type="imprint/field" value="company_first"}}<br />' .
                 '{{block type="imprint/field" value="company_second"}}<br />' .
                 '{{block type="imprint/field" value="street"}}<br />' .
                 '{{block type="imprint/field" value="zip"}} {{block type="imprint/field" value="city"}}</p>';

$block_comm = '<p>Telefon: {{block type="imprint/field" value="telephone"}}<br />' .
              'Fax: {{block type="imprint/field" value="fax"}}<br />' .
              'Web: {{block type="imprint/field" value="web"}}<br />' .
              'E-Mail: <a href="mailto:{{block type="imprint/field" value="email"}}">{{block type="imprint/field" value="email"}}</a><br />' .
              '</p>';

$block_legal = '<p>Geschäftsführer: {{block type="imprint/field" value="ceo"}}<br />' .
               'Registergericht: {{block type="imprint/field" value="court"}}<br />' .
               'Register Nummer: {{block type="imprint/field" value="register_number"}}<br />' .
               'Verweis auf berufliche Regelungen (z.B. für Ärzte, Apotheker):<div>{{block type="imprint/field" value="business_rules"}}</div>' .
               '</p>'; 

$block_bank = '<p>Kontoinhaber: {{block type="imprint/field" value="bank_account_owner"}}<br />' .
              'Kreditinstitut: {{block type="imprint/field" value="bank_name"}}<br />' .
              'SWIFT: {{block type="imprint/field" value="swift"}}<br />' .
              'IBAN: {{block type="imprint/field" value="iban"}}</p>';

$block_tax = '<p>Finanzamt: {{block type="imprint/field" value="financial_office"}}<br />' .
             'Steuernummer: {{block type="imprint/field" value="tax_number"}}<br />' .
             'USt.Nr.: {{block type="imprint/field" value="vat_id"}}<br />' .
             '</p>';

$symmetrics = array(
    // Warum auch immer das enthalten ist
    'https://www.shop.sachsen.de/stala/index.php/customer/account/login/' => '{{config path="web/secure/base_url"}}customer/account/login/',

    // vordefinierte Blöcke
    '{{block type="symmetrics_impressum/impressum" value="address"}}'       => $block_address,
    '{{block type="symmetrics_impressum/impressum" value="communication"}}' => $block_comm,
    '{{block type="symmetrics_impressum/impressum" value="legal"}}'         => $block_legal,
    '{{block type="symmetrics_impressum/impressum" value="bank"}}'          => $block_bank,
    '{{block type="symmetrics_impressum/impressum" value="tax"}}'           => $block_tax,

    // Spezielle Fälle
    '{{block type="symmetrics_impressum/impressum" value="shopname"}}'         => '{{block type="imprint/field" value="shop_name"}}',
    '{{block type="symmetrics_impressum/impressum" value="company1"}}'         => '{{block type="imprint/field" value="company_first"}}',
    '{{block type="symmetrics_impressum/impressum" value="company2"}}'         => '{{block type="imprint/field" value="company_second"}}',
    '{{block type="symmetrics_impressum/impressum" value="taxnumber"}}'        => '{{block type="imprint/field" value="tax_number"}}',
    '{{block type="symmetrics_impressum/impressum" value="vatid"}}'            => '{{block type="imprint/field" value="vat_id"}}',
    '{{block type="symmetrics_impressum/impressum" value="taxoffice"}}'        => '{{block type="imprint/field" value="financial_office"}}',
    '{{block type="symmetrics_impressum/impressum" value="hrb"}}'              => '{{block type="imprint/field" value="register_number"}}',
    '{{block type="symmetrics_impressum/impressum" value="bankaccountowner"}}' => '{{block type="imprint/field" value="bank_account_owner"}}',
    '{{block type="symmetrics_impressum/impressum" value="bankaccount"}}'      => '{{block type="imprint/field" value="bank_account"}}',
    '{{block type="symmetrics_impressum/impressum" value="bankcodenumber"}}'   => '{{block type="imprint/field" value="bank_code_number"}}',
    '{{block type="symmetrics_impressum/impressum" value="bankname"}}'         => '{{block type="imprint/field" value="bank_name"}}',

    // Default
    'type="symmetrics_impressum/impressum"' => 'type="imprint/field"',
);

$cms_arr = Mage::getModel('cms/page')->getCollection();

foreach($cms_arr AS $page) {
    $id  = $page->getPageId();
    $old = $page->getContent();
    $new = str_replace(array_keys($symmetrics), array_values($symmetrics), $old);

    if ( $old != $new ) {
        $model = Mage::getModel('cms/page')->load($id);
        $model->setContent($new)->save();
    }
}

$email_tpl = Mage::getModel('core/email_template')->getCollection();

foreach($email_tpl AS $tpl) {
    $id       = $tpl->getTemplateId();
    $old_text = $tpl->getTemplateText();
    $new_text = str_replace(array_keys($symmetrics), array_values($symmetrics), $old_text);
    
    $new_text = str_replace(' style="font:9px/1em Verdana, Arial, Helvetica, sans-serif;"', '', $new_text);
    $new_text = preg_replace('/<!--(.*)-->/Uis', '', $new_text);
    
    if ($old_text != $new_text) {
        $model = Mage::getModel('core/email_template')->load($id);
        $model->setTemplateText($new_text)->save();
    }
    
    $old_title = $tpl->getTemplateSubject();
    $new_title = str_replace(array_keys($symmetrics), array_values($symmetrics), $old_title);
    
    if ($old_title != $new_title) {
        $model = Mage::getModel('core/email_template')->load($id);
        $model->setTemplateSubject($new_title)->save();
    }
}

$installer->endSetup();
