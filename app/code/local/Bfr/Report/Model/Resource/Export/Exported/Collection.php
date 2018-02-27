<?php
/**
 *
 * @category   	Bfr Report
 * @package    	Bfr_Report
 * @name       	Bfr_Report_Model_Resource_Export_Exported_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Report_Model_Resource_Export_Exported_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bfr_report/export_exported');
    }
}
