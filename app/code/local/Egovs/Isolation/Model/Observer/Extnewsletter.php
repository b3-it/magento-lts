<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Observer_Extnewsletter
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Observer_Extnewsletter extends Egovs_Isolation_Model_Observer_Abstract
{
   
  /**
   * der Filter für die Newsletterthemen
   * Enter description here ...
   * @param unknown $observer
   */
    public function onStoreBlockLoad($observer)
    {
    	$values = $observer->getStores()->getValues();
    	$res = array();
    	$storeGroups = $this->getUserStoreViews();
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		foreach ($values as $value)
    		{
    			if(in_array($value['value'], $storeGroups))
    			{
    				$res[]= $value;
    			}
    		}
    		$observer->getStores()->setValues($res);
    	}
    	
    }
  
    
    public function onIssueCollectionLoad($observer)
    {
    	$storeGroups = $this->getUserStoreViews();
    	if(($storeGroups) && (count($storeGroups) > 0))
    	{
    		$storeGroups = implode(',', $storeGroups);
    		$collection = $observer->getExtnewsletterIssueCollection();
    		$collection->getSelect()->where('store_id IN ('.$storeGroups.')');
    		$s = $collection->getSelect()->__toString();
    		//die($s);
    		;
    	}
    	 
    }
    
    
    public function onIssueLoad($observer)
    {
    	$product = $observer->getExtnewsletterIssue();
    	$storeGroups = $this->getUserStoreViews();
    	$storeGroup = $product->getStoreId();
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
    
    public function onSubscriberCollectionLoad($observer)
    {
    	$storeGroups = $this->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0))
    	{
    		$storeViews = $this->getUserStoreViews();
    		$storeViews = implode(',', $storeViews);
    		$storeGroups = implode(',', $storeGroups);
    		$sql = '((main_table.store_id IN ('.$storeViews.')) or (issue.store_id in ('.$storeViews.'))) ';
    		$sql .= 'or (esub.product_id in (Select product_id from sales_flat_order_item where store_group in ('.$storeGroups.') group by product_id))';
    		$exp = new Zend_Db_Expr($sql);
    		
    		
    		$collection = $observer->getSubscriberCollection();
    		$collection->getSelect()
    		->joinleft(array('ei'=>$collection->getTable('extnewsletter/issuesubscriber')),'ei.subscriber_id = main_table.subscriber_id',array())
    		->joinleft(array('issue'=>$collection->getTable('extnewsletter/issue')),'issue.extnewsletter_issue_id = ei.issue_id',array())
    		->joinleft(array('esub'=>$collection->getTable('extnewsletter/extnewsletter_subscriber')),'esub.subscriber_id = main_table.subscriber_id',array())
    		->distinct()
    		->where($exp)
    		;
    		
  		
    		//$s = $collection->getSelect()->__toString();
    		//die($s);
    		;
    	}
    
    }
    
    public function onQueueCollectionLoad($observer)
    {
    	$storeGroups = $this->getUserStoreGroups();
    	if(($storeGroups) && (count($storeGroups) > 0))
    	{
    		$storeGroups = implode(',', $storeGroups);
    		/* @var $collection Egovs_Extnewsletter_Model_Mage_Queuecollection*/
    		$collection = $observer->getCollection();
    		if(!$collection->hasJoinToTable('template'))
    		{
    			$collection->getSelect()
    			->join(array('template'=>$collection->getTable('newsletter/template')),'template.template_id=main_table.template_id ');
    		}
    		$collection->getSelect()
    			->where('store_group IN ('.$storeGroups.')');
    		$s = $collection->getSelect()->__toString();
    		//die($s);
    		;
    	}
    
    }
    
}