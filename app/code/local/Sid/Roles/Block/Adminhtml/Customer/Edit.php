<?php

class Sid_Roles_Block_Adminhtml_Customer_Edit extends Mage_Adminhtml_Block_Customer_Edit
{
  
    protected function _prepareLayout()
    {
      
    	$p = parent::_prepareLayout();
    	
    	$acl = Mage::getSingleton('acl/productacl');
    	$canSave = $acl->testPermission('admin/customer/sid_manage_customer/customersave');
    	$canDelete = $acl->testPermission('admin/customer/sid_manage_customer/customerdelete');
    	
    	if(!$canSave)
    	{
	    	$p->_removeButton('save');
	    	$p->_removeButton('save_and_continue');
    	}
    	
    	if(!$canDelete)
    	{
    		$p->_removeButton('delete');
    	}
    	
    	Mage::dispatchEvent('customer_edit_prepare_layout', array('block' => $this,'customer'=>Mage::registry('current_customer')));
    	
    	return $p;
    
    }


    protected function _getSaveAndContinueUrl()
    {
        return $this->getUrl('adminhtml/sidroles_customer/save', array(
            '_current'  => true,
            'back'      => 'edit',
            'tab'       => '{{tab_id}}'
        ));
    }
    
    public function getSaveUrl()
    {
    	return $this->getUrl('adminhtml/sidroles_customer/save');
    }
}
