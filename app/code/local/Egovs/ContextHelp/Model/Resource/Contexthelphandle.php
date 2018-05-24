<?php
 /**
  *
  * @category   	Egovs ContextHelp
  * @package    	Egovs_ContextHelp
  * @name       	Egovs_ContextHelp_Model_Resource_Contexthelphandle
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Egovs_ContextHelp_Model_Resource_Contexthelphandle extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('contexthelp/contexthelp_handle', 'id');
    }
}
