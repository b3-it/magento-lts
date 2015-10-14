<?php
/**
 * Dwd Icd
 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Account
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Account_Attributes extends Mage_Core_Model_Abstract
{
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_icd/account_attributes');
    }
    
    
  
    public static function getAttribute($account,$attribute)
    {
    	$model = Mage::getModel('dwd_icd/account_attributes');
    	$model->getResource()->loadByAccountId_Attribute($model,$account->getId(),$attribute);
    	return $model;
    }
    
    
}