<?php
/**
 * @var $this Mage_Eav_Model_Entity_Setup
 */

$installer = $this;
$installer->startSetup();

$newGroupFound   = FALSE;
$default_methods = serialize(array(
    'egovs_girosolution_giropay',
    'egovs_girosolution_creditcard',
    'bankpayment'
));

$newGroup = array(
    'customer_group_code'     => 'manuelle Prüfung',
    'tax_class_id'            => '7',
    'invoice_template'        => '1',
    'shipping_template'       => '2',
    'creditmemo_template'     => '3',
    'company'                 => '0',
    'taxvat'                  => '0',
    'allowed_payment_methods' => $default_methods,
);


/** @var Mage_Customer_Model_Resource_Group_Collection $groups */
$groups = Mage::getModel('customer/group')->getCollection();

foreach($groups AS $group) {
    $methods = $group->getAllowedPaymentMethods();
    if( strlen($methods) == 0 ) {
        Mage::getModel('customer/group')->load($group->getId())->setData('allowed_payment_methods', $default_methods)->save();
    }
    
    if ( $group->getCustomerGroupCode() == $newGroup['customer_group_code'] ) {
        $newGroupFound = TRUE;
    }
}

//Create Customer Group
if ( $newGroupFound == FALSE ) {
    Mage::getSingleton('customer/group')->setData($newGroup)->save();
    
    $id = $installer->getConnection()->fetchOne("SELECT `customer_group_id` FROM `customer_group` WHERE " .
                                                "`customer_group_code` = '{$newGroup['customer_group_code']}';");
    $this->setConfigData('customer/create_account/viv_error_group', $id);
}

$this->setConfigData('customer/create_account/auto_group_assign', '1');
$this->setConfigData('customer/create_account/vat_frontend_visibility', '1');

$installer->endSetup();
