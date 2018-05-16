<?php
 /**
  *
  * @category   	Bkg
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo_Model_Resource_Components_Accountingproduct
  * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
  * @copyright  	Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_VirtualGeo_Model_Resource_Components_Accountingproduct extends Bkg_VirtualGeo_Model_Resource_Components_Componentproduct
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('virtualgeo/product_option_value', 'id');
    }
}
