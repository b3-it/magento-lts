<?php
/** @var Mage_Core_Model_Resource_Setup $installer */
/** @var Mage_Eav_Model_Entity_Setup $this */
$installer = $this;

$installer->startSetup();

// alle Seiten-Layouts zurücksetzen
$_cmsTable = $installer->getTable('cms/page');
if ($installer->tableExists($_cmsTable)) {
    $installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'two_columns_right';");
    $installer->run("UPDATE `{$_cmsTable}` SET `root_template` = 'two_columns_left' WHERE `root_template` = 'three_columns';");
}

// alle Kategorie-Layouts zurücksetzen
$_catTable = $installer->getTable('catalog_category_entity_varchar');
$installer->run("UPDATE `{$_catTable}` SET `value` = 'two_columns_left' WHERE `value` = 'three_columns';");
$installer->run("UPDATE `{$_catTable}` SET `value` = 'two_columns_left' WHERE `value` = 'two_columns_right';");

// Inpressums-Daten komplettieren
$installer->setConfigData('general/imprint/company_second', 'Technischen Universität Chemnitz');

// Logo-Grafiken setzen
$installer->setConfigData('design/header/logo_src'      , 'images/logo_sachsen.png');
$installer->setConfigData('design/header/logo_src_small', 'images/logo_sachsen_smartphone.png');

// Theme-Einstellungen zurücksetzen
$installer->setConfigData('design/theme/locale'  , '');
$installer->setConfigData('design/theme/template', '');
$installer->setConfigData('design/theme/skin'    , '');
$installer->setConfigData('design/theme/layout'  , '');
$installer->setConfigData('design/theme/default' , '');

// Kreditkarte per Girosolution
$installer->setConfigData('payment/egovs_girosolution_creditcard/active'     , '1');
$installer->setConfigData('payment/egovs_girosolution_creditcard/merchant_id', 'Llu4kPuVeJE=');
$installer->setConfigData('payment/egovs_girosolution_creditcard/project_id' , '5HdbQm+marg=');
$installer->setConfigData('payment/egovs_girosolution_creditcard/project_pwd', 'PxUlfKYeMp9qsS0PCnB42w==');
$installer->setConfigData('payment/egovs_girosolution_creditcard/description', 'Kreditkarte per Girosolution');

// Giropay per Girosolution
$installer->setConfigData('payment/egovs_girosolution_giropay/active'     , '1');
$installer->setConfigData('payment/egovs_girosolution_giropay/merchant_id', 'Llu4kPuVeJE=');
$installer->setConfigData('payment/egovs_girosolution_giropay/project_id' , 'SdIrju6FFRs=');
$installer->setConfigData('payment/egovs_girosolution_giropay/project_pwd', 'PxUlfKYeMp9qsS0PCnB42w==');
$installer->setConfigData('payment/egovs_girosolution_giropay/description', 'Giropay per Girosolution');


// ScopeID für Ticketshop ermitteln
$scopeId = Mage::getModel('core/store')->load('papercut', 'code')->getWebsiteId();

// Impressum für Ticketshop reparieren
$installer->setConfigData('general/imprint/telephone'    , '+49 (0) 371 531-10000'                      , 'websites', $scopeId);
$installer->setConfigData('general/imprint/fax'          , '+49 (0) 371 531-10009'                      , 'websites', $scopeId);
$installer->setConfigData('general/imprint/email'        , 'rektorsekretariat@verwaltung.tu-chemnitz.de', 'websites', $scopeId);
$installer->setConfigData('general/imprint/ceo'          , 'Prof. Dr. Gerd Strohmeier'                  , 'websites', $scopeId);
$installer->setConfigData('general/imprint/company_first', 'Rektorat der TU Chemnitz'                   , 'websites', $scopeId);

$replace_url = array(
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/agb'         => "{{store url='agb'}}",
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/widerruf'    => "{{store url='widerruf'}}",
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/datenschutz' => "{{store url='datenschutz'}}",
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/zahlarten'   => "{{store url='zahlarten'}}",
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut/impressum'   => "{{store url='impressum'}}",
);

$replace_string = array(
    // Ticketshop :: Papercut
    'https://www.shop.sachsen.de/tuc_ticketshop/papercut' => "{{store url=''}}",
    'www.shop.sachsen.de/tuc_ticketshop/papercut&nbsp;'   => "{{store url=''}}",
    'PaperCut-Shop TU Chemnitz'                           => "{{block type='imprint/field' value='shop_name'}}",
    'Stra&szlig;e der Nationen 62'                        => "{{block type='imprint/field' value='street'}}",
    '09111 Chemnitz'                                      => "{{block type='imprint/field' value='zip'}} {{block type='imprint/field' value='city'}}",
    '+49 371 531-10000'                                   => "{{block type='imprint/field' value='telephone'}}",
    '+49 371 531-10009'                                   => "{{block type='imprint/field' value='fax'}}",
    'rektorsekretariat@verwaltung.tu-chemnitz.de'         => "{{block type='imprint/field' value='email'}}",
    'Finanzamt Chemnitz-Mitte'                            => "{{block type='imprint/field' value='financial_office'}}",
    'Amtsgericht Chemnitz'                                => "{{block type='imprint/field' value='court'}}",
    'Rektorat der Technischen Universit&auml;t Chemnitz'  => "{{block type='imprint/field' value='ceo'}}",
    'Rektorat der TU Chemnitz'                            => "{{block type='imprint/field' value='company_first'}}",
    'Technische Universit&auml;t Chemnitz'                => "{{block type='imprint/field' value='company_second'}}",
    'De 140857609'                                        => "{{block type='imprint/field' value='vat_id'}}",
    'DE 140857609'                                        => "{{block type='imprint/field' value='vat_id'}}",
);


/* @var $cmsSetup Egovs_Base_Helper_Cmssetup_Data */
$cmsSetup = Mage::helper('egovsbase_cmssetup');

// CMS-Blöcke reparieren
$cmsSetup->changeCmsData('cms/block', $replace_url, $replace_string, TRUE);
// CMS-Seiten reparieren
$cmsSetup->changeCmsData('cms/page', $replace_url, $replace_string, TRUE);

$installer->endSetup();

