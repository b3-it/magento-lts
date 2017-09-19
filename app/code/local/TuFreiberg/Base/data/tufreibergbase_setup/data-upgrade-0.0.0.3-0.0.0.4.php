<?php
/**
 * @var $this Mage_Eav_Model_Entity_Setup
 */

$installer = $this;
$installer->startSetup();

$default_methods = 'a:3:{i:0;s:26:"egovs_girosolution_giropay";i:1;s:29:"egovs_girosolution_creditcard";i:2;s:11:"bankpayment";}';

/** @var Mage_Customer_Model_Resource_Group_Collection $groups */
$groups = Mage::getResourceModel('customer/group_collection')->load();

foreach($groups AS $group) {
    Mage::getModel('customer/group')->load($group->getId())->setData('allowed_payment_methods', $default_methods)->save();
}

$this->setConfigData('customer/create_account/email_domain', 'mailserver.tu-freiberg.de');

$installer->endSetup();
