<?php

$installer = $this;

$installer->startSetup();

if (!$installer->getAttribute('customer', 'allow_couriershipment')) 
{
	$installer->addAttribute('customer', 'allow_couriershipment', array(
	    'label'        => 'Allow Courier Shipment',
		'input' => 'select',
		'type' => 'int',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => true,
		'source' => 'eav/entity_attribute_source_boolean',
	    'default' => '0',
		'group' => 'account',
	));

	 $attribute = $installer->getAttribute('customer', 'allow_couriershipment');
       
     if ($attribute) {

     $data       = array();
     $attributeId = $attribute['attribute_id'];
	 $data[] = array('form_code'     => 'adminhtml_customer', 'attribute_id'  => $attributeId);
     $installer->getConnection()->insertMultiple($this->getTable('customer/form_attribute'), $data);
	}
}



$installer->endSetup();
 