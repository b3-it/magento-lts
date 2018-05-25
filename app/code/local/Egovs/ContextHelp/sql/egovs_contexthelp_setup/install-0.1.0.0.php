<?php
/**
  *
  * @category   	Egovs ContextHelp
  * @package    	Egovs_ContextHelp
  * @name       	Egovs_ContextHelp Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('contexthelp/contexthelp')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('contexthelp/contexthelp')};
	CREATE TABLE {$installer->getTable('contexthelp/contexthelp')} (
	 `id` int(11) unsigned NOT NULL auto_increment,
    `title` varchar(255) default '',
    `category_id` varchar(255) default '' ,
 	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->tableExists($installer->getTable('contexthelp/contexthelp_handle')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('contexthelp/contexthelp_handle')};
	CREATE TABLE {$installer->getTable('contexthelp/contexthelp_handle')} (
	 `id` int(11) unsigned NOT NULL auto_increment,
     `handle` varchar(255) default '',
     `parent_id` int(11) unsigned NOT NULL,
     INDEX ìdx_handle (`handle`), 	
	  PRIMARY KEY (`id`),
      FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('contexthelp/contexthelp')}`(`id`) ON DELETE CASCADE,
      
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('contexthelp/contexthelp_block')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('contexthelp/contexthelp_block')};
	CREATE TABLE {$installer->getTable('contexthelp/contexthelp_block')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
      `block_id` smallint(6) NOT NULL,
      `pos` varchar(128) default '',
      `parent_id` int(11) unsigned NOT NULL,
    
	  PRIMARY KEY (`id`),
      FOREIGN KEY (`parent_id`) REFERENCES `{$this->getTable('contexthelp/contexthelp')}`(`id`) ON DELETE CASCADE,
      FOREIGN KEY (`block_id`) REFERENCES `{$this->getTable('cms/block')}`(`block_id`) ON DELETE CASCADE
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
