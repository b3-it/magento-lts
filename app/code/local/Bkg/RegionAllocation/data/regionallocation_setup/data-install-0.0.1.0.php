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
/* @var $this Egovs_Paymentbase_Model_Resource_Setup */
$installer = $this;

$fieldList = array(
		'haushaltsstelle',
		'objektnummer',
		'objektnummer_mwst',
		'href',
		'href_mwst',
		'buchungstext',
		'buchungstext_mwst',
		'tax_class_id'
);


$productList = array(
		'regionallocation',
);

foreach ($fieldList as $field) {
	$applyTo = explode(',', $installer->getAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to'));
	foreach ($productList as $product) {
		if (!in_array($product, $applyTo)) {
			$applyTo[] = $product;
		}
	}
	$installer->updateAttribute(Mage_Catalog_Model_Product::ENTITY, $field, 'apply_to', implode(',', $applyTo));
}

$kst = Mage::getModel('regionallocation/koenigsteinerschluessel_kst');
$kst->setName('2016')
	->setActive(true)
	->save();

//$regionPortions = array('BW'=>'0,1296662','BY'=>'0,1553327','BE'=>'0,0508324','BB'=>'0,0303655','HB'=>'0,0095331','HH'=>'0,0255752','HE'=>'0,0739885','MV'=>'0,020124','NI'=>'0,0933138','NRW'=>'0,2114424','RP'=>'0,0483089','SL'=>'0,0121111','SN'=>'0,0505577','ST'=>'0,0279941','SH'=>'0,0339074','TH'=>'0,026947');
$regionPortions = array('BW'=>'12,96662', 'BY'=>'15,53327', 'BE'=>'5,08324', 'BB'=>'3,03655', 'HB'=>'0,95331', 'HH'=>'2,55752', 'HE'=>'7,39885', 'MV'=>'2,01240', 'NI'=>'9,33138', 'NRW'=>'21,14424', 'RP'=>'4,83089', 'SL'=>'1,21111', 'SN'=>'5,05577', 'ST'=>'2,79941', 'SH'=>'3,39074', 'TH'=>'2,69470');

foreach( $regionPortions as $k=>$v)
{
	$kstv = Mage::getModel('regionallocation/koenigsteinerschluessel_kstvalue');
	$kstv->setRegion($k)
		->setPortion($v)
		->setKstId($kst->getId())
		->setHasTax('0');
	if($k == 'BW'){
		$kstv->setHasTax('1');
	}
	$kstv->save();
}
	

