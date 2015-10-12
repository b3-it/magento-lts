<?php
/**
 * Mustershop
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Egovs
 * @package    Egovs_Base
 * @copyright  Copyright (c) 2014 B3 IT Systeme GmbH (http://www.b3-it.de)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$cmsPages = array(
    array(
        'root_template' => 'three_columns',
        'identifier'    => 'no-route'
    ),
    array(
        'root_template' => 'three_columns',
        'identifier'    => 'home',
        'title'         => 'Startseite'
    ),
    array(
        'root_template' => 'three_columns',
        'identifier'    => 'customer-service'
    ),
    array(
        'root_template' => 'three_columns',
        'identifier'    => 'enable-cookies'
    ),
    array(
        'root_template' => 'three_columns',
        'identifier'    => 'agb'
    ),
    array(
        'root_template' => 'three_columns',
        'identifier'    => 'widerruf'
    )
);

/**
 * Update system pages
 */
foreach ($cmsPages as $data) {
    $model = Mage::getModel('cms/page')->load($data['identifier']);
    if ( $model->isEmpty() ) {
        continue;
    }
    $model->setRootTemplate($data['root_template'])->save();
}

$installer = $this;

/* @var $installer Mage_Customer_Model_Entity_Setup */
$installer->startSetup();

/*
 * Der Inhalt ist äquivalent zu dem Update von 0.1.6 zu 0.1.7 (Magento 1.6)
* Notwendig da das Update von 0.1.6 zu 0.1.7 in Magento 1.3 bereits existiert und somit Probleme bei einer Migration auftreten.
* Siehe Trac #1901
*/
$forms=array('customer_account_edit','customer_account_create','adminhtml_customer','checkout_register');
$att = Mage::getModel('customer/attribute')->loadByCode('customer', 'company');
$att->setData('used_in_forms', $forms)->save();

$entityType = 'customer_address';

$attributeCode = 'web';
$forms=array('adminhtml_customer_address','customer_address_edit');
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '200')->save();

$attributeCode = 'email';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '0')->save();

$attributeCode = 'company2';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '62')->save();

$attributeCode = 'company3';
$att = Mage::getModel('customer/attribute')->loadByCode($entityType, $attributeCode);
if (!$att || $att->isEmpty()) {
	Mage::throwException(sprintf('Attribute code "%s" for "%s" not found!', $attributeCode, $entityType));
}
$att->setData('used_in_forms', $forms)->setData('sort_order', '64')->save();

$installer->endSetup();