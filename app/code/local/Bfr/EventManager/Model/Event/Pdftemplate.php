<?php
/**
 *
 * @category   	Bfr Eventmanager
 * @package    	Bfr_Eventmanager
 * @name       	Bfr_Eventmanager_Model_Event_Pdftemplate
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventmanager_Model_Event_Pdftemplate extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('eventmanager/event_pdftemplate');
    }
}
