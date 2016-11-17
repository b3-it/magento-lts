<?php
/** @var $this Egovs_Base_Model_Resource_Setup */
/** @var $installer Egovs_Base_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

if (($attrId = $installer->getAttributeId('customer', 'use_group_autoassignment'))) {
	/** @var $coll Mage_Customer_Model_Resource_Customer_Collection */
	$coll = Mage::getModel('customer/customer')->getCollection();
	$coll->addAttributeToFilter($attrId, 0);
	$coll->addAttributeToSelect($attrId);
	foreach ($coll->getItems() as $customer) {
		$customer->setDisableAutoGroupChange(true)
			->save()
		;
	}
	$installer->removeAttribute('customer', 'use_group_autoassignment');
}

$installer->endSetup();