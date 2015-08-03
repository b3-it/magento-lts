<?php

class Egovs_Extnewsletter_Model_Resource_Queue extends Mage_Newsletter_Model_Resource_Queue
{
   

  


    /**
     * Links queue to store
     *
     * @param Mage_Newsletter_Model_Queue $queue
     * @return Mage_Newsletter_Model_Resource_Queue
     */
    public function setStores(Mage_Newsletter_Model_Queue $queue)
    {
        $adapter = $this->_getWriteAdapter();
        $adapter->delete(
            $this->getTable('newsletter/queue_store_link'),
            array('queue_id = ?' => $queue->getId())
        );

        $stores = $queue->getStores();
        if (!is_array($stores)) {
            $stores = array();
        }

        foreach ($stores as $storeId) {
            $data = array();
            $data['store_id'] = $storeId;
            $data['queue_id'] = $queue->getId();
            $adapter->insert($this->getTable('newsletter/queue_store_link'), $data);
        }
        $this->removeSubscribersFromQueue($queue);

        if (count($stores) == 0) {
        	$subscribers = Mage::getResourceSingleton('newsletter/subscriber_collection')
        	//->addFieldToFilter('store_id', array('in'=>$stores))
        	->useOnlySubscribed()
        	->load();
        }
		else {
			$subscribers = Mage::getResourceSingleton('newsletter/subscriber_collection')
			->addFieldToFilter('store_id', array('in'=>$stores))
			->useOnlySubscribed()
			->load();
		}
        

        $subscriberIds = array();

        foreach ($subscribers as $subscriber) {
            $subscriberIds[] = $subscriber->getId();
        }

        if (count($subscriberIds) > 0) {
            $this->addSubscribersToQueue($queue, $subscriberIds);
        }

        return $this;
    }

    /**
     * Returns queue linked stores
     *
     * @param Mage_Newsletter_Model_Queue $queue
     * @return array
     */
    public function getStores(Mage_Newsletter_Model_Queue $queue)
    {
        $adapter = $this->_getReadAdapter();
        $select = $adapter->select()->from($this->getTable('newsletter/queue_store_link'), 'store_id')
            ->where('queue_id = :queue_id');

        if (!($result = $adapter->fetchCol($select, array('queue_id'=>$queue->getId())))) {
            $result = array();
        }

        return $result;
    }

    /**
     * Saving template after saving queue action
     *
     * @param Mage_Core_Model_Abstract $queue
     * @return Mage_Newsletter_Model_Resource_Queue
     */
    protected function _afterSave(Mage_Core_Model_Abstract $queue)
    {
        if ($queue->getSaveStoresFlag()) {
            $this->setStores($queue);
        }
        return $this;
    }
}
