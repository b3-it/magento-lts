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
   * @param Varien_Event_Observer $observer Observer
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
    		$collection = $observer->getSubscriberCollection();
    		
    		$storeViews = $this->getUserStoreViews();
    		$storeViews = implode(',', $storeViews);
    		$storeGroups = implode(',', $storeGroups);
    		$sql = '((main_table.store_id IN ('.$storeViews.')) ) ';
    		$sql .= 'or (main_table.subscriber_id in (Select distinct subscriber_id from '.$collection->getTable('extnewsletter/extnewsletter_subscriber').' AS esub';
    		$sql .= ' join (Select product_id FROM '.$collection->getTable('sales/order_item').' WHERE store_group in ('.$storeGroups.') group by product_id) AS p ON esub.product_id = p.product_id)) ';
    		//thema hinzu
    		$sql .= 'or (main_table.subscriber_id in (SELECT subscriber_id FROM '. $collection->getTable('extnewsletter/issuesubscriber') . ' AS es JOIN '.$collection->getTable('extnewsletter/issue').' AS issue ';
    		$sql .= 'ON issue.extnewsletter_issue_id = es.issue_id WHERE  issue.store_id IN('.$storeViews.') group by es.subscriber_id))';
    		
    		$exp = new Zend_Db_Expr($sql);
    		
    		
    		
    		$collection->getSelect()
    		//->joinleft(array('ei'=>$collection->getTable('extnewsletter/issuesubscriber')),'ei.subscriber_id = main_table.subscriber_id',array())
    		//->joinleft(array('issue'=>$collection->getTable('extnewsletter/issue')),'issue.extnewsletter_issue_id = ei.issue_id',array())
    		//->joinleft(array('esub'=>$collection->getTable('extnewsletter/extnewsletter_subscriber')),'esub.subscriber_id = main_table.subscriber_id',array())
    		->distinct()
    		->where($exp)
    		;
    		
  		
//     		$s = $collection->getSelect()->__toString();
//     		die($s);
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