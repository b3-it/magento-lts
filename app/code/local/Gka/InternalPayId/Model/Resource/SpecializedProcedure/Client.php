<?php
 /**
  *
  * @category   	Gka Internalpayid
  * @package    	Gka_InternalPayId
  * @name       	Gka_InternalPayId_Model_Resource_SpecializedProcedure_Client
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Gka_InternalPayId_Model_Resource_SpecializedProcedure_Client extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('internalpayid/specialized_procedure_client', 'id');
    }
}
