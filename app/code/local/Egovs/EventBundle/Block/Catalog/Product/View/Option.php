<?php
/**
 * 
 *  Produkt-Detailansicht; Überschreibt Bundle um die Verfügbarkeit als ProductStockAlert abzuspeichern 
 *  @category Egovs
 *  @package  Egovs_EventBundle
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_EventBundle_Block_Catalog_Product_View_Option extends Mage_Bundle_Block_Catalog_Product_View_Type_Bundle_Option
{
 	public function isInStock($item)
 	{
 		$item = Mage::helper('eventbundle')->loadStockItem($item);
 		$res = $item->getStockItem()->getIsInStock();
 		return $res;
 	}
 	
 	public function getOutOfStockLabel($item = null)
 	{
 		return " ". Mage::helper('eventbundle')->__('(not available at the moment! Select this option if you want to be informed as it is available again!)');
 	}
 	
}
