<?php
class Sid_Framecontract_Block_Adminhtml_Contract_Edit_Tab_Files extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_contract_edit_tab_files';
    $this->_blockGroup = 'framecontract';
    $this->_headerText = Mage::helper('framecontract')->__('Contract Files');
    //$this->_addButtonLabel = Mage::helper('framecontract')->__('Add Item');
    
    parent::__construct();
    $this->setTemplate('egovs/widget/grid/container.phtml');
    
   
  }
  
	protected function _prepareLayout()
	{

		parent::_prepareLayout();
		$this->removeButton('add');

		
			$this->setChild('overview',
	            $this->getLayout()->createBlock('framecontract/adminhtml_contract_edit_tab_files_files','',array())
	        );
	}
	
	
}