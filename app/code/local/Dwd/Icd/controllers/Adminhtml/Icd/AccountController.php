<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Adminhtml_AccountController
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Adminhtml_Icd_AccountController extends Mage_Adminhtml_Controller_action
{

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
		$model  = Mage::getModel('dwd_icd/account')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			//Bearbeiter darf Passwort nicht lesen
			$model->setPassword('');
			Mage::register('account_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('sales/dwd_icd/icd_account');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('dwd_icd/adminhtml_account_edit'))
				->_addLeft($this->getLayout()->createBlock('dwd_icd/adminhtml_account_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('icd')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			$model = Mage::getModel('dwd_icd/account')->load($this->getRequest()->getParam('id'));
			foreach($data as $k=>$v){
				$model->setData($k,$v);
			}
			$model->setId($this->getRequest()->getParam('id'));
			
			if (($model->getStatus() == Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_NEW ) || ($model->getStatus() == Dwd_Icd_Model_AccountStatus::ACCOUNTSTATUS_NEWPASSWORD )) {
				if (!$model->_checkPassword()) {
					Mage::getSingleton('adminhtml/session')->addError(Mage::helper('dwd_icd')->__('Password does not meet requirements'));
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}	
			} else {
				$model->unsetData('password');
			}
			
			
			try {
				if ($model->getCreatedTime() == null || $model->getUpdateTime() == null) {
					$model->setCreatedTime(now())
						->setUpdateTime(now())
					;
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
				$model = Mage::getModel('dwd_icd/account');
				 
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
		$model  = Mage::getModel('dwd_icd/account')->load($id);
		Mage::log("ICD Account Sync by User request: id=".$id , Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		$model->sync();
		$this->_redirect('*/*/');
	}
	
	public function syncAllAction() {
		$model = Mage::getModel('dwd_icd/cron');
		
		$model->syncAll();
		$this->_redirect('*/*/');
	}
	
	public function xsyncAllAction() {
		
		$model = Mage::getModel('dwd_icd/stress');
		$model->syncAll();
		
	}
  
    public function exportCsvAction()
    {
        $fileName   = 'account.csv';
        $content    = $this->getLayout()->createBlock('dwd_icd/adminhtml_account_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'account.xml';
        $content    = $this->getLayout()->createBlock('dwd_icd/adminhtml_account_grid')
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
    
    
    public function loggridAction()
    {
    	$this->loadLayout();
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('dwd_icd/adminhtml_account_edit_tab_log_grid')->toHtml()
    	);
    }
    
    public function attributesgridAction()
    {
    	$this->loadLayout();
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('dwd_icd/adminhtml_account_edit_tab_attributes_grid')->toHtml()
    	);
    }
    
    public function groupsgridAction()
    {
    	$this->loadLayout();
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('dwd_icd/adminhtml_account_edit_tab_groups_grid')->toHtml()
    	);
    }
    
	protected function _isAllowed() {
        $action = strtolower($this->getRequest()->getActionName());
        switch ($action) {
            case 'syncall':
               	return Mage::getSingleton('admin/session')->isAllowed('sales/dwd_icd/icd_sync_all');
                break;
            default:
                return Mage::getSingleton('admin/session')->isAllowed('sales/dwd_icd/icd_account');
                break;
        }
    }
  
}