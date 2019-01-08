<?php
class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Georef extends Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Abstract
{
	protected $_component_model_type = "virtualgeo/components_georef";
	
	public function getTitle()
	{
		return  $this->helper('virtualgeo')->__('Coordinate Reference System');
	}
	
	public function getOptions($fields = null)
	{
	    $fields = array('code', 'epsg_code', 'proj4');
	    return parent::getOptions($fields);
	}
}