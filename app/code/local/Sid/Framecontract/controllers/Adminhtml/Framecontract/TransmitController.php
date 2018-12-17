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
				
				$files = Mage::getModel('framecontract/files')->getCollection();
				$expr = new Zend_Db_Expr('framecontract_contract_id='.$id.' AND ((type='.Sid_Framecontract_Model_Filetype::TYP_CONFIG.') OR (type='.Sid_Framecontract_Model_Filetype::TYP_INFO.'))');
				$files->getSelect()
					->where($expr);
				
			
				$this->sendVendorEmail($model,$files);
				
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
 
	
	
	
	public  function sendVendorEmail($contract,$files)
    {
    	$storeid = $contract->getStoreId();
    	
    	//Email senden
    	$template = Mage::getStoreConfig("framecontract/email/vendor_template", $storeid);
    	$recipients = array();
    	$recipients[] = array('name' => $contract->getVendor()->getOperator(),'email'=>$contract->getVendor()->getEmail());
    	
    	
    	
    	$data = array();	
    	$data['title'] = $contract->getTitle();
    	$data['contractnumber'] = $contract->getContractnumber();
    	$data['contract'] = $contract;
    	
    	$attachments = array();
    	if($files)
    	{
	    	foreach($files->getItems() as $file)
	    	{
	    		$fileContents = file_get_contents($file->getDiskFilename());
	    		$attachment = array();
	    		$attachment['content'] = $fileContents;
	    		$attachment['filename'] = $file->getfilenameOriginal();
	    		$attachments[] = $attachment;
	    	}
    	}
    	
    	
    	
    	
    	
    	Mage::helper('framecontract')->sendEmail($template, $recipients, $data, $storeid,$attachments);
    	
    	//info speichern
    	$note = "Infos zum Rahmenvertrag versendet";
    	Mage::helper('framecontract')->saveEmailSendInformation($contract->getId(),0, $recipients, $note );
    	
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
    	return Mage::getSingleton('admin/session')->isAllowed('framecontract/contract');
    }
    
}