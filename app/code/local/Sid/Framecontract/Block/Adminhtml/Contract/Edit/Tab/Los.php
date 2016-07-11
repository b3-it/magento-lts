<?php
/**
 * 
 * @author h.koegel
 *
 */
class Sid_Framecontract_Block_Adminhtml_Contract_Edit_Tab_Los extends Mage_Adminhtml_Block_Widget_Form
{

  
  public function __construct()
  {
  	parent::__construct();
  	$this->setTemplate('sid/framecontract/contract/lose.phtml');
  }
  
  protected function _prepareForm()
  {
  		$this->setChild('add_button',
  			$this->getLayout()->createBlock('adminhtml/widget_button')
  			->setData(array(
  					'label' => Mage::helper('bundle')->__('Neues Los'),
  					'class' => 'add',
  					'id'    => 'add_new_option',
  					'on_click' => 'contractLos.add(null)'))
  			);
  }
  
  
  public function getLose()
  {
  		$id = intval(Mage::registry('contract_data')->getId());
  		$collection = Mage::getModel('framecontract/los')->getCollection();
  		$collection->getSelect()->where('framecontract_contract_id = '.$id);
  		return $collection->getItems();
  }
  
  public function getStatus()
  {
  	return Sid_Framecontract_Model_Status::getOptionArray();
  }
  
  
 
  
}