<?php

/* @var $installer TuChemnitz_Voucher_Model_Product_Type_Tucvoucher */
$installer = $this;

$installer->startSetup();


$installer->addAttribute(Mage_Catalog_Model_Product::ENTITY, 'tucvoucher_note_email', array(
		'type'                    => Varien_Db_Ddl_Table::TYPE_TEXT,
		'backend'                 => '',
		'frontend'                => '',
		'label'                   => 'Voucher note',
		'input'                   => '',
		'class'                   => '',
		'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
		'visible'                 => false,
		'required'                => true,
		'user_defined'            => false,
		'default'                 => '0',
		'searchable'              => false,
		'filterable'              => false,
		'comparable'              => false,
		'visible_on_front'        => false,
		'unique'                  => false,
		'apply_to'                => TuChemnitz_Voucher_Model_Product_Type_Tucvoucher::TYPE_VOUCHER,
		'is_configurable'         => false,
		'used_in_product_listing' => false
));


$installer->endSetup();