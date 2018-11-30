<?php

class TuChemnitz_Voucher_Model_Tan extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tucvoucher/tan');
    }
    
    
    /**
     * Nächste Freie Tan holen
     * @param Mage_Sales_Model_Order_Item $item
     */    
    public function getNextFreeTan($item)
    {
    	$id = $item->getId();
    	//$product_id = $item->getProduct()->getId();
    	$product_id = $item->getProductId();
    	$this->getResource()->allocateNextFreeTan($id,$product_id);
    	$this->load($id,'order_item_id');

    	if(!$this->getId())
    	{
    		$body = Mage::helper('tucvoucher')->__("Allocation of Tans for Order %s failed!", $item->getOrderId());
    		$this->sendMailToAdmin($body);
    		Mage::log("TuChemnitzVoucher:: Allocation of Tans for Order %s". $item->getOrderId()." failed!");
    	}
    	
    	
    	return $this->getTan(); 
    }
    
    
    /**
     * Löschen der Tans 
     * @param TuChemnitz_Voucher_Model_Tan $TanIds
     * @param Mage_Catalog_Model_Product $product_id
     * @return int Anzahl
     */
    public function deleteTans($TanIds, $product_id)
    {
    	
    	//tans löschen und zählen
    	$count = $this->getResource()->deleteTans($TanIds, $product_id);
    	
    	/* @var $product Mage_Catalog_Model_Product */
    	$product = Mage::getModel('catalog/product')->load($product_id);
    	$stockitem = $product->getStockItem();
    	
    	//nur setzen falls in Lagerverwaltung
    	if(!$stockitem->getManageStock())
    	{
    		Mage::log("TuC Voucher:: Voucher Product without Inventory found (ID: " .$product->getId() .")" , Zend_Log::ERR, Egovs_Extstock_Helper_Data::LOG_FILE);
    		return 0;
    	}
    	
   	
    	//lagerverwaltung setzten
    	if(Mage::helper('tucvoucher')->isModuleEnabled('Egovs_Extstock'))
    	{
    		Mage::getModel('extstock/extstock')->adjustInventory($product_id,$count *-1);
    	}
    	else
    	{
    		$stockitem = $product->getStockItem();
    		$totalQty = $stockitem->getQty() - $count;
    		$stockitem->setData("qty", $totalQty);
    		$stockitem->save();
    	}
    	
    	
    	
    	return $count;
    }
    
    public function countSoldTans($TanIds, $product_id)
    {
    	return $this->getResource()->countSoldTans($TanIds, $product_id);
    }
    
    
    public function countPendingOrders4Product()
    {
    	return $this->getResource()->countPendingOrders4Product($this->getProductId());
    }
    
    public function sendMailToAdmin($body, $subject="TAN Fehler:") {
    	{
    		$mailTo = $this->getAdminMail();
    		$mailTo = explode(';', $mailTo);
    		/* @var $mail Mage_Core_Model_Email */
    		$mail = Mage::getModel('core/email');
    		$shopName = Mage::getStoreConfig('general/imprint/shop_name');
    		$body = sprintf("Shop Name: %s\nWebsite: %s\n\n%s", $shopName, Mage::getBaseUrl(), $body);
    		$mail->setBody($body);
    		$mailFrom = $this->getGeneralContact();
    		$mail->setFromEmail($mailFrom['mail']);
    		$mail->setFromName($mailFrom['name']);
    		$mail->setToEmail($mailTo);
    
    		
    		$mail->setSubject($subject);
    		try {
    			$mail->send();
    		}
    		catch(Exception $ex) {
    			$error = Mage::helper('tucvoucher')->__('Unable to send email.');
    
    			if (isset($ex)) {
    				Mage::log($error.": {$ex->getTraceAsString()}", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    			} else {
    				Mage::log($error, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
    			}
    		}
    	}
    }
    
    /**
     * Email Adresse für Lowstock Warning festellen
     * @return Mage_Core_Model_Email
     */
    public  function getAdminMail() {
    	$mail = Mage::getStoreConfig('cataloginventory/lowstock_email/lowstock_email_address');
    	if (strlen($mail) > 0) {
    		return $mail;
    	}
    	return $this->getCustomerSupportMail();
    }
    
    public function getCustomerSupportMail($module = "paymentbase") {
    	//trans_email/ident_support/email
    	$mail = Mage::getStoreConfig('trans_email/ident_support/email');
    	if (strlen($mail) > 0) {
    		return $mail;
    	}
    
    	return Mage::helper($module)->__("Mail address not set")."!";
    }
    
    /**
     * Liefert den Allgemeinen Kontakt des Shops als array
     *
     * Format:</br>
     * array (
     * 	name => Name
     * 	mail => Mail
     * )
     *
     * @param string $module Modulname
     *
     * @return array <string, string>
     */
    public function getGeneralContact() {
    	/* Sender Name */
    	$name = Mage::getStoreConfig('trans_email/ident_general/name');
    	if (strlen($name) < 1) {
    		$name = 'Shop';
    	}
    	/* Sender Email */
    	$mail = Mage::getStoreConfig('trans_email/ident_general/email');
    	if (strlen($mail) < 1) {
    		$mail = 'dummy@shop.de';
    	}
    
    	return array('name' => $name, 'mail' => $mail);
    }
    
    
}