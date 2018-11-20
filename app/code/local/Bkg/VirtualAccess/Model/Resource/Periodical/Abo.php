<?php
 /**
  *
  * @category   	Bkg Virtualaccess
  * @package    	Bkg_Virtualaccess
  * @name       	Bkg_Virtualaccess_Model_Resource_Periodical_Abo
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Virtualaccess_Model_Resource_Periodical_Abo extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('bkg_virtualaccess/periodical_abo', 'id');
    }
}
