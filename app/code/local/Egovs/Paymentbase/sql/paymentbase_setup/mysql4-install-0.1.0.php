<?php

$installer = $this;

$installer->startSetup();

/*
 * Falls user_defined => true benutzt wird, muss ein Attributset bzw. eine Gruppe angegeben werden.
 * Falls user_defined => false so wird es in alle Attributsets integriert (Gruppe: General)
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$entityTypeId = 'order_payment';
$attributeId = 'kassenzeichen';

if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
	$installer->addAttribute($entityTypeId, $attributeId, array(
	    'label' => 'Kassenzeichen',
	    'input' => 'text',
	    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
	    'visible' => true,
	    'required' => false,
	    'user_defined' => false,
	    'searchable' => false,
	    'comparable' => false,
	    'visible_on_front' => false,
	    'visible_in_advanced_search' => false,
	    'default' => '0',
	));
} else {
	//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
	$installer->getConnection()->addColumn(
		$installer->getTable('sales/order_payment'),
	    'kassenzeichen',
		'varchar(255)'
	);
}

/*
	$attrSetId = $installer->getDefaultAttributeSetId($entityTypeId);
	$groupId = $installer->getDefaultAttributeGroupId($entityTypeId);
	$installer->addAttributeToSet($entityTypeId, $attrSetId, $group, $attributeId);
*/

$entityTypeId = 'catalog_product';
$attributeId = 'haushaltsstelle';
$installer->addAttribute($entityTypeId, $attributeId, array(
    'label' => 'Haushaltsstelle',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));

/* if (version_compare(Mage::getVersion(), '1.4.2', '>='))
{
	Mage::getSingleton('eav/config')
		->getAttribute($entityTypeId, $attributeId)
		->setData('used_in_forms', array('adminhtml_customer','customer_account_create','customer_account_edit','checkout_register'))
		->save()
	;
} */

$installer->addAttribute('catalog_product', 'objektnummer', array(
    'label' => 'Objektnummer',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));

$installer->addAttribute('catalog_product', 'objektnummer_mwst', array(
    'label' => 'Objektnummer MwSt',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => false,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));

$installer->addAttribute('catalog_product', 'href', array(
    'label' => 'HREF',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));

$installer->addAttribute('catalog_product', 'href_mwst', array(
    'label' => 'HREF MwSt',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));

$installer->addAttribute('catalog_product', 'buchungstext', array(
    'label' => 'Buchungstext',
    'input' => 'text',
    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
    'visible' => true,
    'required' => true,
    'searchable' => false,
    'comparable' => false,
    'visible_on_front' => false,
    'visible_in_advanced_search' => false,
    'default' => '',
));


$installer->endSetup(); 