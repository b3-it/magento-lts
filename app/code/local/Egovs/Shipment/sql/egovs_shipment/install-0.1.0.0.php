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
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Shipping
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

$installer = $this;
/** @var $installer Mage_Core_Model_Resource_Setup */

$installer->startSetup();

/**
 * Create table 'egovsshipment/bulkgoods'
 */

if(!$installer->tableExists('egovsshipment/bulkgoods'))
{
$table = $installer->getConnection()
    ->newTable($installer->getTable('egovsshipment/bulkgoods'))
    ->addColumn('pk', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'identity'  => true,
        'unsigned'  => true,
        'nullable'  => false,
        'primary'   => true,
        ), 'Primary key')
    ->addColumn('website_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '1',
        ), 'Website Id')
    ->addColumn('shipment_group', Varien_Db_Ddl_Table::TYPE_TEXT, 50, array(
        		'nullable'  => false,
        		'default'   => '',
        ), 'Shipment Group')
    ->addColumn('dest_country_id', Varien_Db_Ddl_Table::TYPE_TEXT, 4, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Destination coutry ISO/2 or ISO/3 code')
    ->addColumn('dest_region_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'nullable'  => false,
        'default'   => '0',
        ), 'Destination Region Id')
//     ->addColumn('dest_zip', Varien_Db_Ddl_Table::TYPE_TEXT, 10, array(
//         'nullable'  => false,
//         'default'   => '*',
//         ), 'Destination Post Code (Zip)')
    ->addColumn('qty', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        		'nullable'  => false,
        		'default'   => '0',
        ), 'Number of Items')
    ->addColumn('price', Varien_Db_Ddl_Table::TYPE_DECIMAL, '12,4', array(
        'nullable'  => false,
        'default'   => '0.0000',
        ), 'Price')
    ->addIndex($installer->getIdxName('egovsshipment/bulkgoods', array('website_id', 'dest_country_id', 'dest_region_id', 'shipment_group','price','qty'), Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE),
        array('website_id', 'dest_country_id', 'dest_region_id', 'shipment_group','price','qty'), array('type' => Varien_Db_Adapter_Interface::INDEX_TYPE_UNIQUE))
    ->setComment('Bulkgoods Tablerate');
$installer->getConnection()->createTable($table);

$data = array();
$data[] = array('shipment_group'=>'Bücher', 'dest_country_id'=>'DE', 'dest_region_id'=>'*', 'qty'=>'1', 'price'=>'2');
$data[] = array('shipment_group'=>'Bücher', 'dest_country_id'=>'DE', 'dest_region_id'=>'*', 'qty'=>'6', 'price'=>'4');
$data[] = array('shipment_group'=>'Bücher', 'dest_country_id'=>'DE', 'dest_region_id'=>'*', 'qty'=>'11', 'price'=>'6');
$data[] = array('shipment_group'=>'Bücher', 'dest_country_id'=>'*', 'dest_region_id'=>'*', 'qty'=>'1', 'price'=>'4');
$data[] = array('shipment_group'=>'Bücher', 'dest_country_id'=>'*', 'dest_region_id'=>'*', 'qty'=>'6', 'price'=>'8');
$data[] = array('shipment_group'=>'Bücher', 'dest_country_id'=>'*', 'dest_region_id'=>'*', 'qty'=>'11', 'price'=>'15');
$data[] = array('shipment_group'=>'Normal', 'dest_country_id'=>'DE', 'dest_region_id'=>'*', 'qty'=>'1', 'price'=>'6');
$data[] = array('shipment_group'=>'Normal', 'dest_country_id'=>'*', 'dest_region_id'=>'*', 'qty'=>'1', 'price'=>'15');
$data[] = array('shipment_group'=>'Sperrgut', 'dest_country_id'=>'DE', 'dest_region_id'=>'*', 'qty'=>'0', 'price'=>'6');
$data[] = array('shipment_group'=>'Sperrgut', 'dest_country_id'=>'*', 'dest_region_id'=>'*', 'qty'=>'0', 'price'=>'15');


$installer->getConnection()->insertMultiple($installer->getTable('egovsshipment/bulkgoods'),$data);

}

if (!$installer->getAttribute('catalog_product', 'shipment_group')) {
	$installer->addAttribute('catalog_product', 'shipment_group', array(
			'label' => 'Shipment Group',
			'input' => 'select',
			'type' => 'text',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'visible' => false,
			'required' => false,
			'is_user_defined' => true,
			'searchable' => false,
			'comparable' => false,
			'visible_on_front' => false,
			'visible_in_advanced_search' => false,
			'source'    => 'egovsshipment/entity_attribute_source_shipmentgroup',
			'default' => '1',
			//'option' => $option,
			'group' => 'General',
 			'apply_to' => array(Mage_Catalog_Model_Product_Type::TYPE_SIMPLE, Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE)
	));
}



$installer->endSetup();
