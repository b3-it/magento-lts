<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Relation
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Relation extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('isolation/relation');
    }
    
    
    
 	public function removeAllStoreRelations($user_id)
    {
    	$this->getResource()->removeAllStoreRelations($user_id);
    	return $this;
    }
    
}