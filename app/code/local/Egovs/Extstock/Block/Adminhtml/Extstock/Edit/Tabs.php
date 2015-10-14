<?php

class Egovs_Extstock_Block_Adminhtml_Extstock_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{

	public function __construct()
	{
		parent::__construct();
		$this->setId('extstock_tabs');
		$this->setDestElementId('edit_form');
		$this->setTitle(Mage::helper('extstock')->__('Stock Order Information'));
	}
	/**
	 * Feststellen ob das Grid von der Lagerverwaltung oder Produktverwaltung
	 * aufgerufen wurde
	 * @return boolean
	 */
	protected function _isStockMode()
	{
		if($mode = Mage::getSingleton('adminhtml/session')->getData('extstockmode'))
		{
			if($mode == 'product') return false;
		}
		return true;
	}
	
	protected function _beforeToHtml()
	{
		$this->addTab('product_section', array(
          'label'     => Mage::helper('extstock')->__('Product'),
          'title'     => Mage::helper('extstock')->__('Product'),
          'content'   => $this->getLayout()->createBlock('extstock/adminhtml_extstock_edit_tab_product')->toHtml(),
		));

		$this->addTab('form_section', array(
          'label'     => Mage::helper('extstock')->__('Stock Order'),
          'title'     => Mage::helper('extstock')->__('Stock Order'),
          'content'   => $this->getLayout()->createBlock('extstock/adminhtml_extstock_edit_tab_order')->toHtml(),
		));

		if(Mage::registry('extstock_data')->getOrigData('status') != Egovs_Extstock_Helper_Data::ORDERED) {
			$this->addTab('stock_section', array(
	          'label'     => Mage::helper('extstock')->__('Stock Status'),
	          'title'     => Mage::helper('extstock')->__('Stock Status'),
	          'content'   => $this->getLayout()->createBlock('extstock/adminhtml_extstock_edit_tab_stockstatus')->toHtml(),
			));
		} else {
			$this->addTab('status_section', array(
	          'label'     => Mage::helper('extstock')->__('Order Status'),
	          'title'     => Mage::helper('extstock')->__('Order Status'),
	          'content'   => $this->getLayout()->createBlock('extstock/adminhtml_extstock_edit_tab_status')->toHtml(),
			));
		}
		
		if ($this->_isStockMode()) {
			$this->addTab('reorder_section', array(
	          'label'     => Mage::helper('extstock')->__('Reorder'),
	          'title'     => Mage::helper('extstock')->__('Reorder'),
	          'content'   => $this->getLayout()->createBlock('extstock/adminhtml_extstock_edit_tab_order',
	      													 '',
															 array(Egovs_Extstock_Helper_Data::REORDER => 1)
															)->toHtml(),
			));
		}
		return parent::_beforeToHtml();
	}
}