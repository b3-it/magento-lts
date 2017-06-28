<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

// Default-Package nach "egov", wenn es "default" ist
$oldPackage = Mage::getStoreConfig('design/package/name');

if ( $oldPackage == 'default') {
	$installer->setConfigData('design/package/name', 'egov');
}

$installer->endSetup();
