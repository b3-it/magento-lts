<?php
/**
  *
  * @category   	Gka Barkasse
  * @package    	Gka_Barkasse
  * @name       	Gka_Barkasse Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('gka_barkasse/kassenbuch_cashbox')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('gka_barkasse/kassenbuch_cashbox')};
	CREATE TABLE {$installer->getTable('gka_barkasse/kassenbuch_cashbox')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `title` varchar(128) default '',
	  `customer_id` int(11) unsigned default null,
	  `store_id` SMALLINT(5) unsigned default null,
	  `customer` varchar(128) default '',

	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE SET NULL
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('gka_barkasse/kassenbuch_journal')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('gka_barkasse/kassenbuch_journal')};
	CREATE TABLE {$installer->getTable('gka_barkasse/kassenbuch_journal')} (
	  	`id` int(11) unsigned NOT NULL auto_increment,
    	`number` int(11) unsigned default 0,
        `owner` varchar(128) default '',
        `opening` datetime default null,
        `closing` datetime default null,
        `opening_balance`  decimal(12,4) default 0,
        `closing_balance`  decimal(12,4) default 0,
        `customer_id` int(11) unsigned default null,
        `cashbox_id` int(11) unsigned default null,
        `cashbox_title` varchar(128) default '',
        `status` smallint(6) unsigned default 0,
    
	  PRIMARY KEY (`id`),
      FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE SET NULL,
      FOREIGN KEY (`cashbox_id`) REFERENCES `{$this->getTable('gka_barkasse/kassenbuch_cashbox')}`(`id`) ON DELETE SET NULL
      
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('gka_barkasse/kassenbuch_journal_items')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('gka_barkasse/kassenbuch_journal_items')};
	CREATE TABLE {$installer->getTable('gka_barkasse/kassenbuch_journal_items')} (
	  	`id` int(11) unsigned NOT NULL auto_increment,
    	`number` int(11) unsigned default 0,
        `booking_date` datetime default null,
        `journal_id` int(11) unsigned default 0,
        `order_id` int(11) unsigned default null,
        `source` smallint(6) unsigned default 0,
	  PRIMARY KEY (`id`),
     FOREIGN KEY (`journal_id`) REFERENCES `{$this->getTable('gka_barkasse/kassenbuch_journal')}`(`id`) ON DELETE SET NULL
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
