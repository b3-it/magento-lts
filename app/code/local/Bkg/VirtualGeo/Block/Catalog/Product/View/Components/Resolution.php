<?php
class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Resolution extends Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Abstract
{
	protected $_component_model_type = "virtualgeo/components_resolution";
	
	public function getTitle()
	{
		return  $this->helper('virtualgeo')->__('Resolution');
	}
}