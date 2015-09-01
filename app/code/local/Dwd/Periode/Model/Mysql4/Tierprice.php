<?php
/**
 * Dwd Periode
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Periode
 * @name       	Dwd_Periode_Model_Mysql4_Tierprice
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Periode_Model_Mysql4_Tierprice extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the periode_tierprice_id refers to the key field in your database table.
        $this->_init('periode/tier_price', 'periode_tierprice_id');
    }
    
    
    public function xx_afterSave($object)
    {
    	//if($object)
    }
}