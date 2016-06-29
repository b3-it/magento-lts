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
 * Newsletter Subscribers Collection
 *
 * @category   Mage
 * @package    Mage_Newsletter
 * @author      Magento Core Team <core@magentocommerce.com>
 * @todo       Refactoring this collection to Mage_Core_Model_Mysql4_Collection_Abstract.
 */

class Egovs_Extnewsletter_Model_Mysql4_Subscriber_Collection extends Mage_Newsletter_Model_Mysql4_Subscriber_Collection
{
    /**
     * Auswaehlen der Subscriber fuer Queue 
     */
    public function useOnlySubscribed()
    {
    	$products = Mage::app()->getRequest()->getPost('news_for_products');
    	$issues = Mage::app()->getRequest()->getPost('news_for_issues');
	
    	$this->_select
    		->distinct()
        	->where("main_table.subscriber_status = ?", Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);
    	
    	//wenn issue und produkt NULL dann allgemeiner Newsletter  	  	
    	if(($products == null) && ($issues == null))
    	{
    		$this->_select
    			->JoinInner(array('ext'=>'extnewsletter_subscriber'),'ext.subscriber_id=main_table.subscriber_id',array())
        		->where('(ext.product_id = 0 AND ext.is_active=1)');
        	return $this;
     	}
		
     	//wenn Produktnewsletter
    	if(($products != null) && ($issues == null))
    	{
    		$this->_select
    			->JoinInner(array('ext'=>'extnewsletter_subscriber'),'ext.subscriber_id=main_table.subscriber_id',array())
        		->where('(ext.product_id in (?) AND ext.is_active=1)',$products);
        	return $this;
     	}
     	
        //wenn Themennewsletter
    	if(($products == null) && ($issues != null))
    	{
    		$removeFromIssue = new Zend_Db_Expr("(select min(remove_subscriber_after_send) as remove_after_send, extnewsletter_issues_subscriber.*  from extnewsletter_issues_subscriber
				join extnewsletter_issue as issue on issue.extnewsletter_issue_id = extnewsletter_issues_subscriber.issue_id
				group by extnewsletter_issues_subscriber.issue_id having is_active = 1)");
    		$this->_select
    			->JoinInner(array('ext'=>'extnewsletter_issues_subscriber'),'ext.subscriber_id=main_table.subscriber_id',array())
    			//->JoinInner(array('ext'=>$removeFromIssue),'ext.subscriber_id=main_table.subscriber_id',array('remove_after_send'))
        		->where('(ext.issue_id in (?) AND ext.is_active=1)',$issues);
        		//->where('(ext.issue_id in (?))',$issues);
        		
        		//echo "<pre>"; var_dump($this->_select->__toString()); die();
        	return $this;
     	}
     	
        //wenn Themen und Produkt Newsletter 
    	if(($products != null) && ($issues != null))
    	{
    		/*
    		$sql1 = clone($this->_select);
    		
    		$sql1->JoinInner(array('ext'=>'extnewsletter_issues_subscriber'),'ext.subscriber_id=main_table.subscriber_id',array())
        		->where('(ext.issue_id in (?) AND is_active=1)',$issues);
        	
        	$sql2 = clone($this->_select);
        	$sql2->JoinInner(array('ext'=>'extnewsletter_subscriber'),'ext.subscriber_id=main_table.subscriber_id',array())
        		->where('(ext.product_id in (?) AND is_active=1)',$products);

        	$this->_select->reset(Zend_Db_Select::FROM);
        	$this->_select->reset(Zend_Db_Select::WHERE);
        	$this->_select->reset(Zend_Db_Select::COLUMNS);
        	$this->_select->union(array($sql1,$sql2));
        	*/
    		
    		$products = implode(',', $products);
    		$issues = implode(',',$issues);
    		$exp = new  Zend_Db_Expr("SELECT DISTINCT subscriber_id from `extnewsletter_issues_subscriber` AS `exti` 
							WHERE  (exti.issue_id in ('".$issues."') AND exti.is_active=1) 
							UNION 
							SELECT DISTINCT subscriber_id FROM `extnewsletter_subscriber` AS `ext`
							WHERE  ((ext.product_id in ('".$products."') AND ext.is_active=1))");
    		
    		$this->_select
    		->where("main_table.subscriber_id in ($exp)");
    		
//die($this->_select->__toString());			        		
        	return $this;
     	}
     	
     	
        //die($this->_select->__toString());
		
        return $this;
    }


}