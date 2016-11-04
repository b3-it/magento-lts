<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Sid
 *  @package  Sid_ExportOrder
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_ExportOrder_Adminhtml_ExportOrder_TransferController extends Mage_Adminhtml_Controller_action
{

 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}


	public function transferformAction() {
		
		$type = $this->getRequest()->getParam('type');
		$vendor = $this->getRequest()->getParam('vendor');
		
		$block = "";
		
		if(($type == Sid_ExportOrder_Model_Type_Transfer::TRANSFER_TYPE_EMAIL) |($type == Sid_ExportOrder_Model_Type_Transfer::TRANSFER_TYPE_EMAIL_ATTACHMENT)){
			$model = Mage::getModel('exportorder/transfer_email')->load(intval($vendor),'vendor_id');
			Mage::register('transfer', $model);
			$block = $this->getLayout()->createBlock('sid_exportorder/adminhtml_transfer_email_form')->toHtml();
		}
		
		if( $type == 'post'){
			$model = Mage::getModel('exportorder/transfer_post')->load(intval($vendor),'vendor_id');
			Mage::register('transfer', $model);
			$block = $this->getLayout()->createBlock('sid_exportorder/adminhtml_transfer_post_form')->toHtml();
		}
		
		if( $type == 'link'){
			$model = Mage::getModel('exportorder/transfer_link')->load(intval($vendor),'vendor_id');
			Mage::register('transfer', $model);
			$block = $this->getLayout()->createBlock('sid_exportorder/adminhtml_transfer_link_form')->toHtml();
		}
		
		
		
		$this->getResponse()->setBody($block);

	}
	
	protected function _isAllowed()
	{
		return Mage::getSingleton('admin/session')->isAllowed('framecontract/vendor');
	}

}