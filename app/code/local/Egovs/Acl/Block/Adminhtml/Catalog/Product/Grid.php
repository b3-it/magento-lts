<?php

class Egovs_Acl_Block_Adminhtml_Catalog_Product_Grid extends Mage_Adminhtml_Block_Catalog_Product_Grid
{
	

    public function setCollection($collection)
    {
        //$collection->addAttributeToSelect('delivery_time');
        

    	$canVisitDisabled = Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/disabledproducts');
    	$canVisitEnabled = Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/enabledproducts');    
    	
    	$acl = Mage::getSingleton('acl/productacl');
    	if($canVisitDisabled && !$canVisitEnabled) $collection->addAttributeToFilter('status',$acl->getDisableStatus());
    	if(!$canVisitDisabled && $canVisitEnabled) $collection->addAttributeToFilter('status',$acl->getEnableStatus());
      
        parent::setCollection($collection);
    }
   
    
   
  protected function _prepareMassaction()
    {
    	$canDelete = Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/disabledproducts/productdelete')
    				|| Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/enabledproducts/productdelete');

    	$canStatus = Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/disabledproducts/productstatus')
    				|| Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/enabledproducts/productstatus');

    	$this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('product');
		
        if($canDelete)
        {
	        $this->getMassactionBlock()->addItem('delete', array(
	             'label'=> Mage::helper('catalog')->__('Delete'),
	             'url'  => $this->getUrl('*/*/massDelete'),
	             'confirm' => Mage::helper('catalog')->__('Are you sure?')
	        ));
        }

        if($canStatus)
        {
	        $statuses = Mage::getSingleton('catalog/product_status')->getOptionArray();
	
	        array_unshift($statuses, array('label'=>'', 'value'=>''));
	        $this->getMassactionBlock()->addItem('status', array(
	             'label'=> Mage::helper('catalog')->__('Change status'),
	             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
	             'additional' => array(
	                    'visibility' => array(
	                         'name' => 'status',
	                         'type' => 'select',
	                         'class' => 'required-entry',
	                         'label' => Mage::helper('catalog')->__('Status'),
	                         'values' => $statuses
	                     )
	             )
	        ));
        }

        $this->getMassactionBlock()->addItem('attributes', array(
            'label' => Mage::helper('catalog')->__('Update attributes'),
            'url'   => $this->getUrl('*/catalog_product_action_attribute/edit', array('_current'=>true))
        ));

        return $this;
    	
    	
    }
}




