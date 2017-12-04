<?php
/**
 *
 * @category   	Bkg Virtualgeo
 * @package    	Bkg_Virtualgeo
 * @name       	Bkg_Virtualgeo_Block_Adminhtml_Components_Storage
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Virtualgeo_Block_Adminhtml_Components_Storage extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_components_storage';
    $this->_blockGroup = 'virtualgeo';
    $this->_headerText = Mage::helper('virtualgeo')->__('Components Storage Manager');
    $this->_addButtonLabel = Mage::helper('virtualgeo')->__('Add Item');
    parent::__construct();
  }
}
