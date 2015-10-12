<?php

class Dwd_Stationen_Adminhtml_Stationen_DerivationController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('derivation/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$parent_id     = $this->getRequest()->getParam('parent_id');
		$model  = Mage::getModel('stationen/derivation')->load($id);
		if($model->getId())
		{
			$model->loadCategoryRelation();
		}
		
		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}
			if (!$model->getId())
			{
				$model->setParentId($parent_id);
				$station = Mage::getModel('stationen/stationen')->load($parent_id); 
		      	$model->setData('name', $station->getName());
		      	$model->setData('lat', $station->getLat());
		      	$model->setData('lon', $station->getLon());
		      	$model->setData('height', $station->getHeight());
		      	$model->setData('short_description', $station->getShortDescription());
		      	$model->setData('description', $station->getDescription());
			}
			Mage::register('derivation_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('stationen/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('stationen/adminhtml_derivation_edit'));

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
		
			$model = Mage::getModel('stationen/derivation');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save()->updateCategoryRelation(array($data['category_id']));
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('stationen')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('stationen/adminhtml_stationen/edit',array('id'=>$model->getParentId(),'tab'=>'derivation_section'));
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
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('stationen/derivation');
				 
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
        $derivationIds = $this->getRequest()->getParam('derivation');
        if(!is_array($stationenIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($stationenIds as $stationenId) {
                    $stationen = Mage::getModel('stationen/derivation')->load($stationenId);
                    $stationen->delete();
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
        $derivationIds = $this->getRequest()->getParam('derivation');
        if(!is_array($stationenIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($derivationIds as $derivationId) {
                    $derivation = Mage::getSingleton('stationen/derivation')
                        ->load($stationenId)
                        ->derivationStatus($this->getRequest()->getParam('status'))
                        ->derivationIsMassupdate(true)
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
  
    public function exportCsvAction()
    {
        $fileName   = 'derivation.csv';
        $content    = $this->getLayout()->createBlock('stationen/adminhtml_stationen_edit_tab_derivation_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

  	public function gridAction()
    {
    	$this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('stationen/adminhtml_stationen_edit_tab_derivation_grid')->toHtml()
        );
    }
    
    public function exportXmlAction()
    {
        $fileName   = 'derivation.xml';
        $content    = $this->getLayout()->createBlock('stationen/adminhtml_derivation_grid')
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