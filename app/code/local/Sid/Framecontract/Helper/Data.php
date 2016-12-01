<?php
/**
 * 
 *  Helper
 *  @category Egovs
 *  @package  Sid_Framecontract_Helper_Data
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2016 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Framecontract_Helper_Data extends Mage_Core_Helper_Abstract
{

	/**
	 * 
	 * @param string $template Path
	 * @param array $recipient array(array('name'=>'Max','email'=>'max@xx.de'))
	 * @param array $data template Data
	 * @param number $storeid default 0
	 * @param array dateien die versendet werden sollen
	 * @return void|Sid_Framecontract_Helper_Data
	 */
	public function sendEmail($template, array $recipients, array $data = array(), $storeid = 0, $files = null)
	{
		if(!is_numeric($template))
		{
			$template = Mage::getStoreConfig($template, $storeid);
		}
		$translate = Mage::getSingleton('core/translate');
		/* @var $translate Mage_Core_Model_Translate */
		$translate->setTranslateInline(false);
	
		$mailTemplate = Mage::getModel('core/email_template');
		/* @var $mailTemplate Mage_Core_Model_Email_Template */
			
		$sender = array();
		$sender['name'] = Mage::getStoreConfig("framecontract/email/sender_name", $storeid);
		$sender['email'] = Mage::getStoreConfig("framecontract/email/sender_email_address", $storeid);
	
		
		if(strlen($sender['name']) < 2 ){
			$sender['name'] = Mage::getStoreConfig('trans_email/ident_general/name', $storeid);
		}
		
		if(strlen($sender['email']) < 2 ){
			$sender['email'] = Mage::getStoreConfig('trans_email/ident_general/email', $storeid);
		}
		
		if(Mage::getStoreConfig("framecontract/email/notify_owner", $storeid))
		{
			$recipients[] = $sender;
		}
		
		$emails = array();
		$names = array();
		
		foreach($recipients as $recipient)
		{
			$emails[] = $recipient['email'];
			$names[] = $recipient['name'];
		}
		
		//Dateien anhängen
		if(isset($files))
		{
			if(!is_array($files)){
				$files = array($files);
			}
			foreach($files as $file)
			{
				$fileContents = file_get_contents($file->getDiskFilename());
				$attachment = $mailTemplate->getMail()->createAttachment($fileContents);
				$attachment->filename = $file->getfilenameOriginal();
			}
		}
		
		$mailTemplate->setReturnPath($sender['email']);
		$mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$storeid));
		
		try{
			$mailTemplate->sendTransactional(
					$template,
					$sender,
					$emails,
					$names,
					$data,
					$storeid
			);
		}
		catch(Exception $ex)
		{
			Mage::logException($ex);
		}
	
		$translate->setTranslateInline(true);
	
		return $this;
	}
	
	
	/**
	 * Speichert die Info über die gesendete Email am Rahmenvertrag 
	 * @param int $contractId
	 * @param array $recipients
	 * @param string $user
	 */
	public function saveEmailSendInformation($contractId, $losId, array $recipients, $note ='', $user = null)
	{
		if($user == null){
			$user = Mage::getSingleton('admin/session')->getUser()->getUsername();
		}
		foreach($recipients as $recipient)
		{
			$name = trim($recipient['name'] . ' (' . $recipient['email']).')';
			$transmit = Mage::getModel('framecontract/transmit');
			$transmit->setOwner($user);
			$transmit->setRecipient($name);
			$transmit->setFramecontractContractId($contractId);
			$transmit->setLosId($losId);
			$transmit->setNote($note);
			$transmit->save();
		}
	}
	
	
	public function getStockStatusCollection($StoreId = null)
	{
		/* @var $eav Mage_Eav_Model_Entity_Attribute */
		$eav = Mage::getResourceModel('eav/entity_attribute');
		$status = $eav->getIdByCode('catalog_product', 'status');
		$los = $eav->getIdByCode('catalog_product', 'framecontract_los');
		$qty = $eav->getIdByCode('catalog_product', 'framecontract_qty');
		$name = $eav->getIdByCode('catalog_product', 'name');
		$price = $eav->getIdByCode('catalog_product', 'price');
	
		$priceSum = new Zend_Db_Expr('ROUND(price.value * (qty.value - stock.qty),2) as totalprice');
		$sold = new Zend_Db_Expr('qty.value - stock.qty as sold');		
		$sold_p = new Zend_Db_Expr('IF(qty.value <> 0, ((qty.value - stock.qty)/qty.value * 100), 0) as sold_p');
	
		$manage_stock = Mage::getStoreConfig('cataloginventory/item_options/manage_stock');
		
		$manageStockExpr = new Zend_Db_Expr('stock.manage_stock = 1 OR ( stock.use_config_manage_stock = 1 AND '.$manage_stock.'=1)' );
		
		/* @var $collection Mage_Catalog_Model_Resource_Product_Collection */
		$collection = Mage::getModel('catalog/product')->getCollection();
	
		$collection->getSelect()
		->columns($sold)
		->columns($priceSum)
		->columns($sold_p)
		->join(array('status'=>$collection->getTable('catalog/product').'_int'), 'status.entity_id=e.entity_id AND status.attribute_id ='.$status)
		->join(array('los'=>$collection->getTable('catalog/product').'_int'), 'los.entity_id=e.entity_id AND los.attribute_id ='.$los,array('los_id'=>'value'))
		->join(array('qty'=>$collection->getTable('catalog/product').'_int'), 'qty.entity_id=e.entity_id AND qty.attribute_id ='.$qty, array('contract_qty'=>'value'))
		->join(array('price'=>$collection->getTable('catalog/product').'_decimal'), 'price.entity_id=e.entity_id AND price.attribute_id ='.$price, array('price_value'=>'value'))
		->join(array('name'=>$collection->getTable('catalog/product').'_varchar'), 'name.entity_id=e.entity_id AND name.store_id=0 AND name.attribute_id ='.$name, array('name'=>'value'))
		->join(array('stock'=>$collection->getTable('cataloginventory/stock_item')),'stock.product_id=e.entity_id',array('stock_qty'=>'qty'))
		
		->where('status.value = '. Mage_Catalog_Model_Product_Status::STATUS_ENABLED)
		->where($manageStockExpr)
		;
		
		if($StoreId !== null){
			$collection->getSelect()->where('e.store_group = '.intval($StoreId));
		}
		
		//die($collection->getSelect()->assemble());
		return $collection;
	}
	
}