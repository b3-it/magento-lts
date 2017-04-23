<?php
 /**
  *
  * @category   	Dwd Fix
  * @package    	Dwd_Fix
  * @name       	Dwd_Fix_Model_Resource_Rechnung_Rechnung
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Dwd_Fix_Model_Resource_Rechnung_Rechnung extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('dwd_fix/rechnung_rechnung', 'id');
    }
}
