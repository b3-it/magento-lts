<?php

class Slpb_Verteiler_Adminhtml_Slpbverteiler_VerteilerController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('verteiler/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('verteiler/verteiler')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('verteiler_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('verteiler/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('verteiler/adminhtml_verteiler_edit'))
				->_addLeft($this->getLayout()->createBlock('verteiler/adminhtml_verteiler_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('verteiler')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {	
			$model = Mage::getModel('verteiler/verteiler');		
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
				$this->saveCustomerRelation($model);
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('verteiler')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('verteiler')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	
	private function saveCustomerRelation($model)
	{
		$customers = $this->getRequest()->getParam('all_selected');
		$all = Mage::helper('adminhtml/js')->decodeGridSerializedInput($customers);
		//falls der Tab nicht aufgerufen wurde ist all null
		if($all === null) return $this;
		if(is_array($all))
			{
				$all_Form = array_keys($all);
				$all_DB = $model->getCustomers();
				if(!is_array($all_DB)) $all_DB = array();
				$all_DB = array_keys($all_DB);
				$delete = array_diff($all_DB,$all_Form);
				$new = array_diff($all_Form, $all_DB);
			}
			else {
				$delete = array();
				$new = array();
			}
		$model->updateCustomerRelation($new,$delete);
	}
	
	
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('verteiler/verteiler');
				 
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
        $verteilerIds = $this->getRequest()->getParam('verteiler');
        if(!is_array($verteilerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($verteilerIds as $verteilerId) {
                    $verteiler = Mage::getModel('verteiler/verteiler')->load($verteilerId);
                    $verteiler->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($verteilerIds)
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
        $verteilerIds = $this->getRequest()->getParam('verteiler');
        if(!is_array($verteilerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($verteilerIds as $verteilerId) {
                    $verteiler = Mage::getSingleton('verteiler/verteiler')
                        ->load($verteilerId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($verteilerIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'verteiler.csv';
        $content    = $this->getLayout()->createBlock('verteiler/adminhtml_verteiler_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'verteiler.xml';
        $content    = $this->getLayout()->createBlock('verteiler/adminhtml_verteiler_grid')
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
    
	public function customerAction()
    {
    	$this->loadLayout();
    	$this->getLayout()->getBlock('customer.grid')->setCustomerSet($this->getRequest()->getPost('customer_set',null));
    	$this->renderLayout();
    }
    
 	public function customergridAction()
    {
    	//$data = $this->getRequest()->getPost('customer_set',null);
    	$this->loadLayout();
    	$this->getLayout()->getBlock('customer.grid')->setCustomerSet($this->getRequest()->getPost('customer_set',null));
    	$this->renderLayout();
    }
    
 	protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('customer/slpb_verteiler');
    			break;
    	}
    }
}