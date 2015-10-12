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

/*
 * Der Inhalt ist äquivalent zu dem Update von 0.1.6 zu 0.1.7 (Magento 1.6)
 * Notwendig da das Update von 0.1.6 zu 0.1.7 in Magento 1.3 bereits existiert und somit Probleme bei einer Migration auftreten.
 * Siehe Trac #1901
 */

if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'printnote1')) {
	$installer->run("ALTER TABLE `{$installer->getTable('sales/order')}`  ADD `printnote1` varchar(255) default NULL");
}
if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order'), 'printnote2')) {
	$installer->run("ALTER TABLE `{$installer->getTable('sales_flat_order')}`  ADD `printnote2` varchar(255) default NULL");
}

$installer->endSetup();
