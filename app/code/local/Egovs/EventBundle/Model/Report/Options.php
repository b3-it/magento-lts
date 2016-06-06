<?php
/**
 *
 * Product Options reports Model
 *
 * @category   TuFreiberg
 * @package    TUFreiberg_TufReports
 */
class Egovs_EventBundle_Model_Report_Options extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventbundle/report_options');
    } 

}