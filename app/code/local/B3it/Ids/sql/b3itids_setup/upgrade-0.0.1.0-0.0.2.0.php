<?php
/**
 *
 * @category   	B3it Ids
 * @package    	B3it_Ids
 * @name       	B3it_Ids Installer
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

$installer = $this;

$installer->startSetup();
if (!$installer->tableExists($installer->getTable('b3it_ids/dos_url')))
{
    $installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('b3it_ids/dos_url')};
	CREATE TABLE {$installer->getTable('b3it_ids/dos_url')} (
	    `id` int(11) unsigned NOT NULL auto_increment,
        `url` varchar(255) default '',
        `delay` int(11) unsigned default 5,
        `action` smallint(6) unsigned default 0,
	  PRIMARY KEY (`id`),
	  INDEX idx_dos_url_url (url)

	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}

if (!$installer->tableExists($installer->getTable('b3it_ids/dos_visit')))
{
    $installer->run("
	-- DROP TABLE IF EXISTS {$installer->getTable('b3it_ids/dos_visit')};
	CREATE TABLE {$installer->getTable('b3it_ids/dos_visit')} (
	    `id` int(11) unsigned NOT NULL auto_increment,
        `url_id` int(11) unsigned NOT NULL,
        `last_visit` datetime,
        `barrier_time` datetime,
        `current_delay` int(11) unsigned default 5,
        `counter` int(11) unsigned default 0,
        `ip` varchar(255) default '',
        `agent` varchar(255) default '',
	  PRIMARY KEY (`id`),
	  INDEX idx_dos_visit_ip (ip),
	  INDEX idx_dos_visit_agent (agent),
	  INDEX idx_dos_visit_barrier_time (barrier_time),
      FOREIGN KEY (`url_id`) REFERENCES `{$this->getTable('b3it_ids/dos_url')}`(`id`) ON DELETE CASCADE
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;

		");
}


$installer->endSetup();
