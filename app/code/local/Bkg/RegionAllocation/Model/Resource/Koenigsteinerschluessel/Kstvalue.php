<?php
 /**
  *
  * @category   	Bkg Regionallocation
  * @package    	Bkg_Regionallocation
  * @name       	Bkg_Regionallocation_Model_Resource_Koenigsteinerschluessel_Kstvalue
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_RegionAllocation_Model_Resource_Koenigsteinerschluessel_Kstvalue extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('regionallocation/koenigsteinerschluessel_kst_value', 'id');
    }
}
