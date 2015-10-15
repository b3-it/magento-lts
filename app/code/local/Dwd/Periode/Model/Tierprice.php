<?php
/**
 * Dwd Periode
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Periode
 * @name       	Dwd_Periode_Model_Tierprice
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Periode_Model_Tierprice extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('periode/tierprice');
    }
}