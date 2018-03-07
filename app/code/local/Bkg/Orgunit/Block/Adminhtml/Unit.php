<?php
/**
 *
 * @category   	Bkg Orgunit
 * @package    	Bkg_Orgunit
 * @name       	Bkg_Orgunit_Block_Unit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Orgunit_Block_Adminhtml_Unit extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_unit';
    $this->_blockGroup = 'bkg_orgunit';
    $this->_headerText = Mage::helper('bkg_orgunit')->__('Organisation');
    $this->_addButtonLabel = Mage::helper('bkg_orgunit')->__('Add Item');
    parent::__construct();
  }
}
