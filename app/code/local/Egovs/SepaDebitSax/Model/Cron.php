<?php
/**
 * SepadebitSax Cron
 * 
 * @category   	SepadebitSax
 * @package    	SepadebitSax
 * @name       	SepadebitSax
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_SepaDebitSax_Model_Cron extends Mage_Core_Model_Abstract
{
 
   
	
	public function runSync($schedule)
	{
			
		$lastRun = date("Y-m-d H:i:s", (time()- (60 * 60)));
		$statusRun = Mage_Cron_Model_Schedule::STATUS_RUNNING;
		$statusSuc = Mage_Cron_Model_Schedule::STATUS_SUCCESS;
		
		$collection = $schedule->getCollection();
		$collection->addFieldToFilter('job_code', $schedule->getJobCode())
			->addFieldToFilter($schedule->getIdFieldName(), array('neq' => $schedule->getId()))
			->addFieldToSelect('status')

			//->getSelect()->where("((finished_at >= '".$lastRun . "' and status = '".$statusSuc."') OR (executed_at >'".$lastRun."'  AND status = '".$statusRun."'))");
			->getSelect()->where("(executed_at >'".$lastRun."'  AND status = '".$statusRun."')");
		;
		
		
		if ($collection->count() > 0) {
			$message = Mage::helper('sepadebitsax')->__('sepadebitsax service is still running');
			Mage::log($message, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
			throw new Exception($message);
		}
		
		Mage::app()->addEventArea(Mage_Core_Model_App_Area::AREA_FRONTEND);
		
		try {
			Mage::log(Mage::helper('sepadebitsax')->__('sepadebitsax service started'), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			$this->syncAll();
			Mage::log(Mage::helper('sepadebitsax')->__('sepadebitsax service finished'), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		} catch (Exception $e) {
			Mage::logException($e);
			Mage::log(Mage::helper('sepadebitsax')->__('There was an runtime error for the sepadebitsax service. Please check your log files.'), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
			throw($e);
		}
		
		return true;
	}
	
  
	/**
	 * Prüft ob für offene SEPA Bestellungen noch ausstehende Mandate aktiviert worden
	 * 
	 * @return Egovs_SepaDebitSax_Model_Cron
	 */
    public function syncAll() {
    	/* @var $orders Mage_Sales_Model_Entity_Order_Collection */
    	$orders = Mage::getModel('sales/order')->getCollection();
    	//STATE_PENDING_PAYMENT
    	$orders->addFieldToFilter('state', array('eq' =>  Mage_Sales_Model_Order::STATE_PENDING_PAYMENT));
    	//$orders->addFieldToFilter('status', array('eq' => 'pending'));
    	$quotedParentId = $orders->getConnection()->quoteIdentifier('parent_id');
    	$quotedMethod = $orders->getConnection()->quoteIdentifier('method');
    	$quotedOrderId = $orders->getConnection()->quoteIdentifier('main_table.entity_id');
    	$orders->join('sales/order_payment', $orders->getConnection()->quoteInto("$quotedParentId=$quotedOrderId AND $quotedMethod IN (?)", array('sepadebitsax')), 'method')
    			->getSelect()->group('entity_id')
    		;
    	foreach ($orders->getItems() as $order) {
    		/* @var $order Mage_Sales_Model_Order */
    		/* @var $invoice Mage_Sales_Model_Order_Invoice */
    		try {
	    		$transactionSave = Mage::getModel('core/resource_transaction');
				foreach ($order->getInvoiceCollection() as $invoice) {
					if ($invoice->getState() == Mage_Sales_Model_Order_Invoice::STATE_OPEN) {
						$invoice->capture();
						$transactionSave->addObject($invoice);
					}
				}
				$order->setIsInProcess(true);
				$transactionSave->addObject($order);
				$transactionSave->save();
    		} catch(Exception $e) {
    			if ($e->getCode() == Egovs_SepaDebitSax_Model_Sepadebitsax::SEPA_MANDATE_EXCEPTION_CODE_CANCEL
    					|| $e->getCode() == Egovs_SepaDebitSax_Model_Sepadebitsax::SEPA_MANDATE_EXCEPTION_CODE_INACTIVE
    			) {
    				Mage::log($e->getMessage(), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);
    			} else {
    				Mage::logException($e);
    			}
    		}
    	}

    	return $this;
    }
}