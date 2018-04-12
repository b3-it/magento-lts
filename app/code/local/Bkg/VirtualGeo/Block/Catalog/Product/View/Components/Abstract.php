<?php
abstract class Bkg_VirtualGeo_Block_Catalog_Product_View_Components_Abstract extends Mage_Catalog_Block_Product_View_Abstract
{
	protected $_options = null;

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
    
    public function hasOptions()
    {
    	$opt = $this->getOptions();
    	
    	return count($opt) > 0;
    }

	/**
	 * Erzeugt aus dem Namen des Model-Type eine eindeutige HTML-ID
	 * @access public
	 * @return string  HTML-ID for Element
	 */
	public function getHtmlID()
	{
		return str_replace(array('/', '_'), '-', $this->_component_model_type);
	}
}
