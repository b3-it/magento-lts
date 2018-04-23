<?php
/**
 * B3it Subscription
 *
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('b3it_subscription/subscription')))
{
$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('b3it_subscription/subscription')};
CREATE TABLE {$this->getTable('b3it_subscription/subscription')} (
  `id` int(11) unsigned NOT NULL auto_increment,
  `first_order_id` int(11) unsigned default NULL,
  `first_orderitem_id` int(11) unsigned default NULL,
  `current_order_id` int(11) unsigned default NULL,
  `current_orderitem_id` int(11) unsigned default NULL,
  `product_id` int(11) unsigned default NULL,
  `counter` smallint(6) unsigned default 0,
  `renewal_status` smallint(6) NOT NULL default '0',
  `status` smallint(6) NOT NULL default '0',
  `start_date` datetime NULL,
  `stop_date` datetime NULL,
  `renewal_date` datetime NULL,
  `periode_length` int default 365,
  `renewal_offset` int default 0,
  `order_group` varchar(128) default '',
  
  
  PRIMARY KEY (`subscription_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");
}



$installer->endSetup();