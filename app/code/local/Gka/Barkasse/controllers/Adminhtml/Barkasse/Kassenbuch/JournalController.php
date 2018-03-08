<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name        Gka_Barkasse_Adminhtml_Barkasse_Kassenbuch_JournalController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Adminhtml_Barkasse_Kassenbuch_JournalController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('gkabarkasse/journal')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Kassenbuch Journal'), Mage::helper('adminhtml')->__('Kassenbuch Journal'));
		$this->_title(Mage::helper('adminhtml')->__('Kassenbuch Journal'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	
	/**
	 * Order grid
	 */
	public function gridAction()
	{
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('gka_barkasse/kassenbuch_journal')->load($id);
		
		Mage::register('kassenbuchjournal_data', $model);
		$this->loadLayout(false);
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuch_journal_grid')->toHtml()
				);
	}
	
	/**
	 * Order grid
	 */
	public function itemsAction()
	{
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('gka_barkasse/kassenbuch_journal')->load($id);
	
		Mage::register('kassenbuchjournal_data', $model);
		$this->loadLayout(false);
		$this->getResponse()->setBody(
				$this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuch_journal_edit_tab_items')->toHtml()
				);
	}

	public function editAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('gka_barkasse/kassenbuch_journal')->load($id);

		if ($model->getId() || $id == 0) {

            $this->_storeIsolation($model->getCashboxId());

			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('kassenbuchjournal_data', $model);

			$this->_initAction();
			

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuch_journal_edit'))
				->_addLeft($this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuch_journal_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gka_barkasse')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function pdfAction() {
		$id     =  intval($this->getRequest()->getParam('id'));
		$model  = Mage::getModel('gka_barkasse/kassenbuch_journal')->load($id);
        $this->_storeIsolation($model->getCashboxId());
		if ($model->getId() || $id == 0) {
			$pdf = Mage::getModel('gka_barkasse/kassenbuch_journal_pdf');
			//$pdf->preparePdf();
			$pdf->Mode = Egovs_Pdftemplate_Model_Pdf_Abstract::MODE_PREVIEW;
			$pdf->getPdf(array($model))->render();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gka_barkasse')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	
	public function newAction() {
		$this->_forward('edit');
	}

	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$id = intval($this->getRequest()->getParam('id'));
			if($id > 0)
			{
				$model = Mage::getModel('gka_barkasse/kassenbuch_journal')->load($id);

                $this->_storeIsolation($model->getCashboxId());

				foreach($data as $k=>$v)
				{
					if(!empty($v)){
						$model->setData($k,$v);
					}
				}
				$model->setId($id);
			}else{
				$model = Mage::getModel('gka_barkasse/kassenbuch_journal');
				$model->setData($data);
			}
			
			
			
			try {
				$model->save();
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('gka_barkasse')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('gka_barkasse')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('gka_barkasse/kassenbuchjournal');

                $model = Mage::getModel('gka_barkasse/kassenbuch_journal')->load($id);

                $this->_storeIsolation($model->getCashboxId());

                $model->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}


    public function exportCsvAction()
    {
        $fileName   = 'kassenbuchjournal.csv';
        $content    = $this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuch_journal_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'kassenbuchjournal.xml';
        $content    = $this->getLayout()->createBlock('gka_barkasse/adminhtml_kassenbuch_journal_grid')
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
    
    protected function _isAllowed()
    {
    	$res =  Mage::getSingleton('admin/session')->isAllowed('admin/gkabarkasse/gkabarkasse_kassenbuch_journal');
    	return $res;
    }

    protected function _storeIsolation($cashboxId)
    {
        if(Mage::helper('gka_barkasse')->isModuleEnabled('Egovs_Isolation'))
        {
            if (!Mage::helper('isolation')->getUserIsAdmin()) {
                $stores = Mage::helper('isolation')->getUserStoreViews();
                $cashbox = Mage::getModel('gka_barkasse/kassenbuch_cashbox')->load($cashboxId);
                if (!in_array($cashbox->getStoreId(), $stores)) {
                    die(Mage::helper('isolation')->__('Denied'));
                }
            }
        }
    }
}
