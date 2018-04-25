<?php
/**
 * B3it Subscription
 * 
 * 
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Cron
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Model_Cron extends Mage_Core_Model_Abstract
{
 
    public static function collect()
    {
    	$model = Mage::getModel('b3it_subscription/subscription');
    	$model->renewOrders();
    }
    
    
    
    
  
    		
    
}