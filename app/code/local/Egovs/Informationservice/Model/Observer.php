<?php

/**
 * Oberserver
 * 
 * @category   	Egovs
 * @package    	Egovs_Informationservice
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 *
 */
class Egovs_Informationservice_Model_Observer extends Mage_Core_Model_Abstract {
	/**
	 * Before delete admin user
	 *  
	 * @param Varien_Event_Observer $observer
	 */
	public function beforeDeleteAdminUser($observer) {
		$adminUser = $observer->getObject();
		
		if (!$adminUser || !($adminUser instanceof Mage_Admin_Model_User))
			return $this;
		
		/* @var $collection Egovs_Informationservice_Model_Mysql4_Request_Collection */
		$collection = Mage::getModel('informationservice/request')->getCollection();
		
		if (!$collection)
			return $this;
		
		$collection->addFieldToFilter('owner_id', array('eq' => (int) $adminUser->getId()));
		Mage::log(sprintf("adminUserBeforeDelete::SQL:\n%s", $collection->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		$helper = Mage::helper('informationservice');
		if ($collection->count() > 0) {
			Mage::throwException($helper->__('User is still bound to information service.')); 
		}
		
		/* @var $collection Egovs_Informationservice_Model_Mysql4_Task_Collection */		
		$collection = Mage::getResourceModel('informationservice/task_collection');
		
		if (!$collection)
			return $this;
		
		//Filter with OR
		/*
		$collection->addFieldToFilter(
			array(
				'owner' => 'owner_id',
				'user'	=> 'user_id'				
			),
			array(
				'owner' => array('eq' => (int) $adminUser->getId()),
				'user' => array('eq' => (int) $adminUser->getId())
			)
		);
		*/
		$collection->getSelect()
			->where('owner_id='.(int) $adminUser->getId())
			->orWhere('user_id='.(int) $adminUser->getId());
		
		Mage::log(sprintf("adminUserBeforeDelete::SQL:\n%s", $collection->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		if ($collection->count() > 0) {
			Mage::throwException($helper->__('User is still bound to information service.'));
		}
		
		return $this;
		
	}
}