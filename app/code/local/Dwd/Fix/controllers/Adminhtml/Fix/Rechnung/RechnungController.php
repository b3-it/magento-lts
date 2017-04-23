<?php
/**
 *
 * @category   	Dwd Fix
 * @package    	Dwd_Fix
 * @name        Dwd_Fix_Adminhtml_Fix_Rechnung_RechnungController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Fix_Adminhtml_Fix_Rechnung_RechnungController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('rechnungrechnung/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('RechnungRechnung Manager'), Mage::helper('adminhtml')->__('RechnungRechnung Manager'));
		$this->_title(Mage::helper('adminhtml')->__('RechnungRechnung Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	
	public function newAction() {
		
		$model  = Mage::getModel('dwd_fix/rechnung_rechnung')->process();
		$this->_forward('index');
	}


}
