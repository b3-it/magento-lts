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

$installer->run("ALTER TABLE {$this->getTable('framecontract_transmit')} ADD `los_id` int default 0 ");
$installer->run("ALTER TABLE {$this->getTable('framecontract_transmit')} ADD `note` varchar(255) NOT NULL default '' ");
$installer->removeAttribute('catalog_product', 'framecontract');
$installer->endSetup();