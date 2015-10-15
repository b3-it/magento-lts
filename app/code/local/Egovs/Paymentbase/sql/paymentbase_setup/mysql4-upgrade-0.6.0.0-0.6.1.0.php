<?php
/**
 * Resource Collection für Haushaltsparameter.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
$installer = $this;

$installer->startSetup();

/* @var $installer Mage_Eav_Model_Entity_Setup */
$entityTypeId = 'order_payment';
$attributeId = Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID;
if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
	if (!$installer->getAttribute($entityTypeId, $attributeId)) {
		/*
		 * Falls user_defined => true benutzt wird, muss ein Attributset bzw. eine Gruppe angegeben werden.
		 * Falls user_defined => false so wird es in alle Attributsets integriert (Gruppe: General)
		 */	
		$installer->addAttribute($entityTypeId, $attributeId, array(
			    'label' => 'SEPA Mandate ID',
			    'input' => 'text',
			    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			    'visible' => true,
			    'required' => false,
			    'user_defined' => false,
			    'searchable' => false,
			    'comparable' => false,
			    'visible_on_front' => false,
			    'visible_in_advanced_search' => false,
			    'default' => '0',
			)
		);
	}
} else {
	if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), $attributeId)) {
		
		//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
		$installer->getConnection()->addColumn(
				$installer->getTable('sales/order_payment'),
				$attributeId,
				'varchar(255)'
		);
	}
}

$tableName = 'paymentbase/sepa_mandate_history';
if (!$installer->tableExists($tableName)) {
	$table = $installer->getConnection()
		->newTable($installer->getTable($tableName))
				->addColumn('entity_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
						'identity'  => true,
						'unsigned'  => true,
						'nullable'  => false,
						'primary'   => true,
				), 'Entity ID')
				->addColumn('customer_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(), 'Kunden ID')
				->addColumn(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID, Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(), 'Mandatsreferenz')
				->addColumn(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID, Varien_Db_Ddl_Table::TYPE_VARCHAR, 255, array(), 'epayBL Kundennummer')
				->addColumn('created_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'Created at')
				->addColumn('updated_at', Varien_Db_Ddl_Table::TYPE_DATETIME, null, array(), 'Updated at')
				->addIndex($installer->getIdxName($tableName,'customer_id'), array('customer_id'))
				->addIndex($installer->getIdxName($tableName,Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID), array(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID))
			
	;
	$installer->getConnection()->createTable($table);
}


$installer->endSetup();