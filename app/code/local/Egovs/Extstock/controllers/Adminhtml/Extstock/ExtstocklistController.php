<?php

class Egovs_Extstock_Adminhtml_Extstock_ExtstocklistController extends Mage_Adminhtml_Controller_Action
{
	protected $_base = 'extstock';
	
	protected $_group = 'extstocklist';
	
	protected function _isAllowed() {
		try {
			$action = $this->getRequest()->getActionName();
			return Mage::getSingleton('admin/session')->isAllowed(sprintf("%s/%s", $this->_base,$this->_group));
		} catch (Exception $e) {
			return false;
		}
	}

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('extstock/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
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
            $this->getLayout()->createBlock('extstock/adminhtml_extstocklist_grid')->toHtml()
        );
    }

	private function getRedirectUrl()
	{
		if($mode = Mage::getSingleton('adminhtml/session')->getData('extstockmode'))
		{
				if($mode == 'product') return Mage::getSingleton('adminhtml/session')->getData('extstockproducturl');
					else return '*/*/';
		}
		
		return '*/*/';
	}
	
	public function editAction() {
		
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('extstock/extstock')->load($id);

		$product_id = $model->getProductId();
		$distributor = $model->getDistributor();
		if ($product_id) {
			//Redirect zu Lagerbestellung mit gesetzten Filter
			$this->_redirect('extstock/adminhtml_extstock/', array('product_id' => $product_id, 'distributor' => $distributor));
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extstock')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}		
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {		
	}
 
	public function deleteAction() {
//		if( $this->getRequest()->getParam('id') > 0 ) {
//			try {
//				$model = Mage::getModel('extstock/extstock');
//				 
//				$model->setId($this->getRequest()->getParam('id'))
//					->delete();
//					 
//				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
//				$this->_redirect('*/*/');
//			} catch (Exception $e) {
//				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
//				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
//			}
//		}
//		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
//        $extstockIds = $this->getRequest()->getParam('extstock');
//        if(!is_array($extstockIds)) {
//			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
//        } else {
//            try {
//                foreach ($extstockIds as $extstockId) {
//                    $extstock = Mage::getModel('extstock/extstock')->load($extstockId);
//                    $extstock->delete();
//                }
//                Mage::getSingleton('adminhtml/session')->addSuccess(
//                    Mage::helper('adminhtml')->__(
//                        'Total of %d record(s) were successfully deleted', count($extstockIds)
//                    )
//                );
//            } catch (Exception $e) {
//                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
//            }
//        }
//        $this->_redirect('*/*/index');
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
}