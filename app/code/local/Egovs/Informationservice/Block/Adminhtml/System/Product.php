<?php
class Egovs_Informationservice_Block_Adminhtml_System_Product extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_system_product';
    $this->_blockGroup = 'informationservice';
    $this->_headerText = Mage::helper('informationservice')->__('Information Service Master Product');
    
    parent::__construct();
    
    $this->setTemplate('egovs/widget/grid/container.phtml');
  }
  
  public function _prepareLayout()
  {
  		$this->removeButton('add');

  		$this->_addButton('save', 
        		array('label'=>Mage::helper('customer')->__('Save'),
        			'onclick' => " document.product_edit_form.submit();",
	           )
        	);
  		 $this->setChild( 'overview',
            $this->getLayout()->createBlock('informationservice/adminhtml_system_product_form'));
  		
  		
  		parent::_prepareLayout();
  		return $this;
  }
}