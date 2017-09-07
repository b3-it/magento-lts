<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$footer_links_neu = array(
    '<div class="links">',
    '<div class="block-title"><strong><span>Links</span></strong></div>',
    '<ul>',
    '<li><a href="{{store url="impressum"}}">Impressum</a></li>',
    '<li><a href="{{store url="agb"}}">AGB</a></li>',
    '<li><a href="{{store url="datenschutz"}}">Datenschutz</a></li>',
    '<li><a href="{{store url="zahlung"}}">Zahlungsarten</a></li>',
    '<li><a href="{{store url="lieferung"}}">Versandkosten</a></li>',
    '<li><a href="{{store url="bestellung"}}">Bestellvorgang</a></li>',
    '<li><a href="{{store url="widerruf"}}">Widerrufsrecht</a></li>',
    '<li class="last"><a href="{{media url=\'widerrufsformular.pdf\'}}" target="_blank">Widerrufsformular</a></li>',
    '</ul>',
    '</div>',
);

$model = Mage::getModel('cms/block')->load('footer_links');
$model->setContent(implode("\n", $footer_links_neu))->save();

$installer->endSetup();
