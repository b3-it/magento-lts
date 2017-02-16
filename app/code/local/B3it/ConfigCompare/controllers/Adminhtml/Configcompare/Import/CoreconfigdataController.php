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
class B3it_ConfigCompare_Adminhtml_Configcompare_Import_CoreconfigdataController extends B3it_ConfigCompare_Controller_Adminhtml_Abstract
{

	protected function _initAction() {
		$this->loadLayout();
		return $this;
	}   
 
	public function indexAction() {
		
		
		if ($data = $this->getRequest()->getPost()) {
				
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {
					$xml = file_get_contents($_FILES['filename']['tmp_name']);
					$xml = simplexml_load_string($xml);
					Mage::getModel('configcompare/configCompare')->import($xml);
				} catch (Exception $e) {
					Mage::logException($e);
				}				 
			}
		}
		
		//Mage::register('import_data', $xml);

		$this->_initAction();
		$this->renderLayout();	
		return $this;
		
	}
	
	public function gridAction()
	{
		$this->loadLayout();
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('configcompare/adminhtml_import_data_grid')->toHtml()
		);
	}


}