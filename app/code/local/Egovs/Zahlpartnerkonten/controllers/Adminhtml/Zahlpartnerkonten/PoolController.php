<?php

class Egovs_Zahlpartnerkonten_Adminhtml_Zahlpartnerkonten_PoolController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('pool/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function newAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('zpkonten/pool')->load($id);

		//if ($model->getId() || $id == 0) 
		
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('pool_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('zpkonten/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Zahlpartnerkonten Manager'), Mage::helper('adminhtml')->__('Zahlpartnerkonten'));


			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('zpkonten/adminhtml_pool_new'));

			$this->renderLayout();
		
	}
 
	
	
	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('zpkonten/pool')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('pool_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('zpkonten/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('zpkonten/adminhtml_pool_edit'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zpkonten')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function createAction() {
		if ($data = $this->getRequest()->getPost()) {

			try {
				
				$start = intval($data['start']);
				$maximum = intval($data['maximum']);
				$increment = intval($data['increment']);
				
				if((strlen($data['start'])> 30) || (strlen($data['maximum'])> 30))
				{
					Mage::throwException(Mage::helper('zpkonten')->__('Es sind nur 30 Stellen zugelassen.'));
				}
				
				$length = Mage::getStoreConfig('payment_services/paymentbase/zpkonten_length');
				$prefix = Mage::getStoreConfig('payment_services/paymentbase/mandanten_kz_prefix');
				
				if (strlen($prefix) >= intval($length)) {
		    		Mage::throwException(Mage::helper('zpkonten')->__('Prefix is too long.'));
		    	} 
				
				$length -= strlen($prefix);
				if((strlen($data['start'])> $length) || (strlen($data['maximum'])> $length))
				{
					Mage::throwException(Mage::helper('zpkonten')->__('Es sind nur '.$length.' Stellen zugelassen.'));
				}
				
				$value = $start;
				
				while ($value <= $maximum)
				{
					$model = Mage::getModel('zpkonten/pool');	
					$model->setData($data);
					if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
					} else {
						$model->setUpdateTime(now());
					}	
					
					
					$model->validate()
						->createKassenzeichen($value)
						->save();
					$value += $increment;
				}

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('zpkonten')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
            	if(($e instanceof Zend_Db_Statement_Exception) && (strpos($e->getMessage(),'Duplicate entry')))
            	{
            		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zpkonten')->__('Duplicate entry: ').$model->getKassenzeichen());
            	}
            	else 
            	{
                	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            	}
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/new', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zpkonten')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			$model = Mage::getModel('zpkonten/pool');		
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
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('zpkonten')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('zpkonten')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
	
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('zpkonten/pool');
				 
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
        $fileName   = 'pool.csv';
        $content    = $this->getLayout()->createBlock('zpkonten/adminhtml_pool_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'pool.xml';
        $content    = $this->getLayout()->createBlock('zpkonten/adminhtml_pool_grid')
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
    
   public function massStatusAction()
    {
        $poolIds = $this->getRequest()->getParam('zpkonten_pool_id');
        if(!is_array($poolIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($poolIds as $poolId) {
                    $pool = Mage::getSingleton('zpkonten/pool')
                        ->load($poolId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($poolIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('system/zpkonten');
    			break;
    	}
    }
}