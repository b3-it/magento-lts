<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_ComponentsGeorefentity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Georef extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_components_georef';
    $this->_blockGroup = 'virtualgeo';
    $this->_headerText = Mage::helper('virtualgeo')->__('Components Georef Manager');
    $this->_addButtonLabel = Mage::helper('virtualgeo')->__('Add Item');
    parent::__construct();
  }
}
