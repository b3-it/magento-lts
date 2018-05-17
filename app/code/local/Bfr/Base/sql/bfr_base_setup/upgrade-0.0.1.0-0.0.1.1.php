<?php
/**
 * Product show orderability SQL
 *
 * @category    BfR
 * @package     BfR_Base
 * @copyright	Copyright (c) 2018
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$entityType    = 'catalog_product';
$attributeCode = 'show_orderability';
$attr          = Mage::getResourceModel('catalog/eav_attribute')->loadByCode($entityType, $attributeCode);

if (!$attr || $attr->isEmpty()) {
	$installer->addAttribute(
		$entityType,		// Attribut-Typ
		$attributeCode,		// Attribut-Code
		array(
			'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,		// Ebene der Sichtbarkeit
			'visible'           => true,														// im BE sichtbar
			'searchable'        => false,														// Verwendung für Suche
			'filterable'        => false,														// Filterbar
			'comparable'        => false,														// Vergleichsliste
			'visible_on_front'  => false,														// im FE sichtbar
			'required'          => true,														// Pflichtfeld
			'source'            => 'eav/entity_attribute_source_boolean',						// Element-Typ
			'input'             => 'boolean',													// Element-Art
			'label'             => 'Bestellbarkeit anzeigen',									// Bezeichner
			'type'              => 'int',														// Speicher-Typ
			'default'           => '1',															// Standard im BE
			'unique'            => false,														// Verwendung nur für einen Artikel
			'user_defined'      => true,														// von Benutzer
		)
	);
}

$installer->endSetup();
