<?php
class Slpb_Extstock_Block_Adminhtml_Journal extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		//$h = Mage::helper('extstock');
		//$test = $h->__('Distributor');
		$this->_controller = 'adminhtml_journal';
		$this->_blockGroup = 'extstock';
		$this->_headerText = Mage::helper('extstock')->__('Stock Movement');
		//$this->_addButtonLabel = Mage::helper('extstock')->__('Add Stock');
		//Mage::getSingleton('adminhtml/session')->setData('extstockmode','stock');
		parent::__construct();
		$this->removeButton('add');
		//$this->setTemplate('egovs/widget/grid/container.phtml');
	}


	
}