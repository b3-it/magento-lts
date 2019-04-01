<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Adminhtml_EventController
 * @author 		Holger K�gel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Adminhtml_Eventmanager_OptionsController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('bfr_eventmanager/eventmanager_options')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $this->_title(Mage::helper('eventmanager')->__('Custom Options'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = (int)$this->getRequest()->getParam('id');
		$model  = Mage::getModel('eventmanager/event')->load($id);

		if ($model->getId() || $id == 0) {


			Mage::register('event_data', $model);

			$this->_initAction();


			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('eventmanager/adminhtml_options_list'));
//				->_addLeft($this->getLayout()->createBlock('eventmanager/adminhtml_event_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('eventmanager')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}



    public function exportCsvAction()
    {
        $id     = (int)$this->getRequest()->getParam('id');
        $model  = Mage::getModel('eventmanager/event')->load($id);

        if ($model->getId() || $id == 0) {
            Mage::register('event_data', $model);
        }
        $fileName   = 'options.csv';
        $content    = $this->getLayout()->createBlock('eventmanager/adminhtml_options_list_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $id     =(int)$this->getRequest()->getParam('id');
        $model  = Mage::getModel('eventmanager/event')->load($id);

        if ($model->getId() || $id == 0) {
            Mage::register('event_data', $model);
        }
        $fileName   = 'options.xml';
        $content    = $this->getLayout()->createBlock('eventmanager/adminhtml_options_list_grid')
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


    protected function _isAllowed() {
    	return Mage::getSingleton('admin/session')->isAllowed('bfr_eventmanager/eventmanager_event');
    }
}
