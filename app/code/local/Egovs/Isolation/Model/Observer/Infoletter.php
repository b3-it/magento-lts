<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Observer_Infoletter
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Observer_Infoletter extends Egovs_Isolation_Model_Observer_Abstract
{
   
 
    
    public function onInfoletterCollectionLoad($observer)
    {
    	$storeGroups = $this->getUserStoreViews();
    	if(($storeGroups) && (count($storeGroups) > 0))
    	{
    		$storeGroups[] = 0;
    		$storeGroups = implode(',', $storeGroups);
    		$collection = $observer->getCollection();
    		$collection->getSelect()->where('store_id IN ('.$storeGroups.')');
    		$s = $collection->getSelect()->__toString();
    		//die($s);
    		;
    	}
    	 
    }
    
    
    public function onInfoletterLoad($observer)
    {
    	$queue = $observer->getObject();
    	$storeGroups = $this->getUserStoreViews();
    	$storeGroup = $queue->getStoreId();
    	if ($storeGroup == 0){
    		return;
    	}
    	if(($storeGroup) &&($storeGroups) && (count($storeGroups) > 0))
    	{
    		foreach ($storeGroups as $st)
    		{
    			if($st == $storeGroup)
    			{
    				return;
    			}
    		}
    		$this->denied();
    	}
    	 
    }
    

    
}