<?php
 /**
  *
  * @category   	Bkg VirtualGeo
  * @package    	Bkg_VirtualGeo
  * @name       	Bkg_VirtualGeo_Model_Resource_Components_Resolutionentity
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bkg_VirtualGeo_Model_Resource_Components_Resolutionproduct extends Bkg_VirtualGeo_Model_Resource_Components_Componentproduct
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('virtualgeo/components_resolution_product', 'id');
    }
    
 

 
}
