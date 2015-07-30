<?php

class Egovs_Extstock_Model_Lowstock extends Mage_Core_Model_Abstract
{

	public function testLowStock()
	{
		if(Mage::getStoreConfig('cataloginventory/lowstock_email/lowstock_send_email', 0))
		{
			$collection = $this->getLowStockCollection();
			$items = $collection->getItems();
			if(count($items) > 0){
				$this->sendEmail($items);
			}
		}
		
		return $this;
	}
	
	
	
	/**
	 * Alle Produkte mit geringen Lagerbestand finden
	 * @return LowStock Collection
	 */
	private function getLowStockCollection()
	{
		
		$storeId = '';
		
		/** @var $collection Mage_Reports_Model_Resource_Product_Lowstock_Collection  */
		$collection = Mage::getResourceModel('reports/product_lowstock_collection')
		->addAttributeToSelect('*')
		->setStoreId($storeId)
		->filterByIsQtyProductTypes()
		->joinInventoryItem('qty')
		->useManageStockFilter($storeId)
		->useNotifyStockQtyFilter($storeId)
		->setOrder('qty', Varien_Data_Collection::SORT_ORDER_ASC);
		
		if( $storeId ) {
			$collection->addStoreFilter($storeId);
		}
		
		return $collection;
	} 
	
	
	/**
	 *
	 * @param unknown $EmailAddress
	 * @param unknown $data e.g.
	 * @param unknown $template e.g "dwd_abo/email/renewal_abo_template"
	 * @return Egovs_Extstock_Model_Lowstock
	 */
	public function sendEmail($lowstock)
	{
		try
		{
			$storeid = 0;
			 
			$translate = Mage::getSingleton('core/translate');
			/* @var $translate Mage_Core_Model_Translate */
			$translate->setTranslateInline(false);
				
			$mailTemplate = Mage::getModel('core/email_template');
			/* @var $mailTemplate Mage_Core_Model_Email_Template */
				
				
			$template = Mage::getStoreConfig('cataloginventory/lowstock_email/lowstock_template', $storeid);
				
				
			$sender = array();
			$sender['email'] = Mage::getStoreConfig("cataloginventory/lowstock_email/lowstock_email_address", $storeid);
			$sender['name'] = Mage::getStoreConfig("cataloginventory/lowstock_email/lowstock_email_sender", $storeid);
	
			if(strlen($sender['name']) < 2){
				Mage::log('Extstock::Email Absendername ist in der Konfiguration nicht gesetzt.', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			}
	
			if(strlen($sender['email']) < 2){
				Mage::log('Extstock::Email Absendemail ist in der Konfiguration nicht gesetzt.', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			}
	
	
			$recipient = Mage::getStoreConfig("cataloginventory/lowstock_email/lowstock_recipient_email_address", $storeid);
			if(strlen($recipient) < 2){
				Mage::log('Extstock::Empfänger Email ist in der Konfiguration nicht gesetzt.', Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			}
			
			
			$data = array();
			
			$data['items'] = $lowstock;
			$data['current_date'] = time();//date('d.m.Y');
	
			//$mailTemplate->setReturnPath($sender['email']);
			$mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeid));
			$mailTemplate->sendTransactional(
					$template,
					$sender,
					$recipient,
					'',
					$data
			);
				
				
			$translate->setTranslateInline(true);
		}
		catch (Exception $ex)
		{
			Mage::log($e,Zend_Log::ERR, Egovs_Helper::LOG_FILE);
		}
		return $this;
	}
   	
}