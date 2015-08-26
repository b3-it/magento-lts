<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd Installer
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


$installer = $this;

$installer->startSetup();


$installer->run("ALTER TABLE {$installer->getTable('icd_account')} ADD COLUMN `semaphor` BIGINT unsigned DEFAULT 0;");
$installer->run("ALTER TABLE {$installer->getTable('icd_orderitem')} ADD COLUMN `semaphor` BIGINT unsigned DEFAULT 0;");

$installer->endSetup(); 