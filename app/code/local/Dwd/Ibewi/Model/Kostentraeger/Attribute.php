<?php
/**
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name       	Dwd_Ibewi_Model_Kostentraeger_Attribute
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Model_Kostentraeger_Attribute extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('ibewi/kostentraeger_attribute');
    }
    
    public function removeStandard4All()
    {
    	$this->getResource()->removeStandard4All();
    	return $this;
    }
    public function isUsedByProduct()
    {
    	return $this->getResource()->isUsedByProduct($this);
    }
    
    protected function _afterSave()
    {
    	$this->getResource()->updateProducts($this);
    	
    	return parent::_afterSave();
    }
}
