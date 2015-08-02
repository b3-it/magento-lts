<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Newsletter
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Newsletter queue saver
 * 
 * @category   Egovs
 * @package    Egovs_Extnewsletter
 */ 
class Egovs_Extnewsletter_Model_Mysql4_Queue extends Egovs_Extnewsletter_Model_Resource_Queue// Mage_Newsletter_Model_Mysql4_Queue//Mage_Core_Model_Mysql4_Abstract
{
    
  
       
    /**
     * Add subscribers to queue
     *
     * @param Mage_Newsletter_Model_Queue $queue
     * @param array $subscriberIds
     */
    public function addSubscribersToQueue(Mage_Newsletter_Model_Queue $queue, array $subscriberIds) 
    {
        if (count($subscriberIds)==0) {
            Mage::throwException(Mage::helper('newsletter')->__('No subscribers selected'));
        }
        
        if (!$queue->getId() && $queue->getQueueStatus()!=Mage_Newsletter_Model_Queue::STATUS_NEVER) {
            Mage::throwException(Mage::helper('newsletter')->__('Invalid queue selected'));
        }
        
        $select = $this->_getWriteAdapter()->select();
        $select->from($this->getTable('queue_link'),'subscriber_id')
            ->where('queue_id = ?', $queue->getId())
            ->where('subscriber_id in (?)', $subscriberIds);
        
 
        //speichern der formulardaten
        $subscribercollection = Mage::getModel('extnewsletter/mysql4_subscribercollection')
        			->saveProductQueue($queue->getId());
        
        Mage::getModel('extnewsletter/mysql4_queueissue')->saveIssueQueue($queue->getId());
    
        $usedIds = $this->_getWriteAdapter()->fetchCol($select);
        $this->_getWriteAdapter()->beginTransaction();
        try {
            foreach($subscriberIds as $subscriberId) {
                if(in_array($subscriberId, $usedIds)) {
                    continue;
                }
                /*
                if(!$subscribercollection->isWanted($subscriberId,$queue->getId()))
                {
                	continue;
                }
             	*/
                $data = array();
                $data['queue_id'] = $queue->getId();
                $data['subscriber_id'] = $subscriberId;
                $this->_getWriteAdapter()->insert($this->getTable('queue_link'), $data);
            }
            $this->_getWriteAdapter()->commit();
        } 
        catch (Exception $e) {
            $this->_getWriteAdapter()->rollBack();
            Mage::log("extnewsletter(queue)::".$e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
        }
        
    }
    
 
}
