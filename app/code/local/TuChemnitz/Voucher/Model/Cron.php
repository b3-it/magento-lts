<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Model_Cron
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class TuChemnitz_Voucher_Model_Cron extends Mage_Core_Model_Abstract
{
 
    public static function disableOutdated()
    {
    	$collection = Mage::getModel('tucvoucher/tan')->getCollection();
    	$collection->getSelect()
    		->where("(expire) <= ('".Mage::getModel('core/date')->gmtDate()."')")
    		->order('product_id');
    	
    	
    	$voucherIds = array();
    	$lastProduct_id = 0;
    	foreach ($collection->getItems() as $voucher)
    	{
    		if(($voucher->getProductId() != $lastProduct_id) && (count($voucherIds) > 0))
    		{
    			$voucher->deleteTans($voucherIds, $voucher->getProductId());
    			$voucherIds = array();
    		}
    		$voucherIds[] = $voucher->getId();
    		$lastProduct_id = $voucher->getProductId();
    		
    	}
    	
		//letzen löschen
    	if((count($voucherIds) > 0))
    	{
    		Mage::getModel('tucvoucher/tan')->deleteTans($voucherIds, $lastProduct_id);
    	}
    	
    }
    
    
    
    
  
    		
    
}