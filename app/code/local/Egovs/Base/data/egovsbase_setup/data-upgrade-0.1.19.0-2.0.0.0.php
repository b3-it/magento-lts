<?php
/* @var $this Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();


$installer->getConnection()->insertMultiple(
		$installer->getTable('admin/permission_variable'),
		array(
				array('variable_name' => 'general/imprint/company_first', 'is_allowed' => 1),
				array('variable_name' => 'general/imprint/street', 'is_allowed' => 1),
				array('variable_name' => 'general/imprint/zip', 'is_allowed' => 1),
				array('variable_name' => 'general/imprint/city', 'is_allowed' => 1),
				array('variable_name' => 'general/imprint/email', 'is_allowed' => 1),
		)
);



$installer->getConnection()->insertMultiple(
		$installer->getTable('admin/permission_block'),
		array(
				array('block_name' => 'imprint/field', 'is_allowed' => 1),
				array('block_name' => 'imprint/content', 'is_allowed' => 1),
				array('block_name' => 'cms/block', 'is_allowed' => 1),
				array('block_name' => 'symmetrics_impressum/impressum', 'is_allowed' => 1)
		)
);

$installer->endSetup();
