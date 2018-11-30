<?php
/**
 * 
 *  Die Karte für das Produkt als Block
 *  @category Egovs
 *  @package  Bkg_Viewer_Block_Catalog_Product_View
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Catalog_Product_View extends Mage_Catalog_Block_Product_View
{
	
	public function hasComposit($_product)
	{
		$flag = $_product->getGeocomposit();
		return (!empty($flag));
	}
	
 	
}
