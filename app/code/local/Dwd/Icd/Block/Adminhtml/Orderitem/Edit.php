<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Orderitem_Edit
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Orderitem_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'dwd_icd';
        $this->_controller = 'adminhtml_orderitem';
        
        $this->_updateButton('save', 'label', Mage::helper('dwd_icd')->__('Save Item'));
        //$this->_updateButton('delete', 'label', Mage::helper('dwd_icd')->__('Delete Item'));
        $this->_removeButton('delete');
			
        $model = Mage::registry('orderitem_data');
        if($model){
        	$account = Mage::getModel('dwd_icd/account')->load($model->getAccountId());
        }
        
        if(($account->getId() == 0) || ($account->getStatus() == Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_DELETE))
        {
        	$this->_removeButton('save');
        }
        
       
    }
    
    public function getBackUrl()
    {
    	if($this->getRequest()->getParam('back_url') === 'abo')
    	{
    		return $this->getUrl('dwd_abo/adminhtml_abo');
    	}
    	return $this->getUrl('*/*/');
    }

    public function getHeaderText()
    {
        if( Mage::registry('orderitem_data') && Mage::registry('orderitem_data')->getId() ) {
            return Mage::helper('dwd_icd')->__("Edit Item");
        } else {
            return Mage::helper('dwd_icd')->__('Add Item');
        }
    }
	
	
}