<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Block_CopyEntity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_copy';
    $this->_blockGroup = 'bkg_license';
    $this->_headerText = Mage::helper('bkg_license')->__('License Copy Manager');
    $this->_addButtonLabel = Mage::helper('bkg_license')->__('Add Item');
    parent::__construct();
  }
}
