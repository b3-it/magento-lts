<?php
  /**
   *
   * @category   	Gka Barkasse
   * @package    	Gka_Barkasse
   * @name        Gka_Barkasse_Kassenbuch_JournalitemsController
   * @author 		Holger Kögel <h.koegel@b3-it.de>
   * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
   * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
   */
class Gka_Barkasse_Kassenbuch_JournalitemsController extends Mage_Core_Controller_Front_Action
{
    protected $_customer = null;

    public function indexAction()
    {
      $this->loadLayout();
      $this->renderLayout();
    }

    public function preDispatch() {
    	parent::preDispatch();

    	if (!Mage::getSingleton('customer/session')->authenticate($this)) {
    		$this->setFlag('', 'no-dispatch', true);
    	}
    }

    protected function _getCustomer()
    {
        if($this->_customer == null){
          $this->_customer = Mage::getSingleton('customer/session')->getCustomer();
        }
        return $this->_custommer;
    }
    
    public function gridAction()
    {
    	if(!$this->_validateFormKey()){
    		$this->_redirect('customer/account/logout');
    		return;
    	}
    	$this->loadLayout(false);
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('gka_barkasse/kassenbuch_journalitems_grid')->toHtml()
    			);
    }
    
    
    public function exportCsvAction()
    {
    	$fileName   = 'kassenbuchjournaldetails.csv';
    	$content    = $this->getLayout()->createBlock('gka_barkasse/kassenbuch_journalitems_grid')
    	->getCsv();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportXmlAction()
    {
    	$fileName   = 'kassenbuchjournaldetails.xml';
    	$content    = $this->getLayout()->createBlock('gka_barkasse/kassenbuch_journalitems_grid')
    	->getXml();
    
    	$this->_sendUploadResponse($fileName, $content);
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
