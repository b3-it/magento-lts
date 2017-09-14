<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_ConfigCompare_Adminhtml_Configcompare_ImportController extends B3it_ConfigCompare_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout();
		return $this;
	}   
 
	public function indexAction() {
		
		$storeId = intval($this->getRequest()->getParam('store_id',0));
		
		if ($data = $this->getRequest()->getPost()) {
				
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {
					$xml = file_get_contents($_FILES['filename']['tmp_name']);
					$xml = simplexml_load_string($xml);
					Mage::getModel('configcompare/configCompare')->setStoreId($storeId)->import($xml);
					$this->_redirect('*/configcompare_compare',array('store_id'=>$storeId));
				} catch (Exception $e) {
					Mage::logException($e);
				}				 
			}
		}
		
		$this->_initAction();
		$this->renderLayout();
		return $this;
		
	}
	
	

}