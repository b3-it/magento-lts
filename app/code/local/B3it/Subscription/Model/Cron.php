<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Cron
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Model_Cron extends Mage_Core_Model_Abstract
{


    public function run($schedule)
    {
        $apcKey = $schedule->getJobCode().'_cron_mutex_'.$schedule->getId();
        if (function_exists('apc_add') && function_exists('apc_fetch')) {
            if (apc_fetch($apcKey)) {
                Mage::log($schedule->getJobCode().": already called, omitting!", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
                return true;
            }

            //dauert ca. 1msec
            //TTL = 180s = 3Min
            $apcAdded = apc_add($apcKey, true, 60);
        }


        $last_run = date("Y-m-d H:i:s", (time()- (60 * 60)));

        $collection = $schedule->getCollection();
        $collection->addFieldToFilter('job_code', $schedule->getJobCode())
            ->addFieldToFilter($schedule->getIdFieldName(), array('neq' => $schedule->getId()))
            ->addFieldToSelect('status')
            ->getSelect()
            ->where("(executed_at >'".$last_run."'  AND status = '". Mage_Cron_Model_Schedule::STATUS_RUNNING."')");



        if ($collection->count() > 0) {
            $message = $schedule->getJobCode().' service is still running';
            Mage::log($message, Zend_Log::WARN, Egovs_Helper::LOG_FILE);
            throw new Exception($message);
        }

        $this->_collect();
        if (function_exists('apc_delete'))
        {
            apc_delete($apcKey);
        }
        return true;
    }



    protected function _collect()
    {
        $this->setLog("Subscription service started");
    	$model = Mage::getModel('b3it_subscription/order_renewal');
    	$model->renewAllPendingOrders();
        $this->setLog("Subscription service finished ..............");
    }
    
    
    
    
  
    		
    
}