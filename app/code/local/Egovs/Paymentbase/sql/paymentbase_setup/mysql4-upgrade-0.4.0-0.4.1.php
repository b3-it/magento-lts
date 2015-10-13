<?php

$installer = $this;

$installer->startSetup();

if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
	if (!$installer->getAttribute('order_payment', 'paywithinxdays')) {
		$installer->addAttribute('order_payment', 'paywithinxdays', array(
		    'label' => 'paywithinxdays',
		    'input' => 'int',
		    'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		    'visible' => false,
		    'required' => false,
		    'user_defined' => true,
		    'searchable' => false,
		    'comparable' => false,
		    'visible_on_front' => false,
		    'visible_in_advanced_search' => false,
		    'default' => '14',
		));
	}
} else {
	//since 1.4.1 : Refactored Sales module resource from EAV into flat structure.
	$installer->getConnection()->addColumn(
			$installer->getTable('sales/order_payment'),
			'paywithinxdays',
			'integer default 14'
	);
}

$select = $this->getConnection()->quoteInto("SELECT COLUMN_NAME FROM information_schema.COLUMNS WHERE COLUMN_NAME='paywithinxdays' AND TABLE_NAME=? AND TABLE_SCHEMA=DATABASE()",
		$installer->getTable('sales_flat_quote_payment')
);
$result = $this->getConnection()->fetchOne($select);
if (empty($result)) {
	$installer->run("
		ALTER TABLE `{$installer->getTable('sales_flat_quote_payment')}` 
	   	ADD `paywithinxdays` int(10) unsigned default 0
	");
}

$installer->endSetup();