<?php
/**
 *
* @category   	Bkg Viewer
* @package    	Bkg_Viewer
* @name        Bkg_Viewer_Adminhtml_Viewer_Service_ServiceController
* @author 		Holger Kögel <h.koegel@b3-it.de>
* @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
* @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
*/
class Bkg_Viewer_Adminhtml_Viewer_Service_ServiceController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
		->_setActiveMenu('serviceservice/items')
		->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		$this->_title(Mage::helper('adminhtml')->__('Items Manager'));
		return $this;
	}

	public function indexAction() {
		$this->_initAction()
		->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$this->_edit($id);
	}

	protected function _edit($id)
	{
		$model  = Mage::getModel('bkgviewer/service_service')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('serviceservice_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('bkgviewer/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('bkgviewer/adminhtml_service_service_edit'))
			->_addLeft($this->getLayout()->createBlock('bkgviewer/adminhtml_service_service_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkgviewer')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}

	public function newAction() {
		$this->_initAction()
		->renderLayout();
	}



	public function importAction() {
		$data = $this->getRequest()->getPost();
		$service = Mage::getModel('bkgviewer/service_service');
		try{
			if(empty($data['url']))
			{
				throw new Exception('empty url');
			}
				
			$service->fetchLayers($data['url'],$data['type'],$data['version']);
			//$this->_edit($service->getId());
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bkgviewer')->__('Item was successfully created'));
			$this->_redirect('*/*/edit',array('id'=>$service->getId()));
				
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->setFormData($data);
			//Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkgviewer')->__('An Error ocours!'));
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			$this->_redirect('*/*/new');
			return;
		}
		return;
	}

	public function saveAction() {
		$data = $this->getRequest()->getPost();
		$model = Mage::getModel('bkgviewer/service_service');
		$model->setData($data)
		->setId($this->getRequest()->getParam('id'));

		try {
			if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
				$model->setCreatedTime(now())
				->setUpdateTime(now());
			} else {
				$model->setUpdateTime(now());
			}

			$model->save();
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('bkgviewer')->__('Item was successfully saved'));
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

		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bkgviewer')->__('Unable to find item to save'));
		$this->_redirect('*/*/');
	}

	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('bkgviewer/service_service');

				$model->setId($this->getRequest()->getParam('id'))
				->delete();

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

	public function massDeleteAction() {
		$bkgviewerIds = $this->getRequest()->getParam('id');
		if(!is_array($bkgviewerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
		} else {
			try {
				foreach ($bkgviewerIds as $bkgviewerId) {
					$bkgviewer = Mage::getModel('bkgviewer/service_service')->load($bkgviewerId);
					$bkgviewer->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess(
						Mage::helper('adminhtml')->__(
								'Total of %d record(s) were successfully deleted', count($bkgviewerIds)
								)
						);
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}

	public function massStatusAction()
	{
		$serviceserviceIds = $this->getRequest()->getParam('serviceservice');
		if(!is_array($bkgviewerIds)) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
		} else {
			try {
				foreach ($serviceserviceIds as $serviceserviceId) {
					$serviceservice = Mage::getSingleton('bkgviewer/service_service')
					->load($bkgviewerId)
					->setStatus($this->getRequest()->getParam('status'))
					->setIsMassupdate(true)
					->save();
				}
				$this->_getSession()->addSuccess(
						$this->__('Total of %d record(s) were successfully updated', count($bkgviewerIds))
						);
			} catch (Exception $e) {
				$this->_getSession()->addError($e->getMessage());
			}
		}
		$this->_redirect('*/*/index');
	}

	public function layersAction()
	{
		$id = intval($this->getRequest()->getParam('id'));
		$collection = Mage::getModel('bkgviewer/service_layer')->getCollection();
		$collection->getSelect()
		->where('service_id=?',$id);
		$res = array();
		foreach($collection->getItems() as $item)
		{
			$res[] = array('value'=>$item->getId(), 'name' => $item->getTitle());
		}
		 
		die (json_encode($res));
	}


	public function exportCsvAction()
	{
		$fileName   = 'serviceservice.csv';
		$content    = $this->getLayout()->createBlock('bkgviewer/adminhtml_serviceservice_grid')
		->getCsv();

		$this->_sendUploadResponse($fileName, $content);
	}

	public function exportXmlAction()
	{
		$fileName   = 'serviceservice.xml';
		$content    = $this->getLayout()->createBlock('bkgviewer/adminhtml_serviceservice_grid')
		->getXml();

		$this->_sendUploadResponse($fileName, $content);
	}

	protected function _isAllowed()
	{
		return true;
		return Mage::getSingleton('admin/session')->isAllowed('');
	}


	public function layerGridAction()
    {
        $id     = $this->getRequest()->getParam('id');
        $model  = Mage::getModel('bkgviewer/service_service')->load($id);

        if ($model->getId()) {


            Mage::register('serviceservice_data', $model);

            $this->loadLayout(false);
            $this->getResponse()->setBody(
                $this->getLayout()->createBlock('bkgviewer/adminhtml_service_service_edit_tab_layer')->toHtml()
            );
        }
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
