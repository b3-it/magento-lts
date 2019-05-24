<?php
 /**
  *
  * @category   	Bfr Eventmanager
  * @package    	Bfr_Eventmanager
  * @name       	Bfr_Eventmanager_Model_Resource_Pdftemplate
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bfr_EventManager_Model_Resource_Event_Pdftemplate extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('eventmanager/event_pdftemplate', 'id');
    }
}
