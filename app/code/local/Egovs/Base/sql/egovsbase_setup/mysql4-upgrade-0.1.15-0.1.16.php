<?php
/**
 * Magento
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
 * @category   Mage
 * @package    Mage_Customer
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;

/* @var $installer Mage_Customer_Model_Entity_Setup */
$installer->startSetup();

if (!$installer->getAttribute('customer', 'base_addrress')) {
	$installer->addAttribute('customer', 'base_address', array(
			'label' => 'Stammadresse',
			'type' => 'int',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => false,
			'required' => false,
	));
}

if (!$installer->getAttribute('customer_address', 'taxvat')) {
	$installer->addAttribute('customer_address', 'taxvat', array(
			'label' => 'Steuernummer / USt. ID',
			'type' => 'varchar',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => false,
			'required' => false,
	));
}

$forms=array('adminhtml_customer_address','customer_address_edit','customer_account_create', 'customer_register_address');
$att = Mage::getModel('customer/attribute')->loadByCode('customer_address', 'taxvat');
$att->setData('used_in_forms', $forms)->setData('sort_order', '300')->save();

$installer->endSetup();
