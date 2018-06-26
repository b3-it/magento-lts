<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Gka
 *  @package  Gka_Reports
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2017 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_Reports_Adminhtml_Gkareports_ReportsController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('report/gka')
			//->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'))
            //->setTitle(Mage::helper('adminhtml')->__('Report'), Mage::helper('adminhtml')->__('Report'))
            ;
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function transactionsAction() {
        $this->_initAction()
            ->renderLayout();
		$id     = $this->getRequest()->getParam('id');
		//$model  = Mage::getModel('reports/reports')->load($id);


	}
 

}