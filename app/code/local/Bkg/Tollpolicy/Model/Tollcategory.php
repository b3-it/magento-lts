<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Model_Toll_category
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Model_Tollcategory extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_tollpolicy/tollcategory');
    }

    public function getActiveTolls() {
        /**
         * @var Bkg_Tollpolicy_Model_Resource_Toll_Collection $col
         */
        $col = Mage::getModel('bkg_tollpolicy/toll')->getCollection();
        $col->getSelect()->where('toll_category_id=?', intval($this->getId()));
        $col->getSelect()->where('active=?', 1);
        return $col->getItems();
    }
}
