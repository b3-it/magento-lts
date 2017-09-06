<?php

class Dwd_Stationen_Adminhtml_Stationen_StationenController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('stationen/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$storeId = $this->getRequest()->getParam('store', 0);
		$model  = Mage::getModel('stationen/stationen')
			->setStoreId($storeId)
			->load($id);
		
		
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			if($model->getId()== null)
			{
				$model->setData('avail_from',now());
			}

			Mage::register('stationen_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('stationen/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			
			$left = $this->getLayout()->createBlock('stationen/adminhtml_stationen_edit_tabs'); 
			$this->_addContent($this->getLayout()->createBlock('stationen/adminhtml_stationen_edit'));
			$this->_addLeft($left);

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stationen')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			$storeId = intval($this->getRequest()->getParam('store_id'));
			$id = intval($this->getRequest()->getParam('id'));
			$model = Mage::getModel('stationen/stationen')
				->setStoreId($storeId)
				->load($id);		
			$model->setData($data)
				->setId($id);
			$sets = $this->getRequest()->getParam('sets');
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				//$model->setStoreId($storeId);
				$model->save();
				if($model->getStatus() == Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE)
				{
					$this->saveSetRelation($model);
				}
				else 
				{
					$model->removeSetStationRelation();
				}
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('stationen')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId(),'store'=>$storeId));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
	           	if(($e instanceof Zend_Db_Statement_Exception) && (strpos($e->getMessage(),'Duplicate entry')))
            	{
            		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stationen')->__('Such Station already exists.'));
            	}
            	else 
            	{
                	Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                	throw $e;
            	}
 
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id'),'store'=>$storeId));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stationen')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	private function saveSetRelation($model)
	{
		$all = $this->getRequest()->getPost('all_selected');
		//falls der Tab nicht aufgerufen wurde ist all null
		if($all === null) return $this;
		$all = Mage::helper('adminhtml/js')->decodeGridSerializedInput($all);
		if(is_array($all))
		{
			$all_Form = array_keys($all);
			
  			$all_DB = $this->getStationen($model);
			if(!is_array($all_DB)) $all_DB = array();
			$all_DB = array_keys($all_DB);
			$delete = array_diff($all_DB,$all_Form);
			$new = array_diff($all_Form, $all_DB);
		}
		else {
			$delete = array();
			$new = array();
		}
		
		$model->updateSetStationRelation($new, $delete);
	}
	
	private function getStationen($model)
	{
		$collection = Mage::getModel('stationen/set')->getCollection();
  			$collection->getSelect()
  				->distinct()
  				->join(array('relation'=>'stationen_set_relation'),"set_id = entity_id AND stationen_id=".$model->getId(),array());
  		$res = array();
  		foreach ($collection->getItems() as $item) 
  		{
  			$res[$item->getId()] = $item;
  		}

  		return $collection->getItems();
		
	}
  	
	
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('stationen/stationen');
				 
				$model->load($this->getRequest()->getParam('id'))
					->setAvailTo(now())
					->setStatus(Dwd_Stationen_Model_Stationen_Status::STATUS_DELETED)
					->save();
					 
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
        $stationenIds = $this->getRequest()->getParam('stationen');
        if(!is_array($stationenIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($stationenIds as $stationenId) {
                    $stationen = Mage::getModel('stationen/stationen')->load($stationenId);
                    $stationen->setAvailTo(now())
                    	->setStatus(Dwd_Stationen_Model_Stationen_Status::STATUS_DELETED)
                    	->save();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($stationenIds)
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
        $stationenIds = $this->getRequest()->getParam('stationen');
        if(!is_array($stationenIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($stationenIds as $stationenId) {
                    $stationen = Mage::getSingleton('stationen/stationen')
                        ->load($stationenId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($stationenIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    
    
 	public function setAction()
    {
    	$this->loadLayout();
    	$this->getLayout()->getBlock('stationen.grid')->setStationenSet($this->getRequest()->getPost('stationen_set',null));
    	$this->renderLayout();
    }
    
 	public function setgridAction()
    {
    	$data = $this->getRequest()->getPost('stationen_set',null);
    	$this->loadLayout();
    	$this->getLayout()->getBlock('stationen.grid')->setStationenSet($this->getRequest()->getPost('stationen_set',null));
    	$this->renderLayout();
    }
    
    
    
    public function exportCsvAction()
    {
        $fileName   = 'stationen.csv';
        $content    = $this->getLayout()->createBlock('stationen/adminhtml_stationen_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'stationen.xml';
        $content    = $this->getLayout()->createBlock('stationen/adminhtml_stationen_grid')
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
    			return Mage::getSingleton('admin/session')->isAllowed('stationen/stationen');
    			break;
    	}
    }
}