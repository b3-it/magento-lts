<?php
class Stala_Abo_Block_Adminhtml_Contract extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_contract';
    $this->_blockGroup = 'stalaabo';
    $this->_headerText = Mage::helper('stalaabo')->__('Subscription Contract Positions Manager');
    $this->_addButtonLabel = Mage::helper('stalaabo')->__('Add Subscription Contract');
    parent::__construct();
  }
  

   protected function _prepareLayout()
   {
   	    if($this->getCustomerId())
  		{
  			$this->removeButton('add');
  			$acl = Mage::getSingleton('acl/productacl');
    		if($acl->testPermission('admin/stalaabo/contract'))
    		{
		   		$this->_addButton('add', array(
		            'label'     => $this->getAddButtonLabel(),
		            'onclick'   => 'setLocation(\'' .$this->getUrl('adminhtml/stalaabo_contract_create/customerPost',array('customer_id'=>$this->getCustomerId())) .'\')',
		            'class'     => 'add',
		        ));
    		}
  		}
        parent::_prepareLayout();
        if($this->getCustomerId())
  		{
  			$this->getChild('grid')->setCustomerId($this->getCustomerId());
  			$this->getChild('grid')->setUseAjax(true);
  		}
        
        
        return $this;
   }
  
 
}