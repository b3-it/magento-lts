<?php
/**
 * Sid Haushalt
 *
 *
 * @category   	Sid
 * @package    	Sid_Haushalt
 * @name       	Sid_Haushalt_Model_Lg04Pool
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Haushalt_Model_Lg04Pool extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('sidhaushalt/lg04pool');
    }
    
    
    public function getNextIncrementId($startValue, $stopValue)
    {
    	$last = $this->getResource()->getLast(new Varien_Object());
    	
    	$lg_04_increment_id = intval($startValue);
    	if($last->getData('lg_04_increment_id') != null){
    		$lg_04_increment_id = intval($last->getData('lg_04_increment_id'));
    	}
    	$lg_04_increment_id++;
    	$this->setData('lg_04_increment_id', $lg_04_increment_id)->save();
    	
    	if($lg_04_increment_id > $stopValue - 500){
    		Mage::log("Der Nummernkreis für das Haushaltsystem Agresso BW ist fast ausgeschöpft. Verbleibend: ". intval($stopValue - $lg_04_increment_id), Zend_Log::ALERT, Egovs_Helper::LOG_FILE);
    	}
    	
    	return $lg_04_increment_id;
    }
}
