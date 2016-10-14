<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Adminhtml_Sidhaushalt_HaushaltController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('system/convert')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Haushaltsystem Export'), Mage::helper('adminhtml')->__('Haushaltsystem Export'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function massExportAction()
	{
		$orderIds = $this->getRequest()->getParam('orderIds');
		if(!is_array($orderIds)) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
		} else {
			try {
				//prüfen ob alle dasselbe Model verwenden
				$collection= Mage::getModel('sidhaushalt/order_info')->getcollection();
				$collection->getSelect()
					->where('order_id IN ('.implode(',', $orderIds).')')
					->group('haushalts_system');
				
					if(count($collection) > 1){
						Mage::throwException($this->__('There are more than one Export Systems used!'));
					}
				
					foreach($collection as $item)
					{
						$export = Sid_Haushalt_Model_Type::factory($item->getHaushaltsSystem());
					}
						
					if(!$export){
						Mage::throwException($this->__('Export System not defined!(%s)',$item->getHaushaltsSystem()));
					}
				
					$export->setOrderIds($orderIds);
					$data = $export->getExportData();
					$this->_sendUploadResponse($export->getFilename(), $data);
				$this->_getSession()->addSuccess(
						$this->__('Total of %d record(s) were successfully exported', count($orderIds))
						);
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}
	
	
	
	
    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}