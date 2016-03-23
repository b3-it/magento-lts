<?php
/**
 *
 * Umwandeln von Haushaltsparametern an Produkten
 * am Magento 1.9 wird die ID am Produkt gespeichert
 *
 * @category        Egovs
 * @package         Egovs_Paymentbase
 * @author 			Holger Kögel <h.koegel@b3-it.de> 
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;


$params = array();
	$params[] = array('attr' =>'haushaltsstelle', 'id' => Egovs_Paymentbase_Model_Haushaltsparameter_Type::HAUSHALTSTELLE);
	$params[] = array('attr' =>'objektnummer', 'id' => Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER);
	$params[] = array('attr' =>'objektnummer_mwst', 'id' => Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER_MWST);
	$params[] = array('attr' =>'href', 'id' => Egovs_Paymentbase_Model_Haushaltsparameter_Type::HREF);
	$params[] = array('attr' =>'href_mwst', 'id' => Egovs_Paymentbase_Model_Haushaltsparameter_Type::HREF_MWST);
	$params[] = array('attr' =>'buchungstext', 'id' => Egovs_Paymentbase_Model_Haushaltsparameter_Type::BUCHUNGSTEXT);
	$params[] = array('attr' =>'buchungstext_mwst', 'id' => Egovs_Paymentbase_Model_Haushaltsparameter_Type::BUCHUNGSTEXT_MWST);

	foreach ($params as $param) {
		$attribute = $installer->getAttribute('catalog_product', $param['attr']);
		$tableProduct = $installer->getTable('catalog/product')."_varchar";
		$tableHH = $installer->getTable('egovs_paymentbase_haushaltsparameter');
		
		$sql = array();
		$sql[] = "UPDATE $tableProduct p";
		$sql[] = "JOIN $tableHH h ON h.value = p.value AND h.type=".$param['id'];
		$sql[] = "SET p.value = h.paymentbase_haushaltsparameter_id";
		$sql[] = "WHERE p.attribute_id =  " .$attribute['attribute_id'];
		
		$sql = implode(' ',$sql);
		//die($sql);
		$installer->run($sql);
	}


$installer->endSetup();