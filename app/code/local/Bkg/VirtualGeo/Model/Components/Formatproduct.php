<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Model_Components_Formatproduct
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Components_Formatproduct extends Bkg_VirtualGeo_Model_Components_Componentproduct
{
    protected $_eventPrefix = 'virtualgeo_components_formatproduct';

    public function _construct()
    {
        parent::_construct();
        $this->_init('virtualgeo/components_formatproduct');
        $this->setComponentType();
    }

    /**
     * Setzt den Type
     *
     * Type darf nur von Klasse selbst gesetzt werden
     */
    protected function setComponentType() {
        $this->setData('component_type', self::COMPONENT_TYPE_FORMAT);
    }

    /**
     * TODO : gehört in Parent
     * @return mixed
     */
    public function getComponentType() {
        return $this->getData('component_type');
    }
}
