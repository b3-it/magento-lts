<?php
/**
  *
  * @category   	Gka Virtualpayid
  * @package    	Gka_VirtualPayId
  * @name       	Gka_VirtualPayId Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('virtualpayid/epaybl_client')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('virtualpayid/epaybl_client')};
	CREATE TABLE {$installer->getTable('virtualpayid/epaybl_client')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
      `title` varchar(128) default '',
      `client` varchar(128) default '',
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

$attributeId = 'externes_kassenzeichen';
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/order'),
			$attributeId,
			'varchar(255) default null'
			);
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote'), $attributeId)) {
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/quote'),
			$attributeId,
            'varchar(255) default null'
			);
}


$installer->endSetup();
