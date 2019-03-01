<?php
class Sid_Framecontract_Adminhtml_Framecontract_VendorController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('framecontract/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Vendor Manager'), Mage::helper('adminhtml')->__('Vendor Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}


	
	public function editAction() {
		
		$id = $this->getRequest()->getParam('id');
		$id = intval($id);
		$model  = Mage::getModel('framecontract/vendor');
		if($id > 0){
			$model->load($id);
		}
	

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('vendor_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('framecontract/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('framecontract/adminhtml_vendor_edit'))
				->_addLeft($this->getLayout()->createBlock('framecontract/adminhtml_vendor_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('framecontract')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

            $path = Mage::helper('exportorder')->getBaseStorePathForCertificates();

            if (isset($data['client_certificate_delete'])) {
                $data['transfer']['client_certificate'] = null;
                $data['transfer']['client_certificate_pwd'] = null;
            }

            if (isset($data['client_ca_delete'])) {
                $data['transfer']['client_ca'] = null;
            }

            $_useClientCertCa = false;
            if (isset($data['use_clientcert_ca'])) {
                $_useClientCertCa = (bool)$data['use_clientcert_ca'];
            }

            if(isset($_FILES['client_certificate']['name']) && $_FILES['client_certificate']['name'] != '') {
                try {
                    $uploader = new Varien_File_Uploader('client_certificate');
                    // Any extension would work
                    $uploader->setAllowedExtensions(array('p12', 'pfx'));
                    $uploader->setValidMimeTypes(array('application/x-pkcs12', 'application/octet-stream', 'text/plain'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(true);
                    $uploader->setAllowCreateFolders(true);

                    $uploader->save($path);

                    $_result = Mage::helper('exportorder')->convertPkcs12ToPem($path.$uploader->getUploadedFileName(), $data['transfer']['client_certificate_pwd'], $_useClientCertCa);

                    @unlink($path.$uploader->getUploadedFileName());

                    //this way the name is saved in DB
                    if (isset($_result['key'])) {
                        $data['transfer']['client_certificate'] = $_result['key'];
                    }
                    if (isset($_result['ca'])) {
                        $data['transfer']['client_ca'] = $_result['ca'];
                    }
                } catch (Exception $e) {
                    $msg = Mage::helper('framecontract')->__("Can't save client certificate! Error Message was: ");
                    $msg .= Mage::helper('framecontract')->__($e->getMessage());
                    Mage::getSingleton('adminhtml/session')->addError($msg);
                }
            }

            if(isset($_FILES['client_ca']['name']) && $_FILES['client_ca']['name'] != '') {
                try {
                    $uploader = new Varien_File_Uploader('client_ca');
                    // Any extention would work
                    $uploader->setAllowedExtensions(array('cer', 'cert', 'crt', 'pem'));
                    $uploader->setValidMimeTypes(array('application/x-x509-ca-cert', 'text/plain'));
                    $uploader->setAllowRenameFiles(false);
                    $uploader->setFilesDispersion(true);
                    $uploader->setAllowCreateFolders(true);

                    $path = Mage::helper('exportorder')->getBaseStorePathForCertificates();
                    $uploader->save($path);

                    //this way the name is saved in DB
                    $data['transfer']['client_ca'] = $uploader->getUploadedFileName();
                } catch (Exception $e) {
                    $msg = Mage::helper('framecontract')->__("Can't save CA certificate! Error Message was: ");
                    $msg .= Mage::helper('framecontract')->__($e->getMessage());
                    Mage::getSingleton('adminhtml/session')->addError($msg);
                }
            }

            $model = Mage::getModel('framecontract/vendor');
            $model->setData($data)
                ->setId($this->getRequest()->getParam('id'));

            if ($model->hasClientCertificateDelete()) {
                $model->setClientCertificate('');
            }

            if ($model->hasClientCaDelete()) {
                $model->setClientCa('');
            }

			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();

                if ($transfer = $model->getTransfer()) {
                    if (is_array($transfer)) {
                        $transfer = new Varien_Object($transfer);
                    }
                    if ($transfer->getCheckConnection() == true && $model->getTransferType() == 'post') {
                        if (($_result = $model->getTransferModel()->checkConnection()) === true) {
                            Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('framecontract')->__('Successfully connected to remote host'));
                        } else {
                            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('framecontract')->__('Error while connection to remote host: %s', $_result));
                        }
                    }
                }

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('framecontract')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
				    $_args = array('id' => $model->getId());
				    if ($_tab = $this->getRequest()->getParam('tab')) {
				        $_args['tab'] = $_tab;
                    }
					$this->_redirect('*/*/edit', $_args);
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
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('framecontract/vendor');
				 
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
        $vendorIds = $this->getRequest()->getParam('vendor');
        if(!is_array($vendorIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($vendorIds as $vendorId) {
                    $vendor = Mage::getModel('framecontract/vendor')->load($vendorId);
                    $vendor->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($vendorIds)
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
        $vendorIds = $this->getRequest()->getParam('vendor');
        if(!is_array($vendorIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($vendorIds as $vendorId) {
                    Mage::getSingleton('framecontract/vendor')
                    ->load($vendorId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($vendorIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'vendor.csv';
        $content    = $this->getLayout()->createBlock('framecontract/adminhtml_vendor_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'vendor.xml';
        $content    = $this->getLayout()->createBlock('framecontract/adminhtml_vendor_grid')
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
    
    public function defaultAction() 
    {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('framecontract/vendor')->load($id);

		if ($model->getId()) 
		{
			$o = array('name'=>$model->getOperator(),'email'=>$model->getOrderEmail());
			die(json_encode($o));
		}
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('framecontract/vendor');
    			break;
    	}
    }
}