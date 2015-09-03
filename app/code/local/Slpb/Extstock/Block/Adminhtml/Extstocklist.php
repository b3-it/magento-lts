<?php
class Slpb_Extstock_Block_Adminhtml_Extstocklist extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$this->_controller = 'adminhtml_extstocklist';
		$this->_blockGroup = 'extstock';
		$this->_headerText = Mage::helper('extstock')->__('Stock Inventory');
		$this->_addButtonLabel = Mage::helper('extstock')->__('Add Order');
		Mage::getSingleton('adminhtml/session')->setData('extstockmode','stock');
		parent::__construct();
		
		$this->setTemplate('slpb/widget/grid/container.phtml');
	}

	protected function _prepareLayout()
	{
		parent::_prepareLayout();
		$this->removeButton('add');
		
		$Slpb_acl_stock_overview = true;
		
		if ($Slpb_acl_stock_overview) {
			$this->setChild('overview',
	            $this->getLayout()->createBlock('extstock/adminhtml_extstock_overview','',array())
	        );
		}
	}
}