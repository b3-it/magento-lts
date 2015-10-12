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

$installer->addAttribute('catalog_product', 'icd_use', array(
		'label' => 'ICD benutzen',
		'input' => 'select',
		'type' => 'int',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => false,
		//'required' => true,
		'is_user_defined' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'source'    => 'eav/entity_attribute_source_boolean',
		'default' => '1',
		//'option' => $option,
		'group' => 'General',
		'apply_to' => Dwd_ConfigurableVirtual_Model_Product_Type_Configurable::TYPE_CONFIGURABLE_VIRTUAL,
));

$installer->endSetup(); 