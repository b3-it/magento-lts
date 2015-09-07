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


$installer->addAttribute('catalog_product', 'sternchen', array(
		'label' => 'Sternchen',
		'type' => 'int',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => true,
		'is_user_defined' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'frontend_class'             => 'validate-number',
		'default' => '0',
));



$installer->addAttribute('catalog_product', 'slpb_limit', array(
		'label' => 'Limitiert',
		'input' => 'boolean',
		'type' => 'int',
		'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible' => true,
		'required' => false,
		'is_user_defined' => true,
		'searchable' => false,
		'comparable' => false,
		'visible_on_front' => false,
		'visible_in_advanced_search' => false,
		'default' => '0',
));


$attributeId = $installer->getAttribute('catalog_product', 'sternchen', 'attribute_id');
$sortOrder = isset($attr['sort_order']) ? $attr['sort_order'] : null;
$installer->updateAttribute('catalog_product', $attributeId, array('used_in_product_listing' => true), null, $sortOrder);


$installer->endSetup();
