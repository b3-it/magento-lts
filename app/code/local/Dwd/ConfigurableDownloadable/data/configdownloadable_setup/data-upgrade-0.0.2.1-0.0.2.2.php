<?php
/**
 * Haushalsparameter nur an bestimmte Produkte binden
 * 
 *
 * @category        Dwd
 * @package         Dwd_ConfigurableDownloadable
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2016 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $this Egovs_Paymentbase_Model_Resource_Setup */
$installer = $this;

$fieldList = array(
		'haushaltsstelle',
		'objektnummer',
		'objektnummer_mwst',
		'href',
		'href_mwst',
		'buchungstext',
		'buchungstext_mwst'
);
//gleiche Einstellungen wie für Preis
$productList = array();

if (Mage::helper ('core')->isModuleEnabled ('Dwd_ConfigurableDownloadable')) {
	$productList[] = Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE;
}

// make these attributes applicable to special products
foreach ($fieldList as $field) {
    $applyTo = explode(',', $installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to'));
    foreach ($productList as $product) {
	    if (!in_array($product, $applyTo)) {
	        $applyTo[] = $product;
	    }
    }
    $installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to', implode(',', $applyTo));
}
 
