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

$installer->getConnection()
->addColumn(
		$installer->getTable('sales/quote'),
		'is_event_request',
		array(
				'type'     => Varien_Db_Ddl_Table::TYPE_SMALLINT,
				'unsigned' => true,
				'default'  => '0',
				'comment'  => 'Is Quote used with Event Request',
		)
		);

$installer->endSetup(); 