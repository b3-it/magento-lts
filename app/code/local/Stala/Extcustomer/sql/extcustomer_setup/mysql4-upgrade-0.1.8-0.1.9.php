<?php
/**
 * Magento 1.6 hat eigene Attribute für Form Elements
 * 
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @author     	Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
	$installer->startSetup();

	$installer->updateAttribute('customer', 'discount_quota', 'frontend_model', 'extcustomer/customer_attribute_frontend_discount');

	$installer->endSetup(); 
}