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
        /*
         * Erst nach ID, dann nach POS! Sonst wird child vor parent in Tree eingefügt!
         */
		$collection->getSelect()->order('main_table.id');
		$collection->getSelect()->order('main_table.pos');
        $items = $collection->getItems();

		foreach ($items as $item) {
			$parent = null;
			if ($item->getParentNodeId()) {
				$parent = $this->_findItem($items, $item->getParentNodeId());
			}
			
			$res[] = new Varien_Object(
			        array(
			            'id'=>$item->getId(),
					    'label'=>trim($item->getName()." " . $item->getDescription()) ,
					    'entity_id'=>$item->getEntityId(),
					    'is_readonly'=>boolval($item->getReadonly()),
					    'is_checked'=>boolval($item->getIsChecked()) ,
					    'pos' =>$item->getPos(),
					    'node_id' => $item->getNodeId(),
					    'parent' => $parent != null ? $parent->getId() : ''
			        )
            );
		}
		
		
		return $res;
	}
	
	protected function _findItem($items, $parentId) {
		foreach ($items as $item) {
			if ($item->getNodeId() == $parentId) {
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
