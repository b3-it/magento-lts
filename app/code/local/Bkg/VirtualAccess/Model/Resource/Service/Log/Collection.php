<?php
/**
 *
 * @category   	Bkg Virtualaccess
 * @package    	Bkg_Virtualaccess
 * @name       	Bkg_Virtualaccess_Model_Resource_Service_Log_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Resource_Service_Log_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualaccess/service_log');
    }
}
