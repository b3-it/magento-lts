<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Adminhtml_OrderitemController
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Adminhtml_Icd_OrderitemController extends Mage_Adminhtml_Controller_action
{

	//TODO: HK andere action wählen
	protected $_publicActions = array('edit');
	
	protected function _initAction() {
		$this->loadLayout()
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('dwd_icd/orderitem')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			
				
			Mage::register('orderitem_data', $model);

			if($model){
				$account = Mage::getModel('dwd_icd/account')->load($model->getAccountId());
			}
			
			if(($account->getId() == 0) || ($account->getStatus() == Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_DELETE))
			{
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dwd_icd')->__('Account is deleted!'));
			}
			
			
			
			$this->loadLayout();
			$this->_setActiveMenu('sales/dwd_icd/icd_orderitems');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('dwd_icd/adminhtml_orderitem_edit'))
				->_addLeft($this->getLayout()->createBlock('dwd_icd/adminhtml_orderitem_edit_tabs'));

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
			
			$model = Mage::getModel('dwd_icd/orderitem');
			
			/*
			$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
			if (isset($data['start_time'])) {
				$data['start_time'] = Mage::getModel('core/date')->gmtDate(null, Varien_Date::toTimestamp($data['start_time']));
			}
			if (isset($data['end_time'])) {
				$t =Mage::getModel('core/date')->parseDateTime( $data['end_time'], $dateFormatIso);
				$data['end_time'] = Mage::getModel('core/date')->gmtDate($dateFormatIso, $data['end_time']);
			}
			*/
			unset($data['start_time']);
			unset($data['end_time']);
			unset($data['id']);
			$id = $this->getRequest()->getParam('id');
			$model->load($id);
			foreach($data as $k=>$v){
				$model->setData($k,$v);
			}
			
			
			try {
				if ($model->getCreatedTime() == null || $model->getUpdateTime() == null) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
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
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('dwd_icd/orderitem');
				 
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


	
	public function syncAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('dwd_icd/orderitem')->load($id);
		Mage::log("ICD Item Sync by User request: id=".$id , Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$model->sync();
		$this->_redirect('*/*/');
	}
  
    public function exportCsvAction()
    {
        $fileName   = 'orderitem.csv';
        $content    = $this->getLayout()->createBlock('dwd_icd/adminhtml_orderitem_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'orderitem.xml';
        $content    = $this->getLayout()->createBlock('dwd_icd/adminhtml_orderitem_grid')
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
    			return Mage::getSingleton('admin/session')->isAllowed('sales/dwd_icd/icd_orderitems');
    			break;
    	}
    }
}