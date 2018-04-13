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

  
    public function getRefeshComponentContentUrl()
    {
    	return $this->getUrl('*/virtualgeo_components_content_category/refeshComponentContent');
    }

	private function getStoreId()
	{
		$storeId  = $this->getRequest()->getParam('store');
		return intval($storeId);
		
	}
	
	public function getNodes()
	{
		$res = array();
		$product = $this->_getProduct();
		$collection = Mage::getModel('virtualgeo/components_content')->getOptions4Product($product->getId(), $product->getStoreId());
        $collection->getSelect()->order('main_table.pos');
	//	$items = $collection->getItems();
	//die($collection->getSelect()->__toString());
		foreach($collection->getItems() as $item)
		{
			$parent = null;
			if($item->getParentNodeId())
			{
				$parent = $this->_findItem($items,$item->getParentNodeId());
			}
			
			$res[] = new Varien_Object(array('id'=>$item->getId(),
					'label'=>trim($item->getName()." " . $item->getDescription()) ,
					'entity_id'=>$item->getEntityId(),
					'is_readonly'=>boolval($item->getReadonly()),
					'is_checked'=>boolval($item->getIsChecked()) ,
					'pos' =>$item->getPos(),
					'parent' => $parent != null? $parent->getComponentProductRelationId() : ''
			));
		}
		
		
		return $res;
	}
	
	protected function _findItem($items,$component_product_relation_id)
	{
		foreach ($items as $item)
		{
			if($item->getComponentProductRelationId() == $component_product_relation_id)
			{
				return $item;
			}
		}
		
		return null;
	}
	
	/**
	 * Retirve currently edited product model
	 *
	 * @return Mage_Catalog_Model_Product
	 */
	protected function _getProduct()
	{
		return Mage::registry('current_product');
	}
	
// 	private function getProduct()
// 	{
// 		$product = Mage::registry('product');
// 		if($product)
// 		{
// 			return $product;
// 		}
		
// 		if($this->getData('product_id')!= null)
// 		{
// 			$product = Mage::getModel('catalog/product')->load('product_id');
// 			$product->setStoreId($this->getStoreId());
// 			return $product;
// 		}
	
		
// 		return null;
// 	}
	
	public function getFieldsAvail()
	{
		$fields = array();//Mage::getConfig()->getNode('global/eventbundle_personal/fields')->asArray();
		return $fields;
	}
	
}
