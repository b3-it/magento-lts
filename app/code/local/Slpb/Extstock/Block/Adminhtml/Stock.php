<?php
class Slpb_Extstock_Block_Adminhtml_Stock extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		//$h = Mage::helper('extstock');
		//$test = $h->__('Distributor');
		$this->_controller = 'adminhtml_stock';
		$this->_blockGroup = 'extstock';
		$this->_headerText = Mage::helper('extstock')->__('Configure Stock');
		$this->_addButtonLabel = Mage::helper('extstock')->__('Add Stock');
		//Mage::getSingleton('adminhtml/session')->setData('extstockmode','stock');
		parent::__construct();
		
		//$this->setTemplate('egovs/widget/grid/container.phtml');
	}

	protected function x_prepareLayout()
	{

		parent::_prepareLayout();
		//$this->removeButton('add');
		return $this;
	}
	
	protected function x_beforeToHtml()
    {
        $this->setChild('grid', $this->getLayout()->createBlock('extstock/adminhtml_stock_grid', 'extstock.stock.grid'));
        return parent::_beforeToHtml();
    }
	
}