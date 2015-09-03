<?php
/**
 * Dwd Abo
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Model_
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Model_ extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('abo/');
    }
}