<?php
/**
 * Haushalsparameter nur an bestimmte Produkte binden
 * 
 * Achtung!
 * Es gab Änderungen an der Versionsnummer. 
 * Urspünglich existierte bereits eine Version 2.0.2.0 daher wird 2.0.3.0 verwendet!
 *
 * @category        Egovs
 * @package         Egovs_Paymentbase
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
$productList = array(
		'simple',
		'configurable',
		'virtual',
		'bundle',
		'downloadable'
);
if (Mage::helper ('core')->isModuleEnabled ('Dwd_ConfigurableDownloadable')) {
	$productList[] = Dwd_ConfigurableDownloadable_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_DOWNLOADABLE;
}
if (Mage::helper ('core')->isModuleEnabled ('Dwd_ConfigurableVirtual')) {
	$productList[] = Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL;
}
if (Mage::helper ('core')->isModuleEnabled ('Dwd_ProductOnDemand')) {
	$productList[] = Dwd_ProductOnDemand_Model_Product_Type_Ondemand::TYPE_DOWNLOAD_ON_DEMAND;
}
if (Mage::helper ('core')->isModuleEnabled ('TuChemnitz_Voucher')) {
	$productList[] = TuChemnitz_Voucher_Model_Product_Type_Tucvoucher::TYPE_VOUCHER;
}

//TODO EventBundle fehlt noch, da noch nicht migriert!

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
 
