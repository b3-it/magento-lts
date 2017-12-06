<?php
/**
 * 
 * @author h.koegel
 *
 */

class Bkg_VirtualGeo_Block_Adminhtml_Catalog_Product_Edit_Tab_Content_Layer extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('bkg/virtualgeo/product/edit/tab/content/layer.phtml');
       
    }

    
    //alle verfügbaren PersonalOptions für das Produkt finden 
	public function getFields()
	{
		return array();
	}

	private function getStoreId()
	{
		$storeId  = $this->getRequest()->getParam('store');
		return intval($storeId);
		
	}
	
	public function getNodes()
	{
		return array();
	}
	
	
	private function getProduct()
	{
		$product = Mage::registry('product');
		if($product)
		{
			return $product;
		}
		
		if($this->getData('product_id')!= null)
		{
			$product = Mage::getModel('catalog/product')->load('product_id');
			$product->setStoreId($this->getStoreId());
			return $product;
		}
	
		
		return null;
	}
	
	public function getFieldsAvail()
	{
		$fields = array();//Mage::getConfig()->getNode('global/eventbundle_personal/fields')->asArray();
		return $fields;
	}
	
}
