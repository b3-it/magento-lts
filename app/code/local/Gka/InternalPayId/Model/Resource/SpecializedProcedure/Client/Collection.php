<?php
/**
 *
 * @category   	Gka Internalpayid
 * @package    	Gka_InternalPayId
 * @name       	Gka_InternalPayId_Model_Resource_SpecializedProcedure_Client_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_InternalPayId_Model_Resource_SpecializedProcedure_Client_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('internalpayid/specializedProcedure_client');
    }
}
