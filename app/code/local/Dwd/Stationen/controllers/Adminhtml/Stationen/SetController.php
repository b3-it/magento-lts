<?php

class Dwd_Stationen_Adminhtml_Stationen_SetController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('set/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('stationen/set')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('set_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('stationen/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('stationen/adminhtml_set_edit'))
				->_addLeft($this->getLayout()->createBlock('stationen/adminhtml_set_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stationen')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	
  	public function gridAction()
    {
    	$this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('stationen/adminhtml_stationen_edit_tab_set_grid')->toHtml()
        );
    }
    
    
 	public function stationenAction()
    {
    	$this->loadLayout();
    	$this->getLayout()->getBlock('stationen.grid')->setStationenSet($this->getRequest()->getPost('stationen_set',null));
    	$this->renderLayout();
    }
    
 	public function stationengridAction()
    {
    	$data = $this->getRequest()->getPost('stationen_set',null);
    	$this->loadLayout();
    	$this->getLayout()->getBlock('stationen.grid')->setStationenSet($this->getRequest()->getPost('stationen_set',null));
    	$this->renderLayout();
    }
    
 	public function productsAction()
    {
    	$this->loadLayout();
    	$this->getLayout()->getBlock('stationen.grid')->setProductsSet($this->getRequest()->getPost('products_set',null));
    	$this->renderLayout();
    }
    
 	public function productsgridAction()
    {
    	$this->loadLayout();
    	$this->getLayout()->getBlock('stationen.grid')->setProductsSet($this->getRequest()->getPost('products_set',null));
    	$this->renderLayout();
    }
    
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {

			
			$model = Mage::getModel('stationen/set');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			$stations = $this->getRequest()->getParam('stations');
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				$this->saveStationenRelation($model);
				$this->saveProductsRelation($model);
				

				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('stationen')->__('Item was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('stationen')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 

	
	private function saveStationenRelation($model)
	{
		$all = $this->getRequest()->getPost('all_selected');
		//falls der Tab nicht aufgerufen wurde ist all null
		if($all === null) return $this;
		$all = $this->decodeGridSerializedInput($all);
		if(is_array($all))
		{
			$all_Form = array_keys($all);
			$all_DB = $model->getStationen();
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
	
	private function decodeGridSerializedInput($encoded)
    {
        $isSimplified = (false === strpos($encoded, '='));
        $result = array();
        parse_str($encoded, $decoded);
        foreach($decoded as $key => $value) 
        {
           	$result[$key] = null;
            parse_str(base64_decode($value), $result[$key]);
        }
        return $result;
    }
	
	private function saveProductsRelation($model)
	{
		$all = $this->getRequest()->getPost('all_selected_products');
		//falls der Tab nicht aufgerufen wurde ist all null
		if($all === null) return $this;
				$all = Mage::helper('adminhtml/js')->decodeGridSerializedInput($all);
				if(is_array($all))
				{
					$all_Form = array_keys($all);
					
					$collection = Mage::getModel('catalog/product')->getCollection();
	  				$collection->addAttributeToFilter('stationen_set',$model->getId());
					$all_DB = $collection->getItems();
					if(!is_array($all_DB)) $all_DB = array();
					$all_DB = array_keys($all_DB);
					$delete = array_diff($all_DB,$all_Form);
					$new = array_diff($all_Form, $all_DB);
				}
				else {
					$delete = array();
					$new = array();
				}
				
				$model->updateSetProductRelation($new, $delete);
	}
	
	
	public function duplicateAction() 
	{
		$id     = $this->getRequest()->getParam('setid');
		$model  = Mage::getModel('stationen/set')->load($id);
		$stationen = array_keys($model->getStationen());
		$model->unsetData('entity_id')
			->setName($model->getName().' - ' . $this->__('copy'))
			->save();
		
		$model->updateSetStationRelation($stationen, array());
		

		Mage::getSingleton('adminhtml/session')->addSuccess($this->__('set duplicated'));
		$this->_redirect('*/*/edit',array('id'=>$model->getId()));
		
		
	}
	
	
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('stationen/set');
				 
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
        $setIds = $this->getRequest()->getParam('set');
        if(!is_array($setIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($setIds as $stationenId) {
                    $stationen = Mage::getModel('stationen/set')->load($stationenId);
                    $stationen->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($setIds)
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
        $setIds = $this->getRequest()->getParam('set');
        if(!is_array($setIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($setIds as $setId) {
                    $set = Mage::getSingleton('stationen/set')
                        ->load($stationenId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($setIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'set.csv';
        $content    = $this->getLayout()->createBlock('stationen/adminhtml_set_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'set.xml';
        $content    = $this->getLayout()->createBlock('stationen/adminhtml_stationen_edit_tab_set_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportStationenCsvAction()
    {
        $fileName   = 'set_stationen.csv';
        $content    = $this->getLayout()->createBlock('stationen/adminhtml_set_edit_tab_stationen_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportStationenXmlAction()
    {
        $fileName   = 'set_stationen.xml';
        $content    = $this->getLayout()->createBlock('stationen/adminhtml_set_edit_tab_stationen_grid')
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
    			return Mage::getSingleton('admin/session')->isAllowed('stationen/sets');
    			break;
    	}
    }
}