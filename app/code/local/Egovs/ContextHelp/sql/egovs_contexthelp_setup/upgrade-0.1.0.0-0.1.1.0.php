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

  /** @var Mage_Core_Model_Resource_Setup $installer */
  /** @var Mage_Eav_Model_Entity_Setup $this */

$installer = $this;

$installer->startSetup();
if ($installer->tableExists($installer->getTable('contexthelp/contexthelp')))
{
	$installer->run("
	ALTER TABLE {$installer->getTable('contexthelp/contexthelp')}
    add `package_theme` varchar(255) default '' ,
    add `store_ids` varchar(255) default '';");
}

$installer->endSetup();
