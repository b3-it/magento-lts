<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Adminhtml_ConnectionController
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Adminhtml_Icd_ConnectionController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('system/icd_connection')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('dwd_icd/connection')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('connection_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('icd/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('dwd_icd/adminhtml_connection_edit'))
				->_addLeft($this->getLayout()->createBlock('dwd_icd/adminhtml_connection_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dwd_icd')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			
	  			
			$model = Mage::getModel('dwd_icd/connection');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				$model->save();
				

				if (isset($data['is_alive'])) {
				
					$connection = Mage::getModel('dwd_icd/connection')->load($model->getId());
					$soapClient = Mage::getSingleton('dwd_icd/webservice_icdServices', array($connection->getUrl(), array('login'=> $connection->getUser(), 'password' => $connection->getPassword())));
					$res = $soapClient->isAlive();
					
				}
				
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('dwd_icd')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dwd_icd')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if ( $this->getRequest()->getParam('id') > 0 ) {
			try {
				
				
				$produkte = Mage::getModel('catalog/product')->getCollection();
				$produkte->addAttributeToFilter('icd_connection',$this->getRequest()->getParam('id'));

				$items = $produkte->getItems();
				if (count($items) > 0) {
					$sku = array();
					foreach ($items as $item) {
						$sku[] = $item->getSku();
					}
					$sku = implode(', ', $sku);
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dwd_icd')->__('Connection is used by: ').$sku);
					$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
					return;
				}
				
				
				
				$model = Mage::getModel('dwd_icd/connection');
				 
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

 
    public function exportCsvAction()
    {
        $fileName   = 'connection.csv';
        $content    = $this->getLayout()->createBlock('icd/adminhtml_connection_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'connection.xml';
        $content    = $this->getLayout()->createBlock('icd/adminhtml_connection_grid')
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
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('system/config/dwd_icd');
    			break;
    	}
    }
}