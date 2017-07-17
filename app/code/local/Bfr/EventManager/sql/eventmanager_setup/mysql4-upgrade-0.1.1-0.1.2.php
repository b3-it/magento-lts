<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();

$installer->addAttribute('customer_address', 'academic_titel', array(
		'label'			=> 'Academic Titel',
		'global' 		=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'      	=> 1,
		'required'     	=> 0,
		'position'     	=> 1,
		'sort_order'   	=> 31,
));


$installer->addAttribute('customer_address', 'position', array(
		'label'        	=> 'Position',
		'global' 		=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'      	=> 1,
		'required'     	=> 0,
		'position'     	=> 1,
		'sort_order'   	=> 32,
));



$entityType = 'customer_address';


$forms=array('adminhtml_customer_address','customer_address_edit', 'customer_register_address','customer_account_create');
$attributeCode = 'position';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '1')->save();

$attributeCode = 'academic_titel';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '0')->save();






if (!$installer->getConnection()->tableColumnExists($installer->getTable('eventmanager/participant'), 'academic_titel')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('eventmanager/participant')}
			ADD COLUMN academic_titel varchar(255) default '';
			");

}

if (!$installer->getConnection()->tableColumnExists($installer->getTable('eventmanager/participant'), 'position')) {
	$installer->run("
			ALTER TABLE {$installer->getTable('eventmanager/participant')}
			ADD COLUMN position varchar(255) default '';
			");
}


$installer->endSetup();