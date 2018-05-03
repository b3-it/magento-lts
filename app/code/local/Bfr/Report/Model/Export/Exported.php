<?php
/**
 *
 * @category   	Bfr Report
 * @package    	Bfr_Report
 * @name       	Bfr_Report_Model_Export_Exported
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Report_Model_Export_Exported extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bfr_report/export_exported');
    }
    
    public function saveHistory($incoming_payment_ids, $user)
    {
    	if(empty($incoming_payment_ids)){
    		return $this;
    	}
    	$this->getResource()->saveHistory($incoming_payment_ids, $user);
    }
}
