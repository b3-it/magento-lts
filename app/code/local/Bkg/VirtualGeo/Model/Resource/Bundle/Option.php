<?php
/**
 * Created by PhpStorm.
 * User: f.rochlitzer
 * Date: 06.04.2018
 * Time: 11:06
 */

class Bkg_VirtualGeo_Model_Resource_Bundle_Option extends Mage_Bundle_Model_Resource_Option
{
    /**
     * Initialize connection and define resource
     *
     */
    protected function _construct()
    {
        $this->_init('virtualgeo/bundle_option', 'option_id');
    }

    /**
     * After save process
     *
     * @param Mage_Core_Model_Abstract $object
     * @return Mage_Bundle_Model_Resource_Option
     */
    protected function _afterSave(Mage_Core_Model_Abstract $object)
    {
        Mage_Core_Model_Resource_Db_Abstract::_afterSave($object);

        return $this;
    }
}