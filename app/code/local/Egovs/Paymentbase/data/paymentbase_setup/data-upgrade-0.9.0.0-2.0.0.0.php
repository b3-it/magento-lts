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


$eav = Mage::getResourceModel('eav/entity_attribute');

$hparams = array();
$hparams[] = array('htype'=>Egovs_Paymentbase_Model_Haushaltsparameter_Type::HAUSHALTSTELLE,'att'=>'haushaltsstelle');
$hparams[] = array('htype'=>Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER,'att'=>'objektnummer');
$hparams[] = array('htype'=>Egovs_Paymentbase_Model_Haushaltsparameter_Type::OBJEKTNUMMER_MWST,'att'=>'objektnummer_mwst');
$hparams[] = array('htype'=>Egovs_Paymentbase_Model_Haushaltsparameter_Type::HREF,'att'=>'href');
$hparams[] = array('htype'=>Egovs_Paymentbase_Model_Haushaltsparameter_Type::HREF_MWST,'att'=>'href_mwst');
$hparams[] = array('htype'=>Egovs_Paymentbase_Model_Haushaltsparameter_Type::BUCHUNGSTEXT,'att'=>'buchungstext');
$hparams[] = array('htype'=>Egovs_Paymentbase_Model_Haushaltsparameter_Type::BUCHUNGSTEXT_MWST,'att'=>'buchungstext_mwst');


foreach($hparams as $hparam)
{
	$id = $eav->getIdByCode('catalog_product',$hparam['att']);
	$sql = " update ".$installer->getTable('catalog/product')."_varchar as eavatt ";
	$sql .=" join ".$installer->getTable('paymentbase/haushaltsparameter')." as hparam on  hparam.value = eavatt.value and hparam.type =". $hparam['htype'];
	$sql .=" set eavatt.value = paymentbase_haushaltsparameter_id where attribute_id = ". $id;
	
	$installer->run($sql);
}

//Kundeadresse taxvat => vat_id

$taxvat = $eav->getIdByCode('customer_address','taxvat');
$vat_id = $eav->getIdByCode('customer_address','vat_id');

$sql = "delete from ".$installer->getTable('customer/address_entity')."_varchar where attribute_id= $vat_id";
$installer->run($sql);

$sql  = " update ".$installer->getTable('customer/address_entity')."_varchar";
$sql .= " set attribute_id =  $vat_id WHERE attribute_id = $taxvat";

$installer->run($sql);

$installer->endSetup();