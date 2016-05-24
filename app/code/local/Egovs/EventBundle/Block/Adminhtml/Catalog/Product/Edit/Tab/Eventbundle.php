<?php
/**
 * 
 * */
class Egovs_EventBundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Eventbundle extends Mage_Bundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Bundle
{
 
    public function getTabLabel()
    {
        return Mage::helper('eventbundle')->__('Event Bundle Items');
    }
    public function getTabTitle()
    {
        return Mage::helper('eventbundle')->__('Event Bundle Items');
    }
    
    public function getTabUrl()
    {
    	return $this->getUrl('adminhtml/eventbundle_product_edit/form', array('_current' => true));
    }
    
    protected function _prepareLayout()
    {
    	$this->setChild('add_button',
    			$this->getLayout()->createBlock('adminhtml/widget_button')
    			->setData(array(
    					'label' => Mage::helper('bundle')->__('Add New Option'),
    					'class' => 'add',
    					'id'    => 'add_new_option',
    					'on_click' => 'bOption.add()'
    			))
    	);
    	
    	 $this->setChild('options_box',
    	 $this->getLayout()->createBlock('eventbundle/adminhtml_catalog_product_edit_tab_option',
    	 'adminhtml.catalog.product.edit.tab.bundle.option')
    	 );
    	 
    	 
    	
    	return Mage_Adminhtml_Block_Widget::_prepareLayout();
    }
   
}
