<?php
/* @var $installer Stala_Extcustomer_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->fetchOne("SELECT `code` FROM {$this->getTable('catalog_product_link_type')} WHERE `code` = 'cross_freecopies'")) {
	$installer->run("
	
	insert  into {$this->getTable('catalog_product_link_type')}(`code`) values ('cross_freecopies');
	
	");
}
$installer->endSetup(); 