<?php

$installer = $this;

$installer->startSetup();

/* @var $installer Mage_Eav_Model_Entity_Setup */




		if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/order_payment'), 'given_amount')) {
	
			//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
			$installer->getConnection()->addColumn(
					$installer->getTable('sales/order_payment'),
					'given_amount',
					'DECIMAL(12,4)'
			);
		}
		
		if (!$installer->getConnection()->tableColumnExists($installer->getTable('sales/quote_payment'), 'given_amount')) {
		
			//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
			$installer->getConnection()->addColumn(
					$installer->getTable('sales/quote_payment'),
					'given_amount',
					'DECIMAL(12,4)'
					);
		}

$installer->endSetup();