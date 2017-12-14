<?php
class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Structure extends Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Abstract
{
	protected $_component_model_type = "virtualgeo/components_structure";
	
	public function getTitle()
	{
		return  $this->helper('virtualgeo')->__('Structure');
	}


    public function getOptions($fields = null)
    {
        $fields = array('layer_id');
        return parent::getOptions($fields);
    }
}