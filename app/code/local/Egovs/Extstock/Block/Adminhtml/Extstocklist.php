<?php
class Egovs_Extstock_Block_Adminhtml_Extstocklist extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	public function __construct()
	{
		$h = Mage::helper('extstock');
		$test = $h->__('Distributor');
		$this->_controller = 'adminhtml_extstocklist';
		$this->_blockGroup = 'extstock';
		$this->_headerText = Mage::helper('extstock')->__('Stock');
		$this->_addButtonLabel = Mage::helper('extstock')->__('Add Order');
		Mage::getSingleton('adminhtml/session')->setData('extstockmode','stock');
		parent::__construct();
		
		$this->setTemplate('egovs/widget/grid/container.phtml');
	}

	protected function _prepareLayout()
	{
		parent::_prepareLayout();
		$this->removeButton('add');
		
		$egovs_acl_stock_overview = true;
		
		if ($egovs_acl_stock_overview) {
			$this->setChild('overview',
	            $this->getLayout()->createBlock('extstock/adminhtml_extstock_overview','',array())
	        );
		}
	}
}