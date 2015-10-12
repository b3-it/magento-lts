<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Model_Mysql4_Account_Collection
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Model_Mysql4_Account_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_icd/account');
    }
}