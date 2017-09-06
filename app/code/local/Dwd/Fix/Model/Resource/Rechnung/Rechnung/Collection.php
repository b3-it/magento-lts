<?php
/**
 *
 * @category   	Dwd Fix
 * @package    	Dwd_Fix
 * @name       	Dwd_Fix_Model_Resource_Rechnung_Rechnung_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Fix_Model_Resource_Rechnung_Rechnung_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('dwd_fix/rechnung_rechnung');
    }
}
