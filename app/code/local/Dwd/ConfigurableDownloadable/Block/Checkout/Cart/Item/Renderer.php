<?php
/**
 * Shopping cart downloadable item render block
 * 
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Block_Checkout_Cart_Item_Renderer extends Mage_Checkout_Block_Cart_Item_Renderer
{

   public function getStation($item)
   {
	   	if ($item->getStationId()) {
	   		$station = Mage::getModel('stationen/stationen')->load($item->getStationId());
	   		return $station;
	   	}
	   	return "";
   } 

   public function getPeriode($item) {
	   	if ($item->getPeriodId()) {
	   		$periode = Mage::getModel('periode/periode')->load($item->getPeriodId());
	   		return $periode;
	   	}
	   	return "";
   } 
}
