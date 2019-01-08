<?php
class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Map extends Mage_Catalog_Block_Product_View_Abstract
{

   
	/**
	 * Erzeugt aus dem Namen des Model-Type eine eindeutige HTML-ID
	 * @access public
	 * @return string  HTML-ID for Element
	 */
	public function getHtmlID()
	{
		return 'title-virtualgeo-components-map';
	}
	
	
	public function getTitle()
	{
		return Mage::helper('virtualgeo')->__('Map');
	}
}
