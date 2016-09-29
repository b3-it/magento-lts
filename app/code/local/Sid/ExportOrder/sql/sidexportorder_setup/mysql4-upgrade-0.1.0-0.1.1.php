<?php

$installer = $this;

$installer->startSetup();

if (!$installer->tableExists($installer->getTable('exportorder/transfer_link')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('exportorder/transfer_link')};
			CREATE TABLE {$this->getTable('exportorder/transfer_link')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `vendor_id` int(11) unsigned NOT NULL,
	  `email` varchar(255) NOT NULL default '', 
	  `template` varchar(255) NOT NULL default '', 
	  FOREIGN KEY (`vendor_id`) REFERENCES `{$this->getTable('framecontract_vendor')}`(`framecontract_vendor_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}



if (!$installer->tableExists($installer->getTable('exportorder/history')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('exportorder/history')};
	CREATE TABLE {$this->getTable('exportorder/history')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `order_id` int(11) unsigned NOT NULL,
	  `message` text NOT NULL default '',
	  `status` smallint(6) NOT NULL default '0',
	  `update_time` datetime NULL,
	  FOREIGN KEY (`order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
		");
}

if (!$installer->tableExists($installer->getTable('exportorder/link')))
{
	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('exportorder/link')};
	CREATE TABLE {$this->getTable('exportorder/link')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `vendor_id` int(11) unsigned NOT NULL,
	  `ident` varchar(255) NOT NULL default '',
	  `filename` varchar(255) NOT NULL default '',
	  `send_filename` varchar(255) NOT NULL default '',
	  `download` int(11) unsigned default 0,
	  `download_time` datetime NULL,
	  `create_time` datetime NULL,
	  FOREIGN KEY (`vendor_id`) REFERENCES `{$this->getTable('framecontract_vendor')}`(`framecontract_vendor_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if (!$installer->tableExists($installer->getTable('exportorder/link_order')))
{
	$installer->run("
			-- DROP TABLE IF EXISTS {$this->getTable('exportorder/link_order')};
			CREATE TABLE {$this->getTable('exportorder/link_order')} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `order_id` int(11) unsigned NOT NULL,
	  `link_id` int(11) unsigned NOT NULL,
	  
	  FOREIGN KEY (`link_id`) REFERENCES `{$this->getTable('exportorder/link')}`(`id`) ON DELETE CASCADE,
	  FOREIGN KEY (`order_id`) REFERENCES `{$this->getTable('sales/order')}`(`entity_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

$installer->endSetup(); 