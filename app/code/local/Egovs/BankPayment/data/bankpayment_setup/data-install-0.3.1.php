<?php
/**
 * Setup für Zahlungen per Vorkasse
 *
 * @category   	Egovs
 * @package    	Egovs_BankPayment
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/* @var $installer Mage_Eav_Model_Entity_Setup */
$installer = $this;

if (version_compare(Mage::getVersion(), '1.5.0', '<')) {
	return;
}

$installer->getConnection()->beginTransaction();

$data = Mage::getModel('bankpayment/system_config_source_order_status')->getArrayFromConfigNode('status');
$exists = $installer->getConnection()->fetchOne(
		"SELECT `status` FROM  {$installer->getTable('sales/order_status')} WHERE `status` = {$installer->getConnection()->quote($data[0]['status'])}"
);
if (!empty($exists)) {
	$installer->getConnection()->commit();
	return;
}

$installer->getConnection()->insertArray(
	$installer->getTable('sales/order_status'),
	array('status', 'label'),
	$data
);

$installer->getConnection()->update(
	$installer->getTable('sales/order_status_state'),
	array('is_default' => '0'),
	array('state = ?' => Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, 'is_default = ?' => 1)
);

$default = $data[0]['status'];
$data = array(array(
	'status' => $default,
	'state' => Mage_Sales_Model_Order::STATE_PENDING_PAYMENT,
	'is_default' => 1
));
$installer->getConnection()->insertArray(
	$installer->getTable('sales/order_status_state'),
	array('status', 'state', 'is_default'),
	$data
);

$installer->getConnection()->commit();