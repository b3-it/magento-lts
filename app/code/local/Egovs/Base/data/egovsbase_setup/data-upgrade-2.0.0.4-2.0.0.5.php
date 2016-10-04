<?php
/** @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

try {
	$installer->getConnection()->insertMultiple(
	    $installer->getTable('admin/permission_variable'),
	    array(
	        array('variable_name' => 'cms/site', 'is_allowed' => 1),
	    )
	);
} catch (Exception $e) {
	Mage::logException($e);
}

$installer->endSetup();
