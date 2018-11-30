<?php
/**
  *
  * @category   	Bfr Report
  * @package    	Bfr_Report
  * @name       	Bfr_Report Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('bfr_report/export_exported')))
{
    $installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bfr_report/export_exported')};
	CREATE TABLE {$installer->getTable('bfr_report/export_exported')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
    	`incoming_payment_id` int(11) unsigned NOT NULL ,
        `exported_at` datetime default now(),
        `exported_by` varchar(128) default '',
	  PRIMARY KEY (`id`),
     FOREIGN KEY (`incoming_payment_id`) REFERENCES `{$this->getTable('paymentbase/incoming_payment')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}


/*
if (!$installer->getAttribute('catalog_product', 'request')) {
	$installer->addAttribute('catalog_product', 'request', array(
			'label' => 'With Request',
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
			'apply_to' => Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE,
	));
}
*/
$installer->endSetup();
