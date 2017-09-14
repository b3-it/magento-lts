<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$footer_links_neu = array(
    '<div class="links">',
    '   <div class="block-title"><strong><span>Links</span></strong></div>',
    '   <ul>',
    '       <li><a href="{{store url="impressum"}}">Impressum</a></li>',
    '       <li><a href="{{store url="agb"}}">AGB</a></li>',
    '       <li><a href="{{store url="datenschutz"}}">Datenschutz</a></li>',
    '       <li><a href="{{store url="zahlung"}}">Zahlungsarten</a></li>',
    '       <li><a href="{{store url="lieferung"}}">Versandkosten</a></li>',
    '       <li><a href="{{store url="bestellung"}}">Bestellvorgang</a></li>',
    '       <li><a href="{{store url="widerruf"}}">Widerrufsrecht</a></li>',
    '       <li class="last"><a href="{{media url=\'widerrufsformular.pdf\'}}" target="_blank">Widerrufsformular</a></li>',
    '   </ul>',
    '</div>',
);

// Statische Blöcke bearbeiten
$replace = array(
    'Justizvollzugsanstalt Zeithain'      => '{{block type="imprint/field" value="company_first"}}',
    'Industriestra&szlig;e E2'            => '{{block type="imprint/field" value="street"}}',
    'Industriestra&szlig;e E 2'           => '{{block type="imprint/field" value="street"}}',
    'Industriestrasse E2'                 => '{{block type="imprint/field" value="street"}}',
    'Industriestrasse E 2'                => '{{block type="imprint/field" value="street"}}',
    '01612 Glaubitz'                      => '{{block type="imprint/field" value="zip"}} {{block type="imprint/field" value="city"}}',
    'gitterladen@jvazh.justiz.sachsen.de' => '{{block type="imprint/field" value="email"}}',
    '03525516114'                         => '{{block type="imprint/field" value="telephone"}}',
    '03525/516114'                        => '{{block type="imprint/field" value="telephone"}}',
    '03525 516114'                        => '{{block type="imprint/field" value="telephone"}}',
    '03525 516-114'                       => '{{block type="imprint/field" value="telephone"}}',
    '03525516133'                         => '{{block type="imprint/field" value="fax"}}',
    '03525/516133'                        => '{{block type="imprint/field" value="fax"}}',
    '03525 516133'                        => '{{block type="imprint/field" value="fax"}}',
    '03525 516-133'                       => '{{block type="imprint/field" value="fax"}}',
);

$block_arr = Mage::getModel('cms/block')->getCollection();

foreach($block_arr AS $block) {
    $id  = $block->getBlockId();
    $old = $block->getContent();
    $new = str_replace(array_keys($replace), array_values($replace), $old);
    
    if ($id == 8 ) {
        $model = Mage::getModel('cms/block')->load($id);
        $model->setContent(implode("\n", $footer_links_neu))->save();
    }
    else {
        if ( $old != $new ) {
            $model = Mage::getModel('cms/block')->load($id);
            $model->setContent($new)->save();
        }
    }
}

$installer->endSetup();
