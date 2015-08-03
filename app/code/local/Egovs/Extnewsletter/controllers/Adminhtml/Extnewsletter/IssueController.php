<?php

class Egovs_Extnewsletter_Adminhtml_Extnewsletter_IssueController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('newsletter/issue')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Newsletter'), Mage::helper('adminhtml')->__('Manage Issues'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('extnewsletter/issue')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('issue_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('extnewsletter/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('extnewsletter/adminhtml_issue_edit'));
				//->_addLeft($this->getLayout()->createBlock('extnewsletter/adminhtml_issue_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extnewsletter')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = $_FILES['filename']['name'];
			}
	  			
	  			
			$model = Mage::getModel('extnewsletter/issue');		
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
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('extnewsletter')->__('Issue was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extnewsletter')->__('Unable to find Issue to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('extnewsletter/issue');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Issue was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $issueIds = $this->getRequest()->getParam('issue');
        if(!is_array($extnewsletterIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($extnewsletterIds as $extnewsletterId) {
                    $extnewsletter = Mage::getModel('extnewsletter/issue')->load($extnewsletterId);
                    $extnewsletter->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($extnewsletterIds)
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
        $issueIds = $this->getRequest()->getParam('issue');
        if(!is_array($extnewsletterIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($issueIds as $issueId) {
                    $issue = Mage::getSingleton('extnewsletter/issue')
                        ->load($extnewsletterId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($extnewsletterIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'issue.csv';
        $content    = $this->getLayout()->createBlock('extnewsletter/adminhtml_issue_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'issue.xml';
        $content    = $this->getLayout()->createBlock('extnewsletter/adminhtml_issue_grid')
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
    
    public function availIssuseAction()
    {
		$store_id = $this->getRequest()->getParam('id'); 
		$store_id = trim($store_id,',');
		$store_id = explode(",", $store_id); 
		
		$collection = Mage::getResourceModel('extnewsletter/issue_collection');
		$collection->addStoreOrAllFilter($store_id);  	
		$option = "";
        foreach ($collection->getItems() as $item)
        {
        	$option .= "<option value=\"".$item->getId()."\">".$item->getTitle()."</option>";
        }

		$this->getResponse()->setBody($option);
    }
    
    
    public function massaction4ordersAction()
    {
    	$Ids = $this->getRequest()->getPost('order_ids');
    	$issue = $this->getRequest()->getPost('issue_id');
    	
    	if($Ids && is_array($Ids) && $issue)
    	{
    		$Ids = implode(',', $Ids);
	    	$custommers = array();
	    	
	    	$collection = Mage::getModel('sales/order')->getCollection();
	    	$collection->getSelect()
	    		->where('entity_id IN ('.$Ids.')');
	    	foreach($collection->getItems() as $item)
	    	{
	    		$custommers[] = $item->getCustomerId();
	    	}
    	
	    	$res = Mage::getModel('extnewsletter/issue')->subscribeCustomersToIssue($custommers, $issue);
	    	Mage::getSingleton('adminhtml/session')-> addSuccess($this->__('%s Entries are added!', $res));
    	}
    	$this->_redirect('adminhtml/sales_order/');
    }
    
    public function massaction4customersAction()
    {
    	$Ids = $this->getRequest()->getPost('customer');
    	$issue = $this->getRequest()->getPost('issue_id');
    	if($Ids && is_array($Ids) && $issue)
    	{
    		$res = Mage::getModel('extnewsletter/issue')->subscribeCustomersToIssue($Ids, $issue);
    		Mage::getSingleton('adminhtml/session')-> addSuccess($this->__('%s Entries are added!', $res));
    	}
    	$this->_redirect('adminhtml/customer/');
    }
  	
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('newsletter/items');
    			break;
    	}
    }
}