<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Resource_Components_Componentproduct_Collection
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Resource_Components_Accountingproduct_Collection extends Bkg_VirtualGeo_Model_Resource_Components_Componentproduct_Collection
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_accountingproduct');
    }
}
