<?php
class Bkg_VirtualAccess_Block_Adminhtml_Purchaseditem_Edit_Tab_Credential extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_purchaseditem_edit_tab_credential';
    $this->_blockGroup = 'virtualaccess';
    $this->_headerText = Mage::helper('virtualaccess')->__('Credentials');
    
    parent::__construct();
    $Url   = $this->getUrl('*/*/new', array('item_id' => Mage::registry('action_data')->getId()));
    $this->updateButton('add','onclick', 'setLocation(\''.$Url.'\');');

  }
 
    
}