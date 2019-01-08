<?php
/**
  *
  * @category   	Bkg Tollpolicy
  * @package    	Bkg_Tollpolicy
  * @name       	Bkg_Tollpolicy Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
/** @var $this Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('bkg_tollpolicy/toll_category')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_tollpolicy/toll_category')};
	CREATE TABLE {$installer->getTable('bkg_tollpolicy/toll_category')} (
	`id` int(11) unsigned NOT NULL auto_increment,
    `name` varchar(128) default '',
	PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('bkg_tollpolicy/toll_category_customer_group')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$installer->getTable('bkg_tollpolicy/toll_category_customer_group')};
			CREATE TABLE {$installer->getTable('bkg_tollpolicy/toll_category_customer_group')} (
			`id` int(11) unsigned NOT NULL auto_increment,
			`toll_category_id` int(11) unsigned NOT NULL,
			`customer_group_id` SMALLINT(5) unsigned NOT NULL,
			PRIMARY KEY (`id`),
			FOREIGN KEY (`toll_category_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/toll_category')}`(`id`) ON DELETE CASCADE,
			FOREIGN KEY (`customer_group_id`) REFERENCES `{$this->getTable('customer/customer_group')}`(`customer_group_id`) ON DELETE CASCADE
			) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}



if (!$installer->tableExists($installer->getTable('bkg_tollpolicy/toll_entity')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_tollpolicy/toll_entity')};
	CREATE TABLE {$installer->getTable('bkg_tollpolicy/toll_entity')} (
	`id` int(11) unsigned NOT NULL auto_increment,
    `active` smallint(6) unsigned default '0',
    `date_from` datetime default now(),
    `date_to` datetime default now(),
    `code` varchar(128) default '',
    `toll_category_id` int(11) unsigned NOT NULL,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`toll_category_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/toll_category')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
    ");
}


if (!$installer->tableExists($installer->getTable('bkg_tollpolicy/use_type_entity')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_tollpolicy/use_type_entity')};
	CREATE TABLE {$installer->getTable('bkg_tollpolicy/use_type_entity')} (
	`id` int(11) unsigned NOT NULL auto_increment,
	`active` smallint(6) unsigned default '0',
	`internal` smallint(6) unsigned default '0',
	`external` smallint(6) unsigned default '0',
	`code` varchar(128) default '',
	`is_default` smallint(6) unsigned default '0',
	`toll_id` int(11) unsigned NOT NULL,
	`pos` int(11) default 10,
	PRIMARY KEY (`id`),
    FOREIGN KEY (`toll_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/toll_entity')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}



if (!$installer->tableExists($installer->getTable('bkg_tollpolicy/use_options_entity')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('bkg_tollpolicy/use_options_entity')};
	CREATE TABLE {$installer->getTable('bkg_tollpolicy/use_options_entity')} (
	`id` int(11) unsigned NOT NULL auto_increment,
    `code` varchar(128) default '',
    `factor` decimal(12,4) default 0.0,
    `pos` int(11) default 10,
    `userdefined` varchar(128) default '',
    `is_default` smallint(6) unsigned default '0',
    `is_calculable` smallint(6) unsigned default '0',
    `use_type_id` int(11) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`use_type_id`) REFERENCES `{$this->getTable('bkg_tollpolicy/use_type_entity')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}




$tables = array();
$tables[] = 'bkg_tollpolicy/use_options';
$tables[] = 'bkg_tollpolicy/use_type';
$tables[] = 'bkg_tollpolicy/toll';

foreach ($tables as $table)
{

	if (!$installer->tableExists($installer->getTable($table."_label")))
	{
		$installer->run("CREATE TABLE {$installer->getTable($table.'_label')} (
		`id` int(11) unsigned NOT NULL auto_increment,
		`store_id` smallint unsigned NOT NULL,
		`entity_id` int(11) unsigned NOT NULL,
		`name` varchar(512) default '',
		PRIMARY KEY (`id`),
		FOREIGN KEY (`entity_id`) REFERENCES `{$this->getTable($table.'_entity')}`(`id`) ON DELETE CASCADE,
		FOREIGN KEY (`store_id`) REFERENCES `{$this->getTable('core/store')}`(`store_id`) ON DELETE CASCADE
		)
		ENGINE=InnoDB DEFAULT CHARSET=utf8;");
	}

}


if (!$installer->getAttribute('catalog_product', 'toll_category')) {
	$installer->addAttribute('catalog_product', 'toll_category', array(
			'label' => 'Toll Category',
			'input' => 'select',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
			'visible' => true,
			//'required' => true,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'source'    => 'bkg_tollpolicy/entity_attribute_source_category',
			'default' => '1',
			//'option' => $option,
			'group' => 'General',
			'apply_to' => Bkg_VirtualGeo_Model_Product_Type::TYPE_CODE,
	));
}

$installer->endSetup();
