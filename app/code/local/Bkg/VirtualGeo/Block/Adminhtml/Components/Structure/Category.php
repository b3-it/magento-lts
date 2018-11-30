<?php
/**
 *
 * @category   	Bkg
 * @package    	Bkg_VirtualGeo
 * @name       	Bkg_VirtualGeo_Block_Adminhtml_Components_Structure_Category
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Block_Adminhtml_Components_Structure_Category extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
  	
    $this->_controller = 'adminhtml_components_structure_category';
    $this->_blockGroup = 'virtualgeo';
    $this->_headerText = Mage::helper('virtualgeo')->__('Structure Category Manager');
    $this->_addButtonLabel = Mage::helper('virtualgeo')->__('Add Item');
    parent::__construct();
  }
}
