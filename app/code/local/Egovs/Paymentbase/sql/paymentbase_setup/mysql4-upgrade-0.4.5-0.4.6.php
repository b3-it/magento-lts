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
$installer = $this;

$installer->startSetup();

if (!$installer->getConnection()->isTableExists($installer->getTable('egovs_paymentbase_objektnummer_hhstelle'))) {
	$installer->run("
	-- DROP TABLE IF EXISTS {$this->getTable('egovs_paymentbase_objektnummer_hhstelle')};
	CREATE TABLE {$this->getTable('egovs_paymentbase_objektnummer_hhstelle')} (
	  `paymentbase_objektnummer_hhstelle_id` int(11) unsigned NOT NULL auto_increment,
	  `objektnummer` int(11) unsigned NOT NULL,
	  `hhstelle` int(11) unsigned NOT NULL,
	  FOREIGN KEY (`objektnummer`) REFERENCES `egovs_paymentbase_haushaltsparameter`(`paymentbase_haushaltsparameter_id`) ON DELETE CASCADE,
	  FOREIGN KEY (`hhstelle`) REFERENCES `egovs_paymentbase_haushaltsparameter`(`paymentbase_haushaltsparameter_id`) ON DELETE CASCADE,
	  PRIMARY KEY (`paymentbase_objektnummer_hhstelle_id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8;
	");
}

	$params = array();
	$params[] = 'objektnummer';
	$params[] = 'objektnummer_mwst';

	
	foreach ($params as $param) {
		$installer->updateAttribute('catalog_product',$param,'backend_model','paymentbase/attributes_backend_objektnummerhhstelle');
	}


$installer->endSetup();