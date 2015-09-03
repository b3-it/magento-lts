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
class Dwd_Icd_Model_Account_Groups extends Mage_Core_Model_Abstract
{
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_icd/account_groups');
    }
    
    
  
    public static function modifyGroup($account,$group,$increment)
    {
    	$model = Mage::getModel('dwd_icd/account_groups');
    	$model->getResource()->loadByAccountId_Application($model,$account->getId(),$group);
    	$model->setCount($model->getCount() + $increment);
    	$model->save();
    	return $model;
    }
   
    public static function getGroup($account,$group)
    {
    	$model = Mage::getModel('dwd_icd/account_groups');
    	$model->getResource()->loadByAccountId_Application($model,$account->getId(),$group);
    	return $model;
    }
    
}