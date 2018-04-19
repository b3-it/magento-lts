<?php
class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Storage extends Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Abstract
{
	protected $_component_model_type = "virtualgeo/components_storage";
	
	public function getTitle()
	{
		return  $this->helper('virtualgeo')->__('Storage');
	}

    public function getOptions($fields = null)
    {
        if($this->_options == null)
        {
            $productId = $this->getProduct()->getId();
            $storeId = Mage::app()->getStore()->getId();

            /** @var Bkg_VirtualGeo_Model_Resource_Components_Componentproduct_Collection $collection */
            $collection = Mage::getModel($this->_component_model_type.'product')->getCollection();
            $collection->addComponentToSelect($this->_component_model_type,$productId,$storeId,$fields);
            $collection->addVirtualGeoBundleSelection($productId, $collection->getResourceModelName());
            $collection->getSelect()->where("main_table.is_visible_only_in_admin = 0");
            //die($collection->getSelect()->__toString());
            $this->_options = $collection->getItems();
        }
        return $this->_options;
    }
}