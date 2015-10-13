<?php

class Sid_Framecontract_Adminhtml_Framecontract_TransmitController extends Mage_Adminhtml_Controller_action
{

	private $_storeId = null;

	public function sendAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('framecontract/contract')->load($id);

		try 
		{
			if ($model->getId()) {
				
				$data = array();	
				$data['vendor_email'] = $model->getOrderEmail();
				$data['title'] = $model->getTitle();
				$data['contractnumber'] = $model->getContractnumber();
				
				
				$files = Mage::getModel('framecontract/files')->getCollection();
				$expr = new Zend_Db_Expr('framecontract_contract_id='.$id.' AND ((type='.Sid_Framecontract_Model_Filetype::TYP_CONFIG.') OR (type='.Sid_Framecontract_Model_Filetype::TYP_INFO.'))');
				$files->getSelect()
					->where($expr);
				
			
				$this->sendVendorEmail($data,$files);
				$transmit = Mage::getModel('framecontract/transmit');
				$transmit->setOwner(Mage::getSingleton('admin/session')->getUser()->getUsername());
				$transmit->setRecipient($model->getOrderEmail());
				$transmit->setFramecontractContractId($id);
				$transmit->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('framecontract')->__('E-Mail has been send.'));
				$this->_redirect('*/framecontract_contract/edit',array('id'=>$id));
			} else {
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('framecontract')->__('Contract does not exist'));
				$this->_redirect('*/*/');
			}
		}
		catch(Exception $ex)
		{
			Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
			Mage::logException($ex);
		}
	}
 
	
	public  function sendVendorEmail($data,$files)
    {
    	$storeid = $this->getStoreId();
    	$user = Mage::getSingleton('admin/session')->getUser();
    	$vendorEMail = array();
    	
    	if(strlen($data['vendor_email']) > 1)
    	{
    		$vendorEMail[] = $data['vendor_email'];
    	}
    
    	
    	if(Mage::getStoreConfig("framecontract/email/notify_owner", $storeid))
    	{
    		if(strlen($user->getEmail()) > 1)
    		{
    			$vendorEMail[] = $user->getEmail();
    		}
    	}
    	
    	
    	
    	   
    	
    	
    	$translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
 
        
        $template = Mage::getStoreConfig("framecontract/email/vendor_template", $storeid);
        
        
		$sender = array();
		$sender['name'] = trim($user->getFirstname(). " " .$user->getLastname());
        $sender['email'] = $user->getEmail();
        
        
        foreach($files->getItems() as $file)
        {
        	$fileContents = file_get_contents($file->getDiskFilename());
    		$attachment = $mailTemplate->getMail()->createAttachment($fileContents);
    		$attachment->filename = $file->getfilenameOriginal();	
        }
        
        //foreach ($vendorEMail as $mail)
        {
	        try {
			        $mailTemplate->setReturnPath($user->getEmail());
			        $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeid));
			        $mailTemplate->sendTransactional(
			                    $template,
			                    $sender,
			                    $vendorEMail,
			                    null,
			                   	$data
			                );
			        
			
			        $translate->setTranslateInline(true);
	        	}
	        
	    	catch(Exception $ex)
			{
				Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
				Mage::logException($ex);
			}
        }
        return $this;
    }
    
   public function getStoreId()
    {
        if (is_null($this->_storeId)) {
            $this->_storeId = Mage::app()->getStore()->getId();
        }
        return $this->_storeId;
    }
    
}