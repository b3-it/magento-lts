<?php
/**
 * Adminhtml product cross freecopies controller
 *
 * @category	Stala
 * @package 	Stala_Extcustomer
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2011 - 2016 B3 IT Systeme GmbH (http://www.b3-it.de)
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Stala_Extcustomer_Adminhtml_Extcustomer_Product_FreecopiesController extends Mage_Adminhtml_Controller_Action
{
	protected function _init() {
		$id  = $this->getRequest()->getParam('product_id');
		if($id) {
			$product = Mage::getModel('catalog/product')->load($id);
			Mage::register('current_product', $product);
		}
		$this->loadLayout();
			
		return $this;
	}
	
	public function indexAction() {
		$this->_init();
		$this->getLayout()->getBlock('product.edit.tab.freecopies.grid')
			->setProductCrossFreecopies($this->getRequest()->getPost('product_cross_freecopies', null));
		//Alle Layoutfunktionen werden über die extcustomer.xml Layoutdatei gesteuert
		$this->renderLayout();
		return $this;
	}

	public function gridAction() {
		$this->_init();

		$this->getLayout()->getBlock('product.edit.tab.freecopies.grid')
			->setProductCrossFreecopies($this->getRequest()->getPost('product_cross_freecopies', null));
		//Alle Layoutfunktionen werden über die extcustomer.xml Layoutdatei gesteuert
		$this->renderLayout();
		return $this;
	}

	public function freecopiesAction() {
		$this->_forward('grid');
	}
	
	protected function _isAllowed() {
		return Mage::getSingleton('admin/session')->isAllowed('catalog');
	}
}