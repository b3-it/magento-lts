<?php
/**
  *
  * @category   	Bkg License
  * @package    	Bkg_License
  * @name       	Bkg_License Installer
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */

/**
 * @var Mage_Catalog_Model_Resource_Setup $installer
 */
$installer = $this;

$installer->startSetup();


$columnName = 'license_id';
$tableName = 'sales/quote_item';
if (!$installer->getConnection()->tableColumnExists($installer->getTable($tableName), $columnName)) {
    $installer->getConnection()->addColumn($installer->getTable($tableName), $columnName, array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => true,
        'default' => 0,
        'comment' => 'Lizence ID'
    ));
    $installer->getConnection()->addForeignKey(
            $installer->getFkName($tableName, $columnName, $tableName, 'id'),
        $installer->getTable($tableName), $columnName,$installer->getTable('bkg_license/copy_period'), 'id' , Varien_Db_Ddl_Table::ACTION_SET_NULL
        )
    ;
}

$tableName = 'sales/order_item';
if (!$installer->getConnection()->tableColumnExists($installer->getTable($tableName), $columnName)) {
    $installer->getConnection()->addColumn($installer->getTable($tableName), $columnName, array(
        'type' => Varien_Db_Ddl_Table::TYPE_INTEGER,
        'nullable' => true,
        'default' => 0,
        'comment' => 'Lizence ID'
    ));
    $installer->getConnection()->addForeignKey(
        $installer->getFkName($tableName, $columnName, $tableName, 'id'),
        $installer->getTable($tableName), $columnName,$installer->getTable('bkg_license/copy_period'), 'id' , Varien_Db_Ddl_Table::ACTION_SET_NULL
    )
    ;
}

$installer->endSetup();
