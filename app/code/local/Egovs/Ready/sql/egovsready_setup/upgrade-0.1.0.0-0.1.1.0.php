<?php
/**
 *
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package			Egovs_Ready
 * @name            Egovs_Ready_Block_Catalog_Product_Price
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;
$installer->startSetup();

$installer->run("delete FROM ".$installer->getTable('core/config_data')." where path like 'payment/paypal%'");
$installer->run("delete FROM ".$installer->getTable('core/config_data')." where path like 'payment/payflow%'");
$installer->run("delete FROM ".$installer->getTable('core/config_data')." where path like 'payment/authorizenet_%'");
$installer->run("delete FROM ".$installer->getTable('core/config_data')." where path like 'payment/verisign/%'");
$installer->run("delete FROM ".$installer->getTable('core/config_data')." where path like 'payment/ccsave/%'");
$installer->run("delete FROM ".$installer->getTable('core/config_data')." where path like 'payment/banktransfer/%'");
$installer->run("delete FROM ".$installer->getTable('core/config_data')." where path like 'payment/cashondelivery/%'");
$installer->run("delete FROM ".$installer->getTable('core/config_data')." where path like 'payment/purchaseorder/%'");
$installer->endSetup();