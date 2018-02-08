<?php
class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Toll extends Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Abstract
{
	protected $_component_model_type = "virtualgeo/components_toll";
	
	public function getTitle()
	{
		return  $this->helper('virtualgeo')->__('Toll');
	}


    public function getOptions($fields = null)
    {
        return array();
    }
    
    /**
     * @return Bkg_Tollpolicy_Model_Tollcategory
     */
    public function getTollCategory() {
        if ($this->_tollcategory === null) {
            $product = $this->getProduct();
            
            $this->_tollcategory = Mage::getModel('bkg_tollpolicy/tollcategory')->load($product->getTollCategory());
        }
        
        return $this->_tollcategory;
    }
}