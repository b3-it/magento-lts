<?php
/**
 * Controller zur Abfrage der Zahlungseingänge
 *
 * @category   	Egovs
 * @package    	Egovs_Paymentbase
 * @author 		Rene Sieberg <rsieberg@web.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 * @see Mage_Adminhtml_Controller_Action
 */
class Egovs_Paymentbase_Adminhtml_Paymentbase_RetrievepayedordersController extends Mage_Adminhtml_Controller_Action
{
	/**
	 * Standardaufruf
	 * 
	 * @return void
	 */
	public function indexAction() {

		try {
			$model = Mage::getModel('paymentbase/paymentbase');
			$model->getZahlungseingaenge();
			// Auf Bestellübersicht umleiten
			$this->_redirect('adminhtml/sales_order/index');

		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
			// Auf Bestellübersicht umleiten
			$this->_redirect('adminhtml/sales_order/index');
			return;
		}
	}
	
	protected function _isAllowed() {
		$action = strtolower($this->getRequest()->getActionName());
		switch ($action) {
			default:
				return Mage::getSingleton('admin/session')->isAllowed('sales/retrievepayedorders');
				break;
		}
	}
}