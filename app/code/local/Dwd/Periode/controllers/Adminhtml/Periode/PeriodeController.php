<?php

class Dwd_Periode_Adminhtml_Periode_PeriodeController extends Mage_Adminhtml_Controller_action
{
	public function addRowAction()
	{
		
		$data = array();
		$data['id'] = $this->getRequest()->getParam('periode_id');
		$data['label'] = $this->getRequest()->getParam('periode_label');
		$data['duration'] = $this->getRequest()->getParam('periode_duration');
		$data['product_id'] = $this->getRequest()->getParam('periode_product');
		$data['type'] = $this->getRequest()->getParam('periode_type');
		$data['from'] = $this->getRequest()->getParam('periode_from');
		$data['to'] = $this->getRequest()->getParam('periode_to');
		$data['unit'] = $this->getRequest()->getParam('periode_unit');
		$data['price'] = $this->getRequest()->getParam('periode_price');
		$data['cancelation_period'] = $this->getRequest()->getParam('cancelation_period');
		$data['tierprice'] = json_decode($this->getRequest()->getParam('periode_tier_price'));
		$data['store_id'] = json_decode($this->getRequest()->getParam('store_id'));

		$error = $this->_addRow($data);
		
		$content = $this->getContent($data['product_id'],$error, $data['store_id']);
		
		$response = $this->getResponse();
		$response->setBody($content);
        $response->sendResponse();
        die;
	}
	
	public function deleteRowAction()
	{
		$id = $this->getRequest()->getParam('id');
		$product_id = $this->getRequest()->getParam('product_id');
		
		$periode = Mage::getModel('periode/periode')->load($id);
		$periode->delete()->save();
		$content = $this->getContent($product_id,null);
		
		$response = $this->getResponse();
		$response->setBody($content);
        $response->sendResponse();
        die;
	}
	
	protected function _addRow($data) {
		/* @var $periode Dwd_Periode_Model_Periode */
		$periode = Mage::getModel('periode/periode');
		
		$periode->addData($data);
		if($data['id'] > 0)
		{
			$periode->setId($data['id']);
		}
		
		/*
		 * 20130207::Frank Rochlitzer
		 * Das Enddatum enthielt nur den Datumsteil z. B. 07.02.2013
		 * In der DB wird es aber mit dem Zeitstempel gespeichert, es entsteht 07.02.2013 00:00:00
		 * Richtig wäre aber 07.02.2013 23:59:00
		 */
		if ($periode->getType() == Dwd_Periode_Model_Periode_Type::PERIOD_TIMESPAN) {
			$endDate = $periode->getEndZendDate()->addSecond(86399);
			$periode->setTo($endDate->toString(Dwd_Periode_Model_Periode::MAGENTO_DATETIME));
		}
		
		$periode->deleteTierPrices();
		$validate = $periode->validate();
		if ($validate === null) {
			if(isset($data['tierprice']))
			{
				$tpCollection = $periode->getTierPrices();
				foreach ($data['tierprice'] as $tier)
				{
					if($tier[0] && $tier[1])
					{
						$tp = Mage::getModel('periode/tierprice');
						$tp->setQty($tier[0]);
						$tp->setPrice($tier[1]);
						$tpCollection->addItem($tp);
					}
					
				}
			}
			
			
			$periode->save();
		}
		return $validate;		
	}

	
   protected function getContent($product_id,$error,$store_id)
   {
   		$block = $this->getLayout()->createBlock('periode/adminhtml_catalog_product_edit_tab_periode_content');
   		$block->setData('product_id',$product_id);
   		$block->setData('store_id',$store_id);
   		$block->setData('error',$error);
   		
   		return  $block->toHtml(); 
   }
   
   protected function _isAllowed()
   {
   		return Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/newproducts/productsave')|| 
   			Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/disabledproducts/productsave')|| 
   			Mage::getSingleton('admin/session')->isAllowed('admin/catalog/products/enabledproducts/productsave') ;
   }
  
	
}