<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$line_break = "\n";
$found = false;

$footer_links_start = array(
    '<div class="links">',
    '   <div class="block-title"><strong><span>Links</span></strong></div>',
);
$footer_links_default = array(
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
);
$footer_links_ende = array(
    '</div>',
);

/** @var $blocks  Mage_Cms_Model_Resource_Block_Collection */
$blocks = Mage::getModel('cms/block')->getCollection();

foreach($blocks AS $block) {
    if( $block->getIdentifier() == 'footer_links' ) {
        $found = true;

        $content_array = explode( $line_break, $block->getContent() );
        $store_ids = $block->getResource()->lookupStoreIds($block->getBlockId());

        if ( $content_array[0] != $footer_links_start[0] ) {
            $content_array = array_merge($footer_links_start, $content_array, $footer_links_ende);

            $block->setContent(implode($line_break, $content_array))->setStores($store_ids)->save();
        }
    }
}

if ( $found === false ) {
    $content_array = array_merge($footer_links_start, $footer_links_default, $footer_links_ende);
    
    $cmsBlock = array(
        'title'         => 'Footer Links',
        'identifier'    => 'footer_links',
        'content'       => implode($line_break, $content_array),
        'is_active'     => 1
    );

    Mage::getModel('cms/block')->setData($cmsBlock)->setStores(array(0))->save();
}

$installer->endSetup();
