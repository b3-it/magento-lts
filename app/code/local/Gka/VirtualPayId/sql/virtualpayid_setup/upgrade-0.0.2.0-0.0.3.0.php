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
if ($installer->tableExists($installer->getTable('virtualpayid/epaybl_client')))
{
	$installer->run("
	Alter TABLE {$installer->getTable('virtualpayid/epaybl_client')} 
	 ADD  `visible_in_stores` varchar(128) default '';
		");
}


$installer->endSetup();
