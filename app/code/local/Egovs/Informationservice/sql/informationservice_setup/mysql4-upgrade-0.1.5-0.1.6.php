<?php

$installer = $this;

$installer->startSetup();

/*
 * ZV_FM-698
 * In Version 1.3 hieß das Attribut noch 'informationservice_is_master_product'!
 * Ab Version 1.6 wurde es in 'infoservice_is_master_product' umbenannt!
 */
if ($installer->getAttribute('catalog_product', 'informationservice_is_master_product')) {
	$installer->updateAttribute('catalog_product', 'informationservice_is_master_product', array('attribute_code' => 'infoservice_is_master_product'));
}

$installer->updateAttribute('catalog_product', 'infoservice_is_master_product', 'is_configurable', false);

$installer->endSetup(); 
