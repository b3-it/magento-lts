<?php

class Egovs_Acl_Block_Adminhtml_Catalog_Product_Edit extends Mage_Adminhtml_Block_Catalog_Product_Edit
{
	
	
	protected function _prepareLayout()
    {
    	$product = $this->getProduct();
    	
    	$acl = Mage::getSingleton('acl/productacl');
    	
    	$status = $acl->getProductStatusString($product);
    	
    	$canVisit = $acl->testPermission('admin/catalog/products/'.$status.'products');  
    	
      	$canDelete = $acl->testPermission('admin/catalog/products/'.$status.'products/productdelete');
     	$canSave = $acl->testPermission('admin/catalog/products/'.$status.'products/productsave'); 	
        
     
     	
     	if(!$canVisit) return Mage_Adminhtml_Block_Widget::_prepareLayout();
     	
		parent::_prepareLayout();
			
		$this->removeButton($canSave, 'save_button');
		$this->removeButton($canSave, 'save_and_edit_button');
		$this->removeButton($canDelete, 'delete_button');
		$this->removeButton($canSave, 'duplicate_button');
		
		 Mage::dispatchEvent('catalog_product_edit_prepare_layout', array('block' => $this,'product'=>$this->getProduct()));
		
    }
	
	private function removeButton($visible,$alias)
	{
		if(!$visible)
		{
			$this->unsetChild($alias);
		}
	} 
	
	
	

}


