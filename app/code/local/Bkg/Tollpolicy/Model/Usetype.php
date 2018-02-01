<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Model_Use_type_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Model_Usetype extends Bkg_Tollpolicy_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_tollpolicy/usetype');
    }

    public function getOptions() {
        /**
         * @var Bkg_Tollpolicy_Model_Resource_Usetype_Collection $col
         */
        $col = Mage::getModel('bkg_tollpolicy/useoptions')->getCollection();
        $col->getSelect()->where('use_type_id=?', $this->getId());
        
        $col->getSelect()->order('pos');
        return $col->getItems();
    }
}
