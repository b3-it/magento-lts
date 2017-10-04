<?php

/* @var $this Mage_Core_Model_Resource_Setup */
$installer = $this;
$installer->startSetup();

$settingTableName = $installer->getTable('b3it_modelhistory/history_settings');

if (!$installer->tableExists($settingTableName)) {
    $table = $installer->getConnection()
    ->newTable($settingTableName)
    ->addColumn('id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
        'unsigned' => true,
        'nullable' => false,
        'primary' => true,
        'identity' => true
    ), 'ID')
    // the class name of the model
    ->addColumn('model', Varien_Db_Ddl_Table::TYPE_TEXT, 255, array(
        'nullable' => false
    ))
    // the class name of the model
    ->addColumn('blocked', Varien_Db_Ddl_Table::TYPE_BOOLEAN, null, array(
        'nullable' => false
    ));
    
    $installer->getConnection()->createTable($table);
    
    // Default tables to ignore
    $data = array(
        array('Mage_Sales_Model_Abstract', '1'),
        array('Mage_Sales_Model_Order_Item', '1'),
        array('Mage_Sales_Model_Quote', '1'),
        array('Mage_Sales_Model_Quote_Item_Abstract', '1'),
        array('Mage_Sales_Model_Quote_Item_Option', '1'),
        array('Mage_Sales_Model_Order_Invoice_Item', '1'),
        array('Mage_Sales_Model_Order_Shipment_Item', '1'),
        array('Mage_Payment_Model_Info', '1'),
        array('Mage_Downloadable_Model_Link_Purchased_Item', '1'),
        array('Mage_CatalogInventory_Model_Stock_Item', '1'),
        array('Mage_CatalogIndex_Model_Catalog_Index_Flag', '1'),
        array('B3it_ModelHistory_Model_History', '1'),
        array('B3it_ModelHistory_Model_Config', '1'),
        array('B3it_ModelHistory_Model_Settings', '1'),
        array('Mage_Index_', '1')
    );
    
    $installer->getConnection()->insertArray($settingTableName, array("model", "blocked"), $data);
}
$installer->endSetup();