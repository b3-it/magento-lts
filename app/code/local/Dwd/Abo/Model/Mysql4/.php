<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Model_Mysql4_
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Model_Mysql4_ extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the abo__id refers to the key field in your database table.
        $this->_init('abo/', 'abo__id');
    }
}