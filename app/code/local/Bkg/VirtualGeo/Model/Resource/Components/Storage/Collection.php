<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Resource_Components_Storage_entity_Collection
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Resource_Components_Storage_Collection extends Bkg_VirtualGeo_Model_Resource_Components_Component_Collection
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_storage');
    }
    
    public function getLabelTable()
    {
    	return $this->getTable('virtualgeo/components_storage_label');
    }
}
