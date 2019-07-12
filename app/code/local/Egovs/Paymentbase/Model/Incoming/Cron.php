<?php
/**
 * Created by PhpStorm.
 * User: holger
 * Date: 12.07.2019
 * Time: 12:18
 */

class Egovs_Paymentbase_Model_Incoming_Cron extends Mage_Core_Model_Abstract
{

   public function runCron(){
       $this->_runCron();
   }



   protected function _runCron()
    {

        $collection  = Mage::getModel('paymentbase/incoming_payment')->getCollection();
        $collection->getSelect()
            ->where('paid is NULL')
            ->order('id');


        foreach ($collection->getItems() as $item){
            $item->calculatePaidAmound();
            $item->save();
        }

    }



}