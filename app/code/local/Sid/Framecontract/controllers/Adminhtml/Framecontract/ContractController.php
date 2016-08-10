<?php

class Sid_Framecontract_Adminhtml_Framecontract_ContractController extends Mage_Adminhtml_Controller_action
{

	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('contract/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
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
	
	
	
	private function _edit($id)
	{
		$model  = Mage::getModel('framecontract/contract')->load($id);
		
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
		
			Mage::register('contract_data', $model);
		
			$this->loadLayout();
			$this->_setActiveMenu('framecontract/items');
		
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));
		
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		
			$this->_addContent($this->getLayout()->createBlock('framecontract/adminhtml_contract_edit'))
			->_addLeft($this->getLayout()->createBlock('framecontract/adminhtml_contract_edit_tabs'));
		
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('framecontract')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
	
	
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	
	private function saveFile($formId, $contractId, $type)
	{	
		if(isset($_FILES[$formId]['name']) && $_FILES[$formId]['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader($formId);
					
					// Any extention would work
	           		//$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(true);
							
					
					
					$model = Mage::getModel('framecontract/files');	
					$model->setFramecontractContractId($contractId);
					$model->save();
					$filename = md5($contractId . "_" . $model->getId() . time().$_FILES[$formId]['name'] . time());
					
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS . 'framecontract' . DS ;
					//$uploader->save($path, $_FILES[$formId]['name'] );
					$uploader->save($path, $filename);
					
					
					$model->setFilenameOriginal($_FILES[$formId]['name']);
					$model->setFilename($uploader->getUploadedFileName());
					$model->setType($type);
					$model->save();
					
					
					
					
				} catch (Exception $e) {
		      
						//var_dump($e); die();
		        }
	        
		        	
		        
		}
		
	}
	
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			

	  			
	  			
			$model = Mage::getModel('framecontract/contract');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$id = $this->getRequest()->getParam('id');
				if($id)
				{
					$old = Mage::getModel('framecontract/contract')->load($id);
					
					if($old->getStatus() != $model->getStatus())
					{
						
						
						if($model->getStatus() == Sid_Framecontract_Model_Status::STATUS_DISABLED){
							$status = Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
							$old_status =  Mage_Catalog_Model_Product_Status::STATUS_ENABLED;
						}
						else {
							$status = Mage_Catalog_Model_Product_Status::STATUS_ENABLED;
							$old_status =  Mage_Catalog_Model_Product_Status::STATUS_DISABLED;
						}
						
						
						$products = Mage::getModel('catalog/product')->getCollection();
						$products->addAttributeToFilter('framecontract',$id);
						$products->addAttributeToFilter('status', $old_status);
						
						
						$productIds = array();
						foreach ($products->getItems() as $product) 
						{
							$productIds[] = $product->getId();
						}
						
						if(count($productIds) > 0){
							Mage::getSingleton('catalog/product_action')
								->updateAttributes($productIds, array('status' => $status), 0);
						}
					}
				}
				
				
				$model->save();
				$this->saveLose($model);
				$this->saveFile('filename1', $model->getId(),Sid_Framecontract_Model_Filetype::TYP_CONFIG);
				$this->saveFile('filename2', $model->getId(),Sid_Framecontract_Model_Filetype::TYP_INFO);
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('framecontract')->__('Contract was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('framecontract')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	
	private function saveLose($contract)
	{
		if ($lose = $this->getRequest()->getPost('lose')){
			foreach($lose as $los){
				$model = Mage::getModel('framecontract/los')->load(intval($los['los_id']));
				if($los['is_delete']){
					$model->delete();
				}else{
					$model->setTitle($los['title']);
					$model->setStatus(intval($los['status']));
					$model->setNote($los['note']);
					$model->setFramecontractContractId($contract->getId());
					$id = $model->getId();
					$model->save();
					
					if(!$id || isset($los['newkey']) ){
						$model->setKey($this->getNewKey($contract, $model))->save();
					}
					
					if(isset($los['sendlink'])){
						Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('framecontract')->__('Email was successfully send'));
						$this->sendEMail($contract, $model);
					}
				}
			}
		}
	}
	
	
	private function getNewKey($contract, $los)
	{
		return sha1($contract->getId(). $los->getId(). now());
	}
	
	
	private function sendEMail($contract,$los)
	{
		//Email senden
		$template = 'framecontract/email/upload_request_template';
		$recipients = array();
		$recipients[] = array('name' => $contract->getVendor()->getOperator(),'email'=>$contract->getVendor()->getEmail());
		$data = array();
		$data['contract'] = $contract->getTitle().'/'.$los->getTitle();
		$storeid = $contract->getStoreId();
		Mage::helper('framecontract')->sendEmail($template, $recipients, $data, $storeid);
		
		//info speichern
		$note = "Link zu Los versendet " . $los->getKey();
		Mage::helper('framecontract')->saveEmailSendInformation($contract->getId(),$los->getId(), $recipients, $note );
		
	}
	
	
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('framecontract/contract');
				 
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
        $fileName   = 'contract.csv';
        $content    = $this->getLayout()->createBlock('framecontract/adminhtml_contract_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'contract.xml';
        $content    = $this->getLayout()->createBlock('framecontract/adminhtml_contract_grid')
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
    
    
    protected function downloadAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model = Mage::getModel('framecontract/files')->load($id);
        $helper = Mage::helper('downloadable/file');

       
        $fileName       = $model->getFilenameOriginal();
        $contentType    = $helper->getFileType($model->getFilenameOriginal());      
        
        $this->getResponse()
            ->setHttpResponseCode(200)
            ->setHeader('Pragma', 'public', true)
            ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
            ->setHeader('Content-type', $contentType, true)
			->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        
        /*
        if ($fileSize = $helper->getFilesize()) {
            $this->getResponse()
                ->setHeader('Content-Length', $fileSize);
        }
		*/
        
        $this->getResponse()
            ->clearBody();
        $this->getResponse()
            ->sendHeaders();

        $handle = new Varien_Io_File();
        $path = Mage::getBaseDir('media') . DS . 'framecontract' . DS ;
        $handle->streamOpen($path.$model->getFilename(),"r");
    	while ($buffer = $handle->streamRead()) {
                print $buffer;
            }
            die();
    }
    
    
    protected function deletefileAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model = Mage::getModel('framecontract/files')->load($id);
    	$path = Mage::getBaseDir('media') . DS . 'framecontract' . DS ;
    	
    	//für den Aufruf des Vertrages id merken
    	$id = $model->getFramecontractContractId();
    	
    	if($model->getId())
    	{
	    	try {
	    		unlink($path.$model->getFilename());
	    		$model->delete()->save();
	    	}
	    	catch(Exception $ex)
	    	{
	    		Mage::logException($e);
	    	}
	    	
	    	$this->_edit($id);
	    	return;
    	}
    	
    	$this->_redirect('*/*/');
    	
    }
    
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('framecontract/contract');
    			break;
    	}
    }
    
    public function transmitgridAction()
    {
    	$id     = $this->getRequest()->getParam('id');
    	$model  = Mage::getModel('framecontract/contract')->load($id);
    	
    	Mage::register('contract_data', $model);
    	
	    $this->loadLayout(false);
	    $this->getResponse()->setBody(
	    			$this->getLayout()->createBlock('framecontract/adminhtml_contract_edit_tab_transmit_grid')->toHtml()
	    );
    	
    }
    
}