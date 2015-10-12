<?php

class Egovs_Informationservice_Adminhtml_Informationservice_RequestController extends Mage_Adminhtml_Controller_Action
{
	private $_storeId = null;

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('informationservice/request')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Information Service'), Mage::helper('adminhtml')->__('Manage Requests'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->_addContent($this->getLayout()->createBlock('informationservice/adminhtml_request'))
			->renderLayout();
	}

	
    public function newAction()
    {
        $this->_getSession()->clear();
        $this->_redirect('*/*/customer', array('customer_id' => $this->getRequest()->getParam('customer_id')));
    }
	
    public function customerAction()
    {
    	$this->_initAction()
    		->_addContent($this->getLayout()->createBlock('informationservice/adminhtml_request_customer'))
			->renderLayout();
    }
   	
    public function customergridAction()
    {
    	$this->loadLayout();
    	$this->getResponse()
    	 	->setBody($this->getLayout()->createBlock('informationservice/adminhtml_request_customer_grid')->toHtml());
    }
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$customer_id =  $this->getRequest()->getParam('customer');
		try 
		{
			
			$model  = Mage::getModel('informationservice/request')->load($id);
	
			if ($model->getId() || $id == 0) {
				$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
				
				if($data == null)
				{ 
					$data = array();
				  	$data['request'] = array();
				}
				
				
				if((!$model->getId()) && ( !empty($customer_id)))
				{
					$data['request']['customer_id'] = $customer_id;
				}
				
				if($model->getId())
				{
					$data['request'] = $model->getData();
				}
				//if (!empty($data)) {
					//$model->getData($data['request']);
				//}
				
				Mage::register('new_task_status', $model->getStatus());
				Mage::register('request_data', $data);
	
				$this->loadLayout();
				$this->_setActiveMenu('informationservice/items');
	
				$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
				$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
	
				$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
	
				$this->_addContent($this->getLayout()->createBlock('informationservice/adminhtml_request_edit'))
					->_addLeft($this->getLayout()->createBlock('informationservice/adminhtml_request_edit_tabs'));
	
				$this->renderLayout();
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('informationservice')->__('Item does not exist'));
				$this->_redirect('*/*/');
			}
		}
		catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                if($customer_id)
                	$this->_redirect('*/*/');
                else
                	$this->_redirect('*/*/customer'); 
                return;
            }
	}
 
	
	

    public function taskdetailAction()
    {
    	$this->loadLayout('popup')
    		->_addContent(
    		$this->getLayout()
    			->createBlock('informationservice/adminhtml_request_view'))
			->renderLayout();
    }
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			try 
			{	


				//test email
				$email = trim($data['request']['replay_email']);
				if(strlen($email))
				{
					$validator = new Zend_Validate_EmailAddress();
					if(!$validator->isValid($email))
					{
						Mage::throwException(Mage::helper('informationservice')->__('EMail Address is not valid!'));
					}
				}	
				$model = Mage::getModel('informationservice/request');
				$request_id = intval($this->getRequest()->getParam('id'));	
				if($request_id != 0)
				{	
					$model->load($request_id);
				}
				else 
				{
					//default status			
					if(!isset($data['request']['status']))
					{
						$data['request']['status'] = Egovs_Informationservice_Model_Status::STATUS_NEW;
					}
				}
				
				foreach ($data['request'] as $key => $value) 
				{
					$model->setData($key,$value);
				}
				
				

					
					
				$task = Mage::getModel('informationservice/task');		
				$taskdata = $data['task'];
				if(strlen($taskdata['title'])> 0)
				{
					$model->setOwnerId($taskdata['owner_id']);
					$model->setStatus($taskdata['newstatus']);
				}	
		
				/*
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				*/
				$date = Mage::getModel('core/date')->date(null, $model->getDeadlineTime());
				$model->setDeadlineTime($date);
				
				$model->save();
				if(strlen($taskdata['title'])> 0)
				{
					$taskdata['request_id'] = $model->getId();
					$task->setData($taskdata)->save();
				}
				
			
				
				$this->sendEmail($model,$task);
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('informationservice')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('informationservice')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('informationservice/request');
				 
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

	public function taskgridAction()
	{
		$this->getResponse()->setBody(
			$this->getLayout()->createBlock('informationservice/adminhtml_request_edit_tab_grid')->toHtml());
	}
	
	
    public function exportCsvAction()
    {
        $fileName   = 'requests.csv';
        $content    = $this->getLayout()->createBlock('informationservice/adminhtml_request_grid')
            			->getCsv()
        ;
        $content = html_entity_decode($content, null, 'UTF-8');

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'requests.xml';
        $content    = $this->getLayout()->createBlock('informationservice/adminhtml_request_grid')
            			->getXml()
        ;
        $content = html_entity_decode($content, null, 'UTF-8');

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
    
    
    
   public function sendEmail($request,$task)
   {
   		
				$status = Mage::getModel('informationservice/status')->getOptionArray();
						
				$emailparam = array();
				$emailparam['status'] = $status[$request->getStatus()];
				$emailparam['request_id'] = $request->getId();
				$emailparam['request_title'] = $request->getTitle();
				$emailparam['task_title'] = $task->getTitle();
				$emailparam['task_content'] = $task->getContent();
				$emailparam['owner_id'] = $request->getOwnerId();
				$emailparam['reply_email'] = $request->getReplayEmail();
				$owner = Mage::getModel('admin/user')->load($request->getOwnerId());
				$customer = Mage::getModel('customer/customer')->load($request->getCustomerId());
				$adr = Mage::getModel('customer/address')->load($request->getAddressId());
				
				
				$name = trim($customer->getFirstname(). " " . $customer->getLastname());
				if(strlen($name) > 0)
				{
					$emailparam['customer_name'] = $customer->getPrefix(). " " . $name;
				}
				else 
				{
					$emailparam['customer_name'] = $customer->getCompany();
				}
				
				if($owner)
				{
					$emailparam['owner_email'] = $owner->getEmail(); 
				}
				$send = $task->getEmailSend();
				if(isset($send))
				{
					$this->sendCustomerEmail($emailparam);
				}
				
				$this->sendOwnerEmail($emailparam);
   }
   
   public function sendOwnerEmail($data)
   {
   		if(Mage::getStoreConfig("informationservice/email/owner_email", $this->getStoreId()) == 0) return;
   		
   		
   		//falls sender == empfaenger
   		$user_id = Mage::getSingleton('admin/session')->getUser()->getId();
   		if(($user_id == $data['owner_id']) 
   			&& (Mage::getStoreConfig("informationservice/email/self_email", $this->getStoreId()) == 0)) 
   		return;
   		
   		
   		$customerEMail = $data['owner_email'];
    	if(strlen($customerEMail) < 1) return;
   		
   		
   		
    	$translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
 
        $template = Mage::getStoreConfig("informationservice/email/owner_template", $this->getStoreId());
        $customerName = null;// $this->getCustomerName();
        
        $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$this->getStoreId()))
                ->sendTransactional(
                    $template,
                    'informationsystem',
                    $customerEMail,
                    $customerName,
                   	$data
                );
        

        $translate->setTranslateInline(true);

        return $this;   		
   		
   		
   		
   }
   
   
   public  function sendCustomerEmail($data)
    {
    	
    	$customerEMail = $data['reply_email'];
    	if(strlen($customerEMail) < 1) return;
        
    	
    	$translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
 
        $template = Mage::getStoreConfig("informationservice/email/customer_template", $this->getStoreId());
        $customerName = null;// $this->getCustomerName();
        

        $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$this->getStoreId()))
                ->sendTransactional(
                    $template,
                    'informationsystem',
                    $customerEMail,
                    $customerName,
                   	$data
                );
        

        $translate->setTranslateInline(true);

        return $this;
    }
    
    public function getStoreId()
    {
        if (is_null($this->_storeId)) {
            $this->_storeId = Mage::app()->getStore()->getId();
        }
        return $this->_storeId;
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('informationservice/request');
    			break;
    	}
    }
}