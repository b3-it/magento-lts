<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_Adminhtml_ extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_';
    $this->_blockGroup = 'bkg_orgUnit';
    $this->_headerText = Mage::helper('bkg_orgUnit')->__(' Manager');
    $this->_addButtonLabel = Mage::helper('bkg_orgUnit')->__('Add Item');
    parent::__construct();
  }
}
