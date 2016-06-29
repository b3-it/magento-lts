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
class Egovs_Isolation_Model_Observer_Extstock extends Egovs_Isolation_Model_Observer_Abstract
{
   
    public function onExtstockListCollectionLoad($observer)
    {
    	$storeGroups = Mage::helper('isolation')->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		$storeGroups = implode(',', $storeGroups);
	    	$collection = $observer->getExtstockListCollection();
    	
	    	$collection->getSelect()
	    		->join(array('product'=>$collection->getTable('catalog/product')),"product.entity_id=t.product_id AND product.store_group IN (".$storeGroups.")",array());
	    	
	    	
	    	//die($collection->getSelect()->__toString());
	    ;
    	}
    	
    }
    
    public function onOverviewFetchBefore($observer)
    {
    	$storeGroups = Mage::helper('isolation')->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0))
    	{
    		$storeGroups = implode(',', $storeGroups);
    		
    		$collection = Mage::getModel('extstock/extstock')->getCollection();
    		$exp = new Zend_Db_Expr('( SELECT entity_id FROM '.$collection->getTable('catalog/product') ."  WHERE store_group IN (".$storeGroups.") group by entity_id)" );
    		$observer->getSelect()->where('product_id IN('.$exp.')');
    
    
    		//die($observer->getSelect()->__toString());
    		;
    	}
    	 
    }
    
    
    public function onExtstockCollectionLoad($observer)
    {
        $storeGroups = Mage::helper('isolation')->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		$storeGroups = implode(',', $storeGroups);
	    	$collection = $observer->getExtstockCollection();
    	
	    	$collection->getSelect()
	    		->join(array('product'=>$collection->getTable('catalog/product')),"product.entity_id=main_table.product_id AND product.store_group IN (".$storeGroups.")",array());
	    	
	    	
	    	//die($collection->getSelect()->__toString());
	    ;
    	}
    	
    }
    
  
  
}