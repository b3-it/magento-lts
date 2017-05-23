<?php
/**
 *
 * @category   	Bkg Viewer
 * @package    	Bkg_Viewer
 * @name       	Bkg_Viewer_Block_ServiceService
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Viewer_Block_Adminhtml_Service_Vggroup extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_service_vggroup';
    $this->_blockGroup = 'bkgviewer';
    $this->_headerText = Mage::helper('bkgviewer')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('bkgviewer')->__('Add Item');
    parent::__construct();
  }
}
