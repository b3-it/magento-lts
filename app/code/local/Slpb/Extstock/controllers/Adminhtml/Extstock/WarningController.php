<?php

class Slpb_Extstock_Adminhtml_Extstock_WarningController extends Slpb_Extstock_Controller_Adminhtml_Stockorder
{

	protected function _initAction() {
		$act = $this->getRequest()->getActionName();
        if(!$act)
            $act = 'default';
        
		$this->loadLayout()
			->_setActiveMenu('extstock/warning')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Stock Detail'), Mage::helper('adminhtml')->__('Item Manager'));
        $block = $this->getLayout()->createBlock('extstock/adminhtml_warning');
        $this->_addContent($block);		
		return $this;
	}   
 
	public function indexAction() {
	
		$this->_initAction()
			->renderLayout();
	}
	
	public function movementAction() {
		$params = $this->getRequest()->getParams();
		
		if (!$params) {
			$this->_forward('index');
			return;
		}
		
		if (!isset($params['product_id'])) {
			$this->_forward('index');
			return;
		}
		
		//Produktids kommen als concat(product_id,"_",stock_id)
		//
		$product_ids = array();//explode(',',$params['product_id']);
		$tmp = explode(',',$params['product_id']);
		foreach($tmp as $t)
		{
			$t = explode('_',$t);
			$product_ids[] = $t[0];
		}
		
		$products = explode(',',$params['product_keys']);
		$destinations = explode(',',$params['destination']);
		$amounts = explode(',',$params['amount_to_order']);
		$packages = explode(',',$params['package']);
		$move = array();
		for($i = 0, $iMax = count($products); $i < $iMax; $i++)
		{
			$product = $products[$i];
			$destination = $destinations[$i];
			$amount = $amounts[$i];
			$package = $packages[$i];
			if(in_array($product,$product_ids))
			{
				if($amount > 0)
				{
					$move[] = array('qty'=>$amount * $package,'destination'=>$destination,'product'=>$product,'source'=> $params['source'],'desired_date'=>$params['desired_date'],'note'=>$params['note']);
				}
			}
		}
		
		//vorhandne Mengen ermitteln
		$collection = Mage::getResourceModel('extstock/detail_collection');
		$collection->getSelect()->where('main_table.stock_id = ?', intval($params['source']));
		$stockItems = array();
		foreach($collection->getItems() as $item)
		{
			$stockItems[$item->getProductId()] = $item->getQty();
		}
		
		//plausibilit�t testen
		
		$msg = array();
		foreach($move as $m)
		{
			if($m['destination'] == $m['source'])
			{
				$msg[] = 'Ziel und Quelle sind gleich! (ProduktID '.$m['product'].')';
			}
			$qty = 0;
			if(isset($stockItems[$m['product']])){$qty = $stockItems[$m['product']];}
			if($qty < $m['qty'])
			{
				$msg[] = 'Im Quelllager ist nur eine Menge von '. $qty.' vorhanden! (ProduktID '.$m['product'].')';
			}
		}
		
		if(count($msg) > 0)
		{
			Mage::getSingleton('adminhtml/session')->addError(implode(',',$msg));
			//$this->_forward('index');
			$this->_redirect('*/*/index');
			return;
		}
		$this->saveMovement($move);
		
		$this->_redirect('adminhtml/extstock_ordersheet/index',array('lieferid'=>$this->_StockOrderId));
	}
	
	
	
	private function saveMovement($move)
	{
		if(count($move) == 0) return $this;
		$move = array_values($move);
		$desired_date = Mage::getModel('core/date')->date(null, $move[0]['desired_date']);
		$note = $move[0]['note'];
		$this->createStockOrder($move[0]['destination'],$move[0]['source'],$desired_date,$note);
		
		foreach($move as $m)
		{
			
			$model = Mage::getModel('extstock/journal');
			//$model->setData('qty',$m['qty']);
			$model->setData('qty_ordered',$m['qty']);
			$model->setData('status',Slpb_Extstock_Model_Journal::STATUS_ORDERED);
			//$model->setData('date_delivered',now());
			$model->setData('date_ordered', now());
			$model->setData('note',$note);
			$model->setData('product_id',$m['product']);
			$model->setData('input_stock_id',$m['destination']);
			$model->setData('output_stock_id',$m['source']);
			$model->setData('deliveryorder_increment_id',$this->_StockOrderId);
			$model->setData('user_ident',Mage::getSingleton('admin/session')->getUser()->getId());
			//$model->setData('desired_date',$desired_date);
			$model->save();
		}
	} 
	
	/**
     * Product grid for AJAX request
     */
    public function gridAction()
    {
    	$this->_forward('index');
    }
 

    public function exportCsvAction()
    {
        $fileName   = 'extstock.csv';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_warning_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'extstock.xml';
        $content    = $this->getLayout()->createBlock('extstock/adminhtml_warning_grid')
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
    			return Mage::getSingleton('admin/session')->isAllowed('extstock/warning');
    			break;
    	}
    }
}