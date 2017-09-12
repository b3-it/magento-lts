<?php

/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

// alle Seiten-Layouts zurücksetzen
$_cmsTable = $installer->getTable('cms/page');
if ($installer->tableExists($_cmsTable))
{
    $installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'two_columns_right';");
    $installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'three_columns';");
}

// alle Kategorie-Layouts zurücksetzen
$installer->run("UPDATE `catalog_category_entity_varchar` SET `value` = 'two_columns_left' WHERE `value` = 'three_columns'");
$installer->run("UPDATE `catalog_category_entity_varchar` SET `value` = 'two_columns_left' WHERE `value` = 'two_columns_right'");

// Inpressums-Daten komplettieren
$installer->setConfigData('general/imprint/company_second', 'Technischen Universität Chemnitz');

// Logo-Grafiken setzen
$installer->setConfigData('design/header/logo_src', 'images/logo_sachsen.png');
$installer->setConfigData('design/header/logo_src_small', 'images/logo_sachsen_smartphone.png');

// Theme-Einstellungen zurücksetzen
$installer->setConfigData('design/theme/locale', '');
$installer->setConfigData('design/theme/template', '');
$installer->setConfigData('design/theme/skin', '');
$installer->setConfigData('design/theme/layout', '');
$installer->setConfigData('design/theme/default', '');

$replace_url = array(
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/agb'         => '{{store url="agb"}}',
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/widerruf'    => '{{store url="widerruf"}}',
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/datenschutz' => '{{store url="datenschutz"}}',
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/zahlarten'   => '{{store url="zahlarten"}}',
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/impressum'   => '{{store url="impressum"}}',
);

$replace_string = array(
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut' => '{{store url=""}}',
    'PaperCut-Shop TU Chemnitz'                           => '{{block type="imprint/field" value="shop_name"}}',
    'Stra&szlig;e der Nationen 62'                        => '{{block type="imprint/field" value="street"}}',
    '09111 Chemnitz'                                      => '{{block type="imprint/field" value="zip"}} {{block type="imprint/field" value="city"}}',
    '+49 (0) 371 531-13400'                               => '{{block type="imprint/field" value="telephone"}}',
    '+49 (0) 371 531-13409'                               => '{{block type="imprint/field" value="fax"}}',
    'drucken@hrz.tu-chemnitz.de'                          => '{{block type="imprint/field" value="email"}}',
    'Finanzamt Chemnitz-Mitte'                            => '{{block type="imprint/field" value="financial_office"}}',
    'Amtsgericht Chemnitz'                                => '{{block type="imprint/field" value="court"}}',
    'Rektorat der Technischen Universit&auml;t Chemnitz'  => '{{block type="imprint/field" value="ceo"}}',
    'Technische Universit&auml;t Chemnitz'                => '{{block type="imprint/field" value="company_second"}}',
    'De 140857609'                                        => '{{block type="imprint/field" value="vat_id"}}',
    'DE 140857609'                                        => '{{block type="imprint/field" value="vat_id"}}',
);


// Footer-Links reparieren
/** @var $block_arr  Mage_Cms_Model_Resource_Block_Collection */
$block_arr = Mage::getModel('cms/block')->getCollection();
foreach($block_arr AS $block) {
    $id  = $block->getBlockId();
    $old = $block->getContent();

    $new = str_replace(array_keys($replace_url), array_values($replace_url), $old);
    $new = str_replace(array_keys($replace_string), array_values($replace_string), $new);
    $new = preg_replace('/<!--(.*)-->/Uis', '', $new);
    
    if ( $old != $new ) {
        $store_ids = $block->getResource()->lookupStoreIds($block->getBlockId());
        
        $model = Mage::getModel('cms/block')->load($id);
        $model->setContent($new)->setStores($store_ids)->save();
    }
}

// CMS-Seiten
/** @var $page_arr  Mage_Cms_Model_Resource_Page_Collection */
$page_arr = Mage::getModel('cms/page')->getCollection();
foreach($page_arr AS $page) {
    $id  = $page->getPageId();
    $old = $page->getContent();
    
    $new = str_replace(array_keys($replace_url), array_values($replace_url), $old);
    $new = str_replace(array_keys($replace_string), array_values($replace_string), $new);
    $new = preg_replace('/<!--(.*)-->/Uis', '', $new);
    
    if ( $old != $new ) {
        $store_ids = $page->getResource()->lookupStoreIds($page->getPageId());
        
        $model = Mage::getModel('cms/page')->load($id);
        $model->setContent($new)->setStores($store_ids)->save();
    }
}

$installer->endSetup();