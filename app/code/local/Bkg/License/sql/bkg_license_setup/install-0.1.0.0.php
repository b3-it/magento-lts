<?php
/**
  *
  * @category   	Bkg License
  * @package    	Bkg_License
  * @name       	Bkg_License Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bkg_license/master')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master')};
	CREATE TABLE {$installer->getTable('bkg_license/master')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
        `type` smallint(6) unsigned default '0',
        `reuse` smallint(6) unsigned default '0',
        `ident` varchar(255) default '',
        `name` varchar(255) default '',
        `date_from` date default NULL,
        `date_to` date default NULL,
        `active` smallint(6) unsigned default '0',
        `consternation_check` smallint(6) unsigned default '0',
        `content` MEDIUMTEXT default '', 
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/master_products')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_products')};
	CREATE TABLE {$installer->getTable('bkg_license/master_products')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
      `product_id` int(11) unsigned NOT NULL ,
      `master_id` int(11) unsigned NOT NULL ,    
	  PRIMARY KEY (`id`),
     FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE,
     FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
}


if (!$installer->tableExists($installer->getTable('bkg_license/master_toll')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_toll')};
			CREATE TABLE {$installer->getTable('bkg_license/master_toll')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `useoption_id` int(11) unsigned NOT NULL ,
	  `useoption_code` varchar(255) default '' ,
	  `master_id` int(11) unsigned NOT NULL ,
	  `pos` int(11) default '0',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`useoption_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/use_options_entity')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


if (!$installer->tableExists($installer->getTable('bkg_license/master_customergroups')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_customergroups')};
	CREATE TABLE {$installer->getTable('bkg_license/master_customergroups')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
        `customergroup_id` smallint(5) unsigned NOT NULL ,
        `master_id` int(11) unsigned NOT NULL ,
    
	  PRIMARY KEY (`id`),
    FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE,
    FOREIGN KEY (`customergroup_id`) REFERENCES `{$this->getTable('customer/customer_group')}`(`customer_group_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('bkg_license/master_fee')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_fee')};
	CREATE TABLE {$installer->getTable('bkg_license/master_fee')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
    `master_id` int(11) unsigned NOT NULL,
        `fee_code` varchar(255) default '',
        `is_percent` smallint(6) default '0',
        `is_active` smallint(6) default '0',
        `discount` DECIMAL(12,4) default '0',
    
	  PRIMARY KEY (`id`),
    FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('bkg_license/master_agreement')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_agreement')};
	CREATE TABLE {$installer->getTable('bkg_license/master_agreement')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
    `master_id` int(11) unsigned NOT NULL ,
        `identifier` varchar(128) default '',
        `pos` int(11) default '0',
    
	  PRIMARY KEY (`id`),
      FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('bkg_license/master_useoption')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/master_useoption')};
	CREATE TABLE {$installer->getTable('bkg_license/master_useoption')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
      `master_id` int(11) unsigned NOT NULL,
      `use_option_id` int(11) unsigned,
      `pos` int(11) default '0',
	  PRIMARY KEY (`id`),
      FOREIGN KEY (`use_option_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/use_options_entity')}`(`id`) ON DELETE CASCADE,
      FOREIGN KEY (`master_id`) REFERENCES `{$this->getTable('bkg_license/master')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
");
}

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bkg_license/copy')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy')};
			CREATE TABLE {$installer->getTable('bkg_license/copy')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `type` smallint(6) unsigned default '0',
	  `reuse` smallint(6) unsigned default '0',
	  `ident` varchar(255) default '',
	  `name` varchar(255) default '',
	  `date_from` date default NULL,
	  `date_to` date default NULL,
	  `active` smallint(6) unsigned default '0',
	  `consternation_check` smallint(6) unsigned default '0',
	  `content` MEDIUMTEXT default '',
	  PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
			");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_products')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_products')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_products')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `product_id` int(11) unsigned NOT NULL ,
	  `copy_id` int(11) unsigned NOT NULL ,
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


if (!$installer->tableExists($installer->getTable('bkg_license/copy_toll')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_toll')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_toll')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `useoption_id` int(11) unsigned NOT NULL ,
	  `useoption_code` varchar(255) default '' ,
	  `copy_id` int(11) unsigned NOT NULL ,
	  `pos` int(11) default '0',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`useoption_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/use_options_entity')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}


if (!$installer->tableExists($installer->getTable('bkg_license/copy_customergroups')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_customergroups')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_customergroups')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `customergroup_id` smallint(5) unsigned NOT NULL ,
	  `copy_id` int(11) unsigned NOT NULL ,

	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`customergroup_id`) REFERENCES `{$this->getTable('customer/customer_group')}`(`customer_group_id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_fee')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_fee')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_fee')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `copy_id` int(11) unsigned NOT NULL,
	  `fee_code` varchar(255) default '',
	  `is_percent` smallint(6) default '0',
	  `is_active` smallint(6) default '0',
	  `discount` DECIMAL(12,4) default '0',

	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_agreement')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_agreement')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_agreement')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `copy_id` int(11) unsigned NOT NULL ,
	  `identifier` varchar(128) default '',
	  `pos` int(11) default '0',

	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

	  ");
}

if (!$installer->tableExists($installer->getTable('bkg_license/copy_useoption')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_license/copy_useoption')};
			CREATE TABLE {$installer->getTable('bkg_license/copy_useoption')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `copy_id` int(11) unsigned NOT NULL,
	  `use_option_id` int(11) unsigned,
	  `pos` int(11) default '0',
	  PRIMARY KEY (`id`),
	  FOREIGN KEY (`use_option_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/use_options_entity')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`copy_id`) REFERENCES `{$this->getTable('bkg_license/copy')}`(`id`) ON DELETE CASCADE
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
