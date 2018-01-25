<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Relation
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Observer_User extends Varien_Object
{
    public function onUserSave($observer)
    {
    	$user = $observer->getObject();
    	if(($user != null) && ($user instanceof Mage_Admin_Model_User))
    	{
    		$stores = $user->getStoreGroups();
    		Mage::getModel('isolation/relation')->removeAllStoreRelations($user->getId());
    		if(is_array($stores))
    		{
    			foreach($stores as $store)
    			{
	    			$store_relation = Mage::getModel('isolation/relation');
	    			$store_relation->setUserId($user->getId());
	    			$store_relation->setStoreGroupId($store);
	    			$store_relation->save();
    			}
    		}
    	}
    }
    
    
    public function onUserLoad($observer)
    {
    	$user = $observer->getObject();
    	if(($user != null) && ($user instanceof Mage_Admin_Model_User) && $user->getId())
    	{
    		$collection = Mage::getModel('isolation/relation')->getCollection();
    		$collection->getSelect()->where('user_id = ' . $user->getId());
    		//echo($collection->getSelect()->__toString()). "<br>";
    		$stores = array();
    		foreach($collection->getItems() as $item)
    		{
    			$stores[] = $item->getStoreGroupId();
    		}
    		$user->setStoreGroups($stores);
    	}
    }
    
   
    
    
}