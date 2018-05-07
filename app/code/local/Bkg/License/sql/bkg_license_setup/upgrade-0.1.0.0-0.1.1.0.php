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

/**
 * @var Mage_Catalog_Model_Resource_Setup $installer
 */
$installer = $this;

$installer->startSetup();

$table = 'bkg_license/copy_period';

if (!$installer->tableExists($installer->getTable($table)))
{
	$installer->run("
	CREATE TABLE {$installer->getTable($table)} (
	  `id` int(11) unsigned NOT NULL auto_increment,
	  `pos` int(11) unsigned default 0,
	  `name` varchar(512) default '',
	  `initial_period_length` int(11) unsigned default 2,
	  `initial_period_unit` varchar(8)  default 'y',
	  `period_length` int(11) unsigned default 1,
	  `period_unit` varchar(8)  default 'y',
	  `renewal_offset` int default 0,
	  PRIMARY KEY (`id`)
	  ) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	  ");
}

if ($installer->tableExists($installer->getTable('bkg_license/master')))
{
	$installer->run("
	ALTER TABLE {$installer->getTable('bkg_license/master')} 
	  ADD period_id int(11) unsigned default NULL,
	  ADD CONSTRAINT bkg_license_master_period FOREIGN KEY (`period_id`) REFERENCES `{$this->getTable('b3it_subscription/period_entity')}`(`id`) ON DELETE SET NULL;
    ");
}

$installer->startSetup();
if ($installer->tableExists($installer->getTable('bkg_license/copy')))
{
	$installer->run("
	ALTER TABLE {$installer->getTable('bkg_license/copy')} 
		ADD period_id int(11) unsigned default NULL,
		ADD CONSTRAINT bkg_license_copy_period FOREIGN KEY (`period_id`) REFERENCES `{$this->getTable('bkg_license/copy_period')}`(`id`) ON DELETE SET NULL;
	");
}


$installer->endSetup();
