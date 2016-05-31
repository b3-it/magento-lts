<?php
/**
 * Bfr EventRequest
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('eventrequest/request')))
{

	$installer->run("

	-- DROP TABLE IF EXISTS {$this->getTable('eventrequest/request')};
	CREATE TABLE {$this->getTable('eventrequest/request')} (
	  `eventrequest_request_id` int(11) unsigned NOT NULL auto_increment,
	  `title` varchar(255) NOT NULL default '',
	  `note` text NOT NULL default '',
	  `status` smallint(6) NOT NULL default '0',
	  `customer_id` int(11) unsigned NOT NULL,
	  `quote_id` int(11) unsigned ,
	  `product_id` int(11) unsigned NOT NULL,
	  `created_time` datetime NULL,
	  `update_time` datetime NULL,
	  PRIMARY KEY (`eventrequest_request_id`),
	  FOREIGN KEY (`customer_id`) REFERENCES `{$this->getTable('customer/entity')}`(`entity_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`quote_id`) REFERENCES `{$this->getTable('sales/quote')}`(`entity_id`) ON DELETE SET NULL,
	  FOREIGN KEY (`product_id`) REFERENCES `{$this->getTable('catalog/product')}`(`entity_id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

if (!$installer->getAttribute('catalog_product', 'eventrequest')) {
	$installer->addAttribute('catalog_product', 'eventrequest', array(
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
	$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, 'eventrequest', 'apply_to', Egovs_EventBundle_Model_Product_Type::TYPE_EVENTBUNDLE);
}



$installer->endSetup(); 