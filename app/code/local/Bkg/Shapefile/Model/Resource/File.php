<?php
 /**
  *
  * @category   	Bkg Shapefile
  * @package    	Bkg_Shapefile
  * @name       	Bkg_Shapefile_Model_Resource_Shapefile
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_Shapefile_Model_Resource_File extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('bkg_shapefile/file', 'id');
    }
}
