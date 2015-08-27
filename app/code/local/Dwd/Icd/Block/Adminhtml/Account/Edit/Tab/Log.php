<?php
class Dwd_Icd_Block_Adminhtml_Account_Edit_Tab_Log extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_account_edit_tab_log';
    $this->_blockGroup = 'dwd_icd';
    $this->_headerText = Mage::helper('stationen')->__('Log');
    
    parent::__construct();
    $this->removeButton('add');
  }
 
    
}