<?php
/**
 * Controller zur Abfrage der Zahlungseingänge
 *
 * @category  Egovs
 * @package   Egovs_Paymentbase
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
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
		} catch (Exception $e) {
			Mage::getSingleton('core/session')->addError($e->getMessage());
		}

		$this->_redirectReferer($this->getUrl('adminhtml/sales_order'));
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