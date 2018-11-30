<?php

class Slpb_Extstock_Adminhtml_Extstock_StockController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';
        
		$this->loadLayout()
			->_setActiveMenu('extstock/stock')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
        $block = $this->getLayout()->createBlock('extstock/adminhtml_stock');
        $this->_addContent($block);		
		return $this;
	}   
 
	public function indexAction() {
	
		$this->_initAction()
			->renderLayout();
	}
	
	/**
     * Product grid for AJAX request
     */
    public function gridAction()
    {
    	$this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('extstock/adminhtml_stock_grid')->toHtml()
        );
    }
 
	public function editAction() {
		
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('extstock/stock')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) 
			{
				$model->setData($data,$this->getRequest()->getParam('mode'));
				
			}
			$model->setData('mode',$this->getRequest()->getParam('mode'));
			Mage::register('extstock_data', $model);
			
				$this->loadLayout();
				$this->_setActiveMenu('extstock/stock');
				$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Stock Manager'), Mage::helper('adminhtml')->__('Stock Manager'));
		
			
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('extstock/adminhtml_stock_edit'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extstock')->__('Stock does not exist'));
			$this->_redirect('*/*/');
		}
		
	}
 
	public function newAction() {
		$this->_forward('edit');
	}


	
	public function saveAction() {
		
		if($data = $this->getRequest()->getPost())
		{
			
			
			$model = Mage::getModel('extstock/stock');
			
			
			
			$id = $this->getRequest()->getParam('id');
			$model->setData($data)
				  ->setId($id);
			
			try {
				/*
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				*/
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('extstock')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				//$this->_redirect($this->getRedirectUrl());
				/*
				if(($mode = Mage::getSingleton('adminhtml/session')->getData('extstockmode')) && ($mode == 'product'))
				{
					die('<html><script>window.close();</script></html>');
				}
				*/
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            

			
			
			return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extstock')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('extstock/stock');
				 
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
        $extstockIds = $this->getRequest()->getParam('extstock');
        if(!is_array($extstockIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($extstockIds as $extstockId) {
                    $extstock = Mage::getModel('extstock/extstock')->load($extstockId);
                    $extstock->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($extstockIds)
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
        $extstockIds = $this->getRequest()->getParam('extstock');
        if(!is_array($extstockIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($extstockIds as $extstockId) {
                    $extstock = Mage::getSingleton('extstock/extstock')
                        ->load($extstockId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($extstockIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'extstock.csv';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_extstock_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'extstock.xml';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_extstock_grid')
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
    	return Mage::getSingleton('admin/session')->isAllowed('system/stock');
    }
}