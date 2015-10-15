<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Model_Cron
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Model_Cron extends Mage_Core_Model_Abstract
{
 
    public static function collect()
    {
    	$model = Mage::getModel('dwd_abo/abo');
    	$model->collectNewOrders();
    	$model->renewOrders();
    }
    
    
    
    
  
    		
    
}