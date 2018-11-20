<?php
class Bkg_Tollpolicy_Block_Adminhtml_Usetype_Edit_Tab_Options extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_usetype_edit_tab_options';
    $this->_blockGroup = 'bkg_tollpolicy';
    $this->_headerText = Mage::helper('bkg_tollpolicy')->__('Type of Use Options');
    
    parent::__construct();
    $Url   = $this->getUrl('*/tollpolicy_useoptions/new', array('useid' => Mage::registry('use_type_entity_data')->getId()));
    $this->updateButton('add','onclick', 'setLocation(\''.$Url.'\');');

  }
 
    
}