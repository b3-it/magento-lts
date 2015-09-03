<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd Installer
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();

$installer->updateAttribute('catalog_product', 'icd_use', 'is_visible',false);
$installer->updateAttribute('catalog_product', 'icd_use', 'apply_to',Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL);
$installer->updateAttribute('catalog_product', 'icd_connection', 'is_visible', false);
$installer->updateAttribute('catalog_product', 'icd_application', 'is_visible', false);

$installer->endSetup(); 