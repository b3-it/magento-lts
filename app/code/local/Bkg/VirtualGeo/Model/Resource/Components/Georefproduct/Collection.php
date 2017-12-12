<?php
/**
 *
 * @category   	Bkg Virtualgeo
 * @package    	Bkg_Virtualgeo
 * @name       	Bkg_Virtualgeo_Model_Resource_Components_Georef_entity_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Virtualgeo_Model_Resource_Components_Georefproduct_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	
	
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_georefproduct');
    }
    
   
    
  
}
