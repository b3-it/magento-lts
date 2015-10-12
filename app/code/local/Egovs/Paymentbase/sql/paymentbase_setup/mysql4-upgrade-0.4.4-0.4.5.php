<?php
/**
 * Resource Collection für Haushaltsparameter.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 -2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/*
 * Paymentbase liegt in 2 Versionen vor, branches/dwd und branches/magento1.6.
 * Die Integration der Auswählbaren Haushalsparameter und der ePayBL Customer ID fand in den beiden Bereichen jedoch in Version 0.4.4 statt.
 * Daher ist diese Version notwendig um per Update das System automatisch auf den gleichen Stand zu bringen.
 */
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->isTableExists($installer->getTable('egovs_paymentbase_haushaltsparameter'))) {
	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('egovs_paymentbase_haushaltsparameter')};
	CREATE TABLE {$this->getTable('egovs_paymentbase_haushaltsparameter')} (
	  `paymentbase_haushaltsparameter_id` int(11) unsigned NOT NULL auto_increment,
	  `title` varchar(255) NOT NULL default '',
	  `value` varchar(255) NOT NULL default '',
	  `type` smallint(6) NOT NULL default '0',
	  `created_time` datetime NULL,
	  `update_time` datetime NULL,
	  PRIMARY KEY (`paymentbase_haushaltsparameter_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}	
	$params = array();
	$params[] = 'haushaltsstelle';
	$params[] = 'objektnummer';
	$params[] = 'objektnummer_mwst';
	$params[] = 'href';
	$params[] = 'href_mwst';
	$params[] = 'buchungstext';
	$params[] = 'buchungstext_mwst';

	foreach ($params as $param) {
		$installer->updateAttribute('catalog_product',$param,'source_model','paymentbase/attributes_source_'.str_replace('_','',$param));
		$installer->updateAttribute('catalog_product',$param,'frontend_input','select');
	}


if (!$installer->getAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID)) {
	$installer->addAttribute('customer', Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID, array(
			'label' => 'ePayBL Customer ID',
			'type' => 'varchar',
			'global' => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			'frontend' => 'paymentbase/customer_attribute_frontend_readonly',
			'visible' => true,
			'group' => 'general',
			'required' => false,
			'user_defined' => false,
			'default' => '0',
			'sort_order' => 10,
	));

	if (version_compare(Mage::getVersion(), '1.4.1', '>=')) {
		$installer->installCustomerForms(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID, array('adminhtml_only' => true));
	}
}

$installer->endSetup();