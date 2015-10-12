<?php

class Slpb_Extstock_Block_Adminhtml_Journal_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
		
    public function __construct()
    {
    	
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'extstock';
        $this->_controller = 'adminhtml_journal';
        
        //$this->_updateButton('save', 'label', Mage::helper('extstock')->__('Save Stock Order'));
        //$this->_updateButton('delete', 'label', Mage::helper('extstock')->__('Delete Stock Order'));
		$this->removeButton('delete');
		$this->removeButton('add');
		$this->removeButton('reset');
		
		try
		{
			$acl = Mage::getSingleton('acl/productacl');
    		$canSave = $acl->testPermission('admin/extstock/extstockorderlist/extstocksave');
		}
		catch(Exception $e)
		{
			$canSave = true;
		}
		
		if(/*(Mage::registry('extstock_data')->getStatus()== Slpb_Extstock_Helper_Data::DELIVERED)
			||*/ (!$canSave))
		{
			$this->removeButton('save');
		}
		
		/*
		if(($mode = Mage::getSingleton('adminhtml/session')->getData('extstockmode'))&& ($mode == 'product'))
		{
			$this->removeButton('back');
			$this->_addButton('close', array(
            'label'   => Mage::helper('catalog')->__('Close'),
            'onclick' => "window.close();",
        	),0,1000);
        	
		}
		*/
		
		/*
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);
*/
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('extstock_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'extstock_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'extstock_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

  
    
    public function getHeaderText()
    {
    	return Mage::helper('extstock')->__("Edit Stock Movement");
    	/*
        if( Mage::registry('extstock_data') && Mage::registry('extstock_data')->getId() ) {
            return Mage::helper('extstock')->__("Edit Stock Movement");//. " " . $this->htmlEscape(Mage::registry('extstock_data')->getDistributor());
        } else {
            return Mage::helper('extstock')->__('Add Stock');
        }
        */
    }
    
 	public function getBackUrl()
    {
    	$model  = Mage::registry('extstock_journal_data');
     	if (($model->getGrid()!= null) && ($model->getGrid() == 'warning')) {
    	 	return $this->getUrl('adminhtml/extstock_warning');
    	 }
        return $this->getUrl('*/*/');
    }
}