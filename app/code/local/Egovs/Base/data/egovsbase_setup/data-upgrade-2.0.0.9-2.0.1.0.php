<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$line_break = "\n";
$default_id = 'footer_links';
$found = false;

// Bei der Installation den Magento-Default ersetzen
$footer_magento_eng = '    <li><a href="{{store direct_url="about-magento-demo-store"}}">About Us</a></li>';

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

$installer = $this;
$installer->startSetup();

/** @var $blocks  Mage_Cms_Model_Resource_Block_Collection */
$blocks = Mage::getModel('cms/block')->getCollection();

foreach($blocks AS $block) {
    $lowerId = strtolower( $block->getIdentifier() );

    if( $lowerId == $default_id ) {
        $found = true;

        $content_array = explode( $line_break, $block->getContent() );
        $new_content_array = array();

        if ( $content_array[0] != $footer_links_start[0] ) {
            $new_content_array = array_merge($footer_links_start, $content_array, $footer_links_ende);
        }
        
        if ( count($content_array) >= 3 ) {
            if ( $content_array[2] == $footer_magento_eng ) {
                $new_content_array = array_merge($footer_links_start, $footer_links_default, $footer_links_ende);
            }
        }
        
        if ( count($new_content_array) ) {
            $store_ids = $block->getResource()->lookupStoreIds($block->getBlockId());
            $block->setContent(implode($line_break, $new_content_array))->setStores($store_ids)->save();
        }
    }
}

if ( $found === false ) {
    $content_array = array_merge($footer_links_start, $footer_links_default, $footer_links_ende);
    
    $cmsBlock = array(
        'title'           => 'Footer Links',
        'identifier'      => $default_id,
        'content'         => implode($line_break, $content_array),
        'is_active'       => 1,
        'replace_content' => 0,
        'stores'          => 0,
    );

    Mage::getModel('cms/block')->setData($cmsBlock)->setStores(array(0))->save();
}

$installer->endSetup();
