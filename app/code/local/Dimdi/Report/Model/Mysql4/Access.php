<?php
/**
 * Dimdi Report
 *
 *
 * @category   	Dimdi
 * @package    	Dimdi_Report
 * @name        Dimdi_Report_Model_Mysql4_Access
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Model_Mysql4_Access extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the dimdireport_access_id refers to the key field in your database table.
        $this->_init('dimdireport/access', 'dimdireport_access_id');
    }
}