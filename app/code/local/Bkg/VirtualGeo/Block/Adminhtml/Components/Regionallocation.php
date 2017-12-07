<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_ComponentsRegionallocation
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Regionallocation extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_components_regionallocation';
    $this->_blockGroup = 'bkg_virtualGeo';
    $this->_headerText = Mage::helper('bkg_virtualGeo')->__('Components Regionallocation Manager');
    $this->_addButtonLabel = Mage::helper('bkg_virtualGeo')->__('Add Item');
    parent::__construct();
  }
}
