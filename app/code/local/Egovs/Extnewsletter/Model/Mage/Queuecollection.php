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
 * Newsletter queue collection.
 *
 * @category   Mage
 * @package    Mage_Newsletter
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Egovs_Extnewsletter_Model_Mage_Queuecollection extends Mage_Newsletter_Model_Mysql4_Queue_Collection
{


    /**
     * Add filter by only ready fot sending item
     *
     * @return Mage_Newsletter_Model_Mysql4_Queue_Collection
     */
    public function addOnlyForSendingFilter()
    {
    	$this->getSelect()
    		->where('main_table.queue_status in (?)', array(Mage_Newsletter_Model_Queue::STATUS_SENDING,
    														Mage_Newsletter_Model_Queue::STATUS_NEVER))
    		->where('main_table.queue_start_at < ?', Mage::getSingleton('core/date')->gmtdate())
    		->where('main_table.queue_start_at IS NOT NULL');
    		
    		
	    // es sollen nur diejenigen abgerufen werden die auch Empfaenger haben, sonst gibt es einen Stau
	    $st = new Zend_Db_Expr('(select count(queue_id) as total ,queue_id from '.$this->getTable('queue_link').' group by queue_id)');	
	    $this->getSelect()->join(array('link'=>$st),'link.queue_id=main_table.queue_id')->where('link.queue_id=main_table.queue_id');		
	    		
	    //die($this->getSelect()->__toString());
	    return $this;
    }

 
}
