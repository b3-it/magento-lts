<?php
class Dwd_Icd_Block_Adminhtml_Account_Edit_Tab_Groups extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_account_edit_tab_groups';
    $this->_blockGroup = 'dwd_icd';
    $this->_headerText = Mage::helper('stationen')->__('Groups');
    
    parent::__construct();
    $this->removeButton('add');
  }
 
    
}