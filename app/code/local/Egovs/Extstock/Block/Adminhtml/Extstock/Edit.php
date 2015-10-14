<?php

class Egovs_Extstock_Block_Adminhtml_Extstock_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'extstock';
        $this->_controller = 'adminhtml_extstock';
        
        $this->_updateButton('save', 'label', Mage::helper('extstock')->__('Save Stock Order'));
        $this->_updateButton('delete', 'label', Mage::helper('extstock')->__('Delete Stock Order'));
		$this->removeButton('delete');
		$this->removeButton('add');
		
		try
		{
			$acl = Mage::getSingleton('acl/productacl');
    		$canSave = $acl->testPermission('admin/extstock/extstockorderlist/extstocksave');
		}
		catch(Exception $e)
		{
			$canSave = true;
		}
		
		//if((Mage::registry('extstock_data')->getStatus()== Egovs_Extstock_Helper_Data::DELIVERED)||(!$canSave))
		if(!$canSave)
		{
			$this->removeButton('save');
		}
		
	
		

    }
    public function getSaveUrl()
    {
    	if($this->getIsCalledFromProduct())
    	{
    		return $this->getUrl('adminhtml/extstock_extstock/save_product',array('id'=>$this->getRequest()->getParam('id')));
    	}
    	return $this->getUrl('adminhtml/extstock_extstock/save',array('id'=>$this->getRequest()->getParam('id')));
    }
    
    
	public function processAttributes()
	{
		if($this->getIsCalledFromProduct())
		{
			$this->removeButton('back');
			$this->_addButton('close', array(
					'label'   => Mage::helper('catalog')->__('Close'),
					'onclick' => "window.close();",
			),0,1000);
				
			
			 
		}
	}
    
    
    public function getHeaderText()
    {
        if( Mage::registry('extstock_data') && Mage::registry('extstock_data')->getId() ) {
            return Mage::helper('extstock')->__("Edit Stock Order");//. " " . $this->htmlEscape(Mage::registry('extstock_data')->getDistributor());
        } else {
            return Mage::helper('extstock')->__('Add Stock Order');
        }
    }
}