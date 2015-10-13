<?php
/**
 *
 *-- TODO:: kurze Beschreibung --
 *
 *
 *
 * @category        Egovs
 * @package         Egovs_Ready
 * @name            Egovs_Ready_Helper_Data
 * @author 			Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright      	Copyright (c) 2010 - 2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license        	http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/* @var $installer Mage_Catalog_Model_Resource_Setup */
$installer = $this;

$installer->updateAttribute('customer_address', 'postcode', 'data_model', 'paymentbase/attributes_data_postcode');


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



/*
update catalog_product_entity_varchar as eavatt
join egovs_paymentbase_haushaltsparameter as hparam on  hparam.value = eavatt.value and hparam.type = 1
set eavatt.value = paymentbase_haushaltsparameter_id
where attribute_id = 152*/