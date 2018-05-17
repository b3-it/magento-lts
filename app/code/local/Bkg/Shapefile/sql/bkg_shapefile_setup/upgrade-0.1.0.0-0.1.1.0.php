<?php


/** @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();


if (!$installer->getAttribute('customer', 'allow_shapefile')) {
	$installer->addAttribute('customer', 'allow_shapefile', array(
			'label' => 'Allow Shapefile Upload',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => true,
			'required' => false,
            'input' => 'select',
            'position' => 200,
            'source'    => 'eav/entity_attribute_source_boolean',
	));

    $attrId = $installer->getAttributeId('customer', 'allow_shapefile');
    $this->getConnection()->insert($this->getTable('customer/form_attribute'), array(
        'form_code'     => 'adminhtml_customer',
        'attribute_id'  => $attrId
    ));
}
$installer->endSetup();