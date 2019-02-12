<?php

class Slpb_Extstock_Adminhtml_Extstock_JournalController extends Slpb_Extstock_Controller_Adminhtml_Stockorder
{
	private $_DeliveryId = null;
	
	protected function _initAction() {
		$act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';
        
		$this->loadLayout()
			->_setActiveMenu('extstock/journal')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Stock Journal'), Mage::helper('adminhtml')->__('Item Manager'));
        $block = $this->getLayout()->createBlock('extstock/adminhtml_journal');
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
            $this->getLayout()->createBlock('extstock/adminhtml_journal_grid')->toHtml()
        );
    }
 
    
	public function newAction() {
		
		$req = $this->getRequest();
		$model  = Mage::getModel('extstock/journal');

		$model->setData('qty',urldecode($req->getParam('qty')));
		$model->setData('qty_ordered',urldecode($req->getParam('qty')));
		
		$model->setData('product_id',$req->getParam('product_id'));
		
		
		$model->setData('date_ordered',Zend_Date::now()->__toString());
		$model->setData('input_stock_id',$req->getParam('input_stock_id'));
		//$model->setData('user_ident',Mage::getSingleton('admin/session')->getUser()->getId());
		//f�r den R�cksprung zum Warning Grid
		$model->setData('grid','warning');
		Mage::register('extstock_journal_data', $model);	
		$this->loadLayout();
		$this->_setActiveMenu('extstock/items');
		$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Order Manager'), Mage::helper('adminhtml')->__('Order Manager'));
		
		
		$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);
		$block = $this->getLayout()->createBlock('extstock/adminhtml_journal_edit');
		$this->_addContent($block);

		$this->renderLayout();
		
		
	}
    
    
    
    
	public function editAction() {
		
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('extstock/journal')->loadWithProductInfo($id);

		
		if ($model->getId() || $id == 0) {
			/*
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) 
			{
				$model->setData($data,$this->getRequest()->getParam('mode'));
				
			}
			$model->setData('mode',$this->getRequest()->getParam('mode'));
			*/
			Mage::register('extstock_journal_data', $model);
			
				$this->loadLayout();
				$this->_setActiveMenu('extstock/items');
				$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Order Manager'), Mage::helper('adminhtml')->__('Order Manager'));
		
			
			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$block = $this->getLayout()->createBlock('extstock/adminhtml_journal_edit');
			$this->_addContent($block);

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extstock')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
		
	}
 
	public function saveAction() {
		
		if($data = $this->getRequest()->getPost())
		{
			$id = $this->getRequest()->getParam('id');
			
			$model = Mage::getModel('extstock/journal')->load($id);
			
			//$data = $model->setQuantity($data);
			
			$oldstatus = $model->getStatus();
			$newstatus = $data['status'];
			
			$model->setData('qty',$data['qty']);
			$model->setData('status',$data['status']);
			$model->setData('date_delivered',$data['delivered']);
			$model->setData('date_ordered',$data['ordered']);
			$model->setData('note',$data['note']);
			$model->setData('product_id',$data['product_id']);
			$model->setData('input_stock_id',$data['input_stock_id']);
			$model->setData('user_ident',Mage::getSingleton('admin/session')->getUser()->getId());
//var_dump($model); die();			
			if(isset($data['output_stock_id']))
			{
				$model->setData('output_stock_id',$data['output_stock_id']);
			}
		
			try {
				
				$desired_date = Mage::getModel('core/date')->date(null, $data['delivered']);
				
				if(!$model->getData('deliveryorder_increment_id'))
				{
					$soid = $this->createStockOrder($model->getData('input_stock_id'), $model->getData('output_stock_id'),$desired_date,$model->getNote());
				
					$model->setData('deliveryorder_increment_id',$soid);
				}
				$model->save();
				
				//warenbewegung vollziehen falls geliefert
				if(($oldstatus != $newstatus) &&($newstatus == Slpb_Extstock_Model_Journal::STATUS_DELIVERED))
				{
						$this->move($model);

				}
				
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('extstock')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				
				if ($this->getRequest()->getParam('grid')&& ($this->getRequest()->getParam('grid')== 'warning')) {
					$this->_redirect('adminhtml/extstock_warning');
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
                $this->_redirect('*/*/edit', array('id' => $model->getId()));
                return;
            }
            
			
			
			return;
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('extstock')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}

	
	
	private function move($model)
	{
		$product_id = $model->getProductId();
		$qty = $model->getQty();
		$from_stock_id = $model->getOutputStockId();
		$to_stock_id = $model->getInputStockId();
		
		
		if (!$from_stock_id) {
			Mage::throwException("Output Stock not specified!");
		}
		if (!$to_stock_id) {
			Mage::throwException("Input Stock not specified!");
		}
		
		if (!$product_id) {
			Mage::throwException("Product not specified!");
		}
		
		

		$journal_id = $model->getId();
		
		$rest = Mage::getModel('extstock/extstock')->moveQuantity($product_id, $qty, $from_stock_id, $to_stock_id, $journal_id);
		if($rest > 0)
		{
			Mage::getSingleton('adminhtml/session')->addError("Konnte $rest nicht umbuchen ( ProductId: $product_id )");
			Mage::log("extstock::move Rest=". $rest . " ProductId=". $product_id, Zend_log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
	}
	
	public function massDeliveredAction()
	{
		$params = $this->getRequest()->getParams();
		
		if (!$params) {
			$this->_redirect('*/*/index');
			return;
		}
		
		if (!isset($params['journal_id'])) {
			$this->_redirect('*/*/index');
			return;
		}
		
		
		$journal_ids = explode(',',$params['journal_id']);
		$journals = explode(',',$params['journal_keys']);
		$amounts = explode(',',$params['amount_to_order']);

		try
		{
			for($i = 0, $iMax = count($journals); $i < $iMax; $i++)
			{
				$journal = $journals[$i];	
				$amount = $amounts[$i];
		
				if(in_array($journal,$journal_ids))
				{
					$model = Mage::getModel('extstock/journal')->load($journal);
					$model->setData('qty',$amount);
					$model->setData('status',Slpb_Extstock_Model_Journal::STATUS_DELIVERED);
					$model->setData('date_delivered',now());
					$this->move($model);
					$model->save();
				}
			}
		} catch (Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
		}
		$this->_redirect('*/*/index');
	}
	
   
	public function massDeleteAction() {
        $extstockIds = $this->getRequest()->getParam('journal_id');
        $extstockIds = explode(',',$extstockIds);
        if(!is_array($extstockIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
            		$n = 0;
                foreach ($extstockIds as $extstockId) {
                    $extstock = Mage::getModel('extstock/journal')->load($extstockId);
                    if($extstock->getStatus() == Slpb_Extstock_Model_Journal::STATUS_ORDERED)
                    {
                    	$extstock->delete();
                    	$n++;
                    }
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', $n
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('adminhtml/extstock_journal/index');
    }
	

    public function exportCsvAction()
    {
        $fileName   = 'journal.csv';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_journal_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'journal.xml';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_journal_grid')
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
    			return Mage::getSingleton('admin/session')->isAllowed('extstock/journal');
    			break;
    	}
    }
}