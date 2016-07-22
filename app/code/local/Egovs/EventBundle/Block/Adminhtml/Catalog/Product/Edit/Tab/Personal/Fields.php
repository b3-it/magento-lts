<?php
/**
 * 
 * @author h.koegel
 *
 */

class Egovs_EventBundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Personal_Fields extends Mage_Adminhtml_Block_Widget
{
    public function __construct()
    {
        parent::__construct();
        $this->setTemplate('egovs/eventbundle/product/edit/tab/personal/fields.phtml');
       
    }

    
    //alle verfügbaren PersonalOptions für das Produkt finden 
	public function getFields()
	{
		$product = $this->getProduct();
		if($product)
		{
			if($product->getPersonalOptions() == null){
				$collection = Mage::getModel('eventbundle/personal_option')->getCollection();
				$collection->getSelect()
					->where('product_id='.$product->getId())
					->order('pos');
				$collection->setStoreId($product->getStoreId());
				$product->setPersonalOptions($collection->getItems());
			}
			return $product->getPersonalOptions() ;
		}
		return array();
	}

	private function getStoreId()
	{
		$storeId        = $this->getRequest()->getParam('store');
		return $storeId;
		
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
		$fields = Mage::getConfig()->getNode('global/eventbundle_personal/fields')->asArray();
		return $fields;
	}
	
}
