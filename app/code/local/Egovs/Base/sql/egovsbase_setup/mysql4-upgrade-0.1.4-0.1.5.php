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

$installer->addAttribute('order', 'printnote1', array(
    'label'        => 'Print Note 1',
    'visible'      => 1,
    'required'     => 0,
    'position'     => 1,
	'sort_order'   => 31,
	'type'		   => 'static'
));

$installer->addAttribute('order', 'printnote2', array(
    'label'        => 'Print Note 2',
    'visible'      => 1,
    'required'     => 0,
    'position'     => 1,
	'sort_order'   => 32,
	'type'		   => 'static'
));


$installer->endSetup();