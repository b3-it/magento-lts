<?php

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

$installer->startSetup();


$installer->addAttribute('catalog_product', 'framecontract_qty', array(
		'label' => 'vereinbarte Liefermenge',
		'input' => 'text',
		'type' => 'int',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'default' => '0',
		'group' =>'Framecontract'

));

$installer->addAttribute('customer_address', 'dap', array(
		'label'			=> 'Deliver at Place',
		'global' 		=> Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'      	=> 1,
		'required'     	=> 0,
		'position'     	=> 1,
		'sort_order'   	=> 40,
));



$forms=array('adminhtml_customer_address','customer_address_edit');
$entityType = 'customer_address';
$attributeCode = 'dap';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '150')->save();

$installer->run("ALTER TABLE {$this->getTable('framecontract_transmit')} ADD `los_id` int default 0 ");
$installer->run("ALTER TABLE {$this->getTable('framecontract_transmit')} ADD `note` varchar(255) NOT NULL default '' ");
$installer->removeAttribute('catalog_product', 'framecontract');
$installer->run("ALTER TABLE {$this->getTable('framecontract_los')} ADD `stock_status_send` smallint(6) NOT NULL default 0 ");
$installer->endSetup();