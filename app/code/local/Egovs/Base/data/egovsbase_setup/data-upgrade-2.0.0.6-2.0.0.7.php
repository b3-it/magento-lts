<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

// Default-Package nach "egov", wenn es "default" ist
$oldPackage = Mage::getStoreConfig('design/package/name');

if ( $oldPackage == 'default') {
	$installer->setConfigData('design/package/name', 'egov');

	$installer->setConfigData('design/theme/locale', '');
	$installer->setConfigData('design/theme/template', '');
	$installer->setConfigData('design/theme/skin', '');
	$installer->setConfigData('design/theme/layout', '');
	$installer->setConfigData('design/theme/default', '');
	
	$installer->setConfigData('design/header/logo_src', 'images/logo_sachsen.png');
	$installer->setConfigData('design/header/logo_src_small', 'images/logo_sachsen_smartphone.png');
}

$installer->endSetup();
