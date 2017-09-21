<?php
/**
 * @var $this Mage_Eav_Model_Entity_Setup
 */

$installer = $this;
$installer->startSetup();

$default_methods = 'a:3:{i:0;s:26:"egovs_girosolution_giropay";i:1;s:29:"egovs_girosolution_creditcard";i:2;s:11:"bankpayment";}';

$group_settings = array(
    'Geschäftskunden DE' => array(
        'company' => 1,
        'taxvat'  => 2,
        'allowed_payment_methods' => $default_methods
    ),
    'Geschäftskunden Drittland' => array(
        'company' => 1,
        'taxvat'  => 2,
        'allowed_payment_methods' => $default_methods
    ),
    'Geschäftskunden EU mit USt-ID' => array(
        'company' => 1,
        'taxvat'  => 2,
        'allowed_payment_methods' => $default_methods
    ),
    'Geschäftskunden EU ohne USt-ID' => array(
        'company' => 1,
        'taxvat'  => 0,
        'allowed_payment_methods' => $default_methods
    ),
    'Privatkunden DE/EU' => array(
        'company' => 0,
        'taxvat'  => 0,
        'allowed_payment_methods' => $default_methods
    ),
    'Privatkunden Drittland' => array(
        'company' => 0,
        'taxvat'  => 0,
        'allowed_payment_methods' => $default_methods
    ),
);

/** @var Mage_Customer_Model_Resource_Group_Collection $groups */
$groups = Mage::getResourceModel('customer/group_collection')->load();

foreach($groups AS $group) {
    $code = $group->getCustomerGroupCode();
    Mage::getModel('customer/group')->load($group->getId())->setData($group_settings[$code])->save();
}

$this->setConfigData('customer/create_account/email_domain', 'mailserver.tu-freiberg.de');

$installer->endSetup();
