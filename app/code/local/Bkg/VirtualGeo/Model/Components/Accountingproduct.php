<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Components_Accountingproduct
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Components_Accountingproduct extends Bkg_VirtualGeo_Model_Components_Componentproduct
{
    protected $_eventPrefix = 'virtualgeo_components_accountingproduct';

    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_accountingproduct');
        $this->setComponentType();
    }

    /**
     * Setzt den Type
     *
     * Type darf nur von Klasse selbst gesetzt werden
     */
    protected function setComponentType() {
        $this->setData('component_type', self::COMPONENT_TYPE_ACCOUNTING);
    }
}
