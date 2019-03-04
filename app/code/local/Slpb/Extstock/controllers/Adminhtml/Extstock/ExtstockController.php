<?php

class Slpb_Extstock_Adminhtml_Extstock_ExtstockController extends Mage_Adminhtml_Controller_action
{
	protected $_base = 'extstock';
	
	protected $_group = 'extstockorderlist';
	
	protected function _isAllowed() {
		try {
			$action = $this->getRequest()->getActionName();
			return Mage::getSingleton('admin/session')->isAllowed(sprintf("%s/%s", $this->_base,$this->_group));
		} catch (Exception $e) {
			return false;
		}
	}

	protected function _initAction() {
		$act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';
            
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
            $this->getLayout()->createBlock('extstock/adminhtml_extstock_grid')->toHtml()
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

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) 
			{
				$model->setData($data,$this->getRequest()->getParam('mode'));
				
			}
			$model->setData('mode',$this->getRequest()->getParam('mode'));
			Mage::register('extstock_data', $model);

			if(($mode = Mage::getSingleton('adminhtml/session')->getData('extstockmode')) && ($mode == 'product'))
				{
					$this->loadLayout('popup');
				}
			else
			{
				$this->loadLayout();
				$this->_setActiveMenu('extstock/items');
				$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Order Manager'), Mage::helper('adminhtml')->__('Order Manager'));
			}
			
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('extstock/adminhtml_extstock_edit'))
				->_addLeft($this->getLayout()->createBlock('extstock/adminhtml_extstock_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extstock')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
		
	}
 
	//wird von warning grid aufgerufen
	public function newAction() 
	{
		$req = $this->getRequest();
		$model  = Mage::getModel('extstock/extstock');

		$model->setData('quantity_ordered',urldecode($req->getParam('quantity_ordered')));
		$model->setData('product_id',$req->getParam('product_id'));
		$model->setData('sku',urldecode($req->getParam('sku')));
		$model->setData('productname',urldecode($req->getParam('productname')));
		$model->setData('date_ordered',Zend_Date::now()->__toString());
		$model->setData('stock_id',$req->getParam('stock_id'));
		//$model->setData('user_ident',Mage::getSingleton('admin/session')->getUser()->getId());
		//für den Rücksprung zum Warning Grid
		$model->setData('mode','warning');
		
		Mage::register('extstock_data', $model);
		Mage::getSingleton('adminhtml/session')->setData('extstockmode','warning');
		
		$this->loadLayout();
		$this->_setActiveMenu('extstock/items');
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Order Manager'), Mage::helper('adminhtml')->__('Order Manager'));
					
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

		$this->_addContent($this->getLayout()->createBlock('extstock/adminhtml_extstock_edit'))
				->_addLeft($this->getLayout()->createBlock('extstock/adminhtml_extstock_edit_tabs'));

		$this->renderLayout();
		
	}

	/**
	 * Reorders the given product!
	 * 
	 */ 
	protected function _reorder(&$data) {
		$helper = Mage::helper('extstock');
		$reorderData = array();
		foreach ($data as $key => $value) {
			if (stristr($key, Slpb_Extstock_Helper_Data::REORDER) === false)
				continue;

			if ($value != NULL && isset($value) && $value != "") {
				$newKey = str_ireplace(Slpb_Extstock_Helper_Data::REORDER."_", "", $key);
				$reorderData[$newKey] = $value;	
			}			
			unset($data[$key]);				
		}
		
		/* 
		 * Prüfen ob es eine Nachbestellung gibt!
		 * Muss größer 1 sein, da Bestimmungslager immer gesetzt ist und
		 * 
		 * Bestellmenge, Preis und Bestelldatum Pflichtfelder sind!
		 */
		if (count($reorderData) < 2) {
			return;
		}
		
		$id = $data['product_id'];
		$reorderData['product_id'] = $id;
		$reorderData['status'] = Slpb_Extstock_Helper_Data::ORDERED;
				
		
		if(($reorderData['quantity_ordered']+0) > 0)
		{
			if ($reorderData['price'] < 0) {
				$msg = $helper->__("Extended Stock").": ";
				$msg .= $helper->__("Price can't be less than 0, skipping extended stock save [Product ID: %s]", $id)."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Slpb_Extstock_Helper_Data::LOG_FILE);
				Mage::getSingleton('adminhtml/session')->addWarning($msg);
				return;
			}
			$storeDate = Mage::app()->getLocale()->storeDate();
			$orderDate = Mage::app()->getLocale()->date($reorderData['date_ordered']);
			if (!$reorderData['date_ordered'] || is_null($reorderData['date_ordered']) || $orderDate->isLater($storeDate, Zend_Date::DATE_MEDIUM)) {
				$msg = $helper->__("Extended Stock").": ";
				$msg .= $helper->__("Ordered date can't be tomorrow, skipping extended stock save [Product ID: %s]", $id)."!";
				Mage::log("extstock::$msg", Zend_Log::NOTICE, Slpb_Extstock_Helper_Data::LOG_FILE);
				Mage::getSingleton('adminhtml/session')->addWarning($msg);
				return;
			}
			
			Mage::getModel('extstock/extstock')->setData($reorderData)->save();
		} else {
			$isEmpty = true;
			foreach($reorderData as $key => $value) {
				if ($key == 'product_id'
					|| $key == 'status')
					continue;
				
				if ($value && strlen($value) > 0) {
					$isEmpty = false;
					break;
				}				
			}
			
			if ($isEmpty)
				return;
				
			$msg = $helper->__("Extended Stock").": ";
			if (($reorderData['quantity_ordered']+0) < 1) {
				$msg .= $helper->__("Ordered quantity is less than 1");
			} else {
				$msg .= $helper->__("Unknown reason");
			}
			$msg .= $helper->__(", skipping extended store save. [Product ID: %s]", $id)."!";
			Mage::log("extstock::$msg", Zend_Log::NOTICE, Slpb_Extstock_Helper_Data::LOG_FILE);
			Mage::getSingleton('adminhtml/session')->addWarning($msg);
		}
	}
	
	public function saveAction() {
		
		if($data = $this->getRequest()->getPost())
		{
			$this->_reorder($data);
			
			$model = Mage::getModel('extstock/extstock');
			
			$data = $model->setQuantity($data);
			
			$id = $this->getRequest()->getParam('id');
			$model->setData($data)
				  ->setId($id);
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('extstock')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				
				
				if($this->getRequest()->getParam('mode') == 'warning')
				{
					Mage::getSingleton('adminhtml/session')->unsetData('extstockmode');
					$this->_redirect('adminhtml/extstock_warning', array('id' => $model->getId()));
					return;
				}
				
				
				$this->_redirect('*/*/');
				//$this->_redirect($this->getRedirectUrl());
				
				if(($mode = Mage::getSingleton('adminhtml/session')->getData('extstockmode')) && ($mode == 'product'))
				{
					die('<html><script>window.close();</script></html>');
				}
				
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
            
			//"Auf Lager" Wert setzen!
			if (is_array($data) && array_key_exists('is_in_stock', $data) && array_key_exists('product_id', $data)) {
				//TODO: Muss hier Stock mit berücksichtigt werden?!!!
				$collection = Mage::getModel('cataloginventory/stock_item')->getCollection()
	        		->addFieldToFilter("product_id", array("eq" => $data['product_id']));
	        	if ($collection && !is_null($collection) && $collection->getSize() > 0) {
	        		foreach ($collection as $item) {
		        		if ($item->getData('is_in_stock') != $data['is_in_stock']) {
			        		$item->setData('is_in_stock', $data['is_in_stock']);
			        		$item->save();
		        		}
	        		}
	        	}
			}
			
			return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extstock')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('extstock/extstock');
				 
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
}