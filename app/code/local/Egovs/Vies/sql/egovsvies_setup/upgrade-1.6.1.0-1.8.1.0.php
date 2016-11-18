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
	/** @var $resource Mage_Customer_Model_Resource_Customer */
	$resource = $coll->getResource();
	$writeCon = $resource->getWriteConnection();
	foreach ($coll->getItems() as $customer) {
		$writeCon->update(
				$resource->getEntityTable(),
				array('disable_auto_group_change' => 1),
				array($resource->getEntityIdField() => $customer->getId())
		);
	}
	$installer->removeAttribute('customer', 'use_group_autoassignment');
}

$installer->endSetup();