<?php

$installer = $this;

$installer->startSetup();


$installer->addAttribute('customer_address', 'haushalts_system', array(
		'label'			=> 'Haushalts System',
		'global' 		=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'      	=> 1,
		'required'     	=> 0,
		'position'     	=> 1,
		'sort_order'   	=> 40,
		'input'			=> 'select',
		'source' => 'sidhaushalt/source_attribute_type',
		
));


$forms=array('adminhtml_customer_address');
$entityType = 'customer_address';
$attributeCode = 'haushalts_system';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '160')->save();


if (!$installer->tableExists($installer->getTable('sidhaushalt/order_info')))
{

	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('sidhaushalt/order_info')};
		CREATE TABLE {$this->getTable('sidhaushalt/order_info')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `order_id`int(11) unsigned default NULL,
	  `exported` smallint(6) NOT NULL default 0,
	  `haushalts_system` varchar(255) NOT NULL default '',
	  `additional_info` varchar(255) NOT NULL default '',
	  `exported_time` datetime NULL,
	  `created_time` datetime NULL,
	  `update_time` datetime NULL,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}




$installer->endSetup(); 