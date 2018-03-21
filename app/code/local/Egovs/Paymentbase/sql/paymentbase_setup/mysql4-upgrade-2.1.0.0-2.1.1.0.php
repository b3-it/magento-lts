<?php
/**
 * Eigener Reiter für ePayBL
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2016 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

/**
 * @var Egovs_Paymentbase_Model_Resource_Setup $installer
 */
$installer = $this;

$installer->startSetup();

$entityTypeId = 'order_payment';
$attributeId = 'pay_client'; //Mandant

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
    //since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
    $installer->getConnection()->addColumn(
        $installer->getTable('sales/order_payment'),
        $attributeId,
        'varchar(255)'
    );
}

$attributeId = 'pay_operator'; //Bewirtschafter

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
    //since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
    $installer->getConnection()->addColumn(
        $installer->getTable('sales/order_payment'),
        $attributeId,
        'varchar(255)'
    );
}

$installer->endSetup();