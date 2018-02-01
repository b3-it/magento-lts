<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Model_Toll_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Model_Toll extends Bkg_Tollpolicy_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_tollpolicy/toll');
    }

    /**
     * 
     * @param boolean $internal
     * @return array
     */
    public function getActiveUseTypes($internal ) {
        /**
         * @var Bkg_Tollpolicy_Model_Resource_Usetype_Collection $col
         */
        $col = Mage::getModel('bkg_tollpolicy/usetype')->getCollection();
        $col->getSelect()->where('toll_id=?', $this->getId())->where('active=?', 1)->order('pos');
        if ($internal) {
            $col->getSelect()->where("internal = ?", 1);
        } else {
            $col->getSelect()->where("internal = ?", 0);
            $col->getSelect()->where("external = ?", 1); // TODO remove if external got removed
        }

        return $col->getItems();
    }
}
