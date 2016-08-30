<?php
/**
 * Sid ExportOrder
 * 
 * 
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('exportorder/order')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('exportorder/order')};
	CREATE TABLE {$this->getTable('exportorder/order')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `order_id` int(11) unsigned NOT NULL,
	  `contract_id` int(11) unsigned,
	  `vendor_id` int(11) unsigned,
	  `transfer` varchar(255) NOT NULL default '',
	  `format` varchar(255) NOT NULL default '',
	  `message` text NOT NULL default '',
	  `status` smallint(6) NOT NULL default '0',
	  `created_time` datetime NULL,
	  `update_time` datetime NULL,
	  FOREIGN KEY (`order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
}

if (!$installer->tableExists($installer->getTable('exportorder/transfer_email')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('exportorder/transfer_email')};
	CREATE TABLE {$this->getTable('exportorder/transfer_email')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `vendor_id` int(11) unsigned NOT NULL,
	  `email` varchar(255) NOT NULL default '', 
	  `template` varchar(255) NOT NULL default '', 
	  FOREIGN KEY (`vendor_id`) REFERENCES `{$this->getTable('framecontract_vendor')}`(`framecontract_vendor_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('exportorder/transfer_post')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('exportorder/transfer_post')};
	CREATE TABLE {$this->getTable('exportorder/transfer_post')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `vendor_id` int(11) unsigned NOT NULL,
	  `address` varchar(255) NOT NULL default '',
	  `port` varchar(255) NOT NULL default '',
	  `user` varchar(255) NOT NULL default '',
	  `pwd` varchar(255) NOT NULL default '',
	  `ident` varchar(255) NOT NULL default '',
	  FOREIGN KEY (`vendor_id`) REFERENCES `{$this->getTable('framecontract_vendor')}`(`framecontract_vendor_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('exportorder/format_plain')))
{
	$installer->run("
		-- DROP TABLE IF EXISTS {$this->getTable('exportorder/format_plain')};
		CREATE TABLE {$this->getTable('exportorder/format_plain')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `vendor_id` int(11) unsigned NOT NULL,
	  `line_separator` varchar(255) NOT NULL default '\n',
	  `item_separator` varchar(255) NOT NULL default ';',
	  FOREIGN KEY (`vendor_id`) REFERENCES `{$this->getTable('framecontract_vendor')}`(`framecontract_vendor_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('exportorder/format_transdoc')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$this->getTable('exportorder/format_transdoc')};
			CREATE TABLE {$this->getTable('exportorder/format_transdoc')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `vendor_id` int(11) unsigned NOT NULL,
	  FOREIGN KEY (`vendor_id`) REFERENCES `{$this->getTable('framecontract_vendor')}`(`framecontract_vendor_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`id`)
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