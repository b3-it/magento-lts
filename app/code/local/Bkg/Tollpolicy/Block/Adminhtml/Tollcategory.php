<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Block_Tollcategory
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Block_Adminhtml_Tollcategory extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_tollcategory';
    $this->_blockGroup = 'bkg_tollpolicy';
    $this->_headerText = Mage::helper('bkg_tollpolicy')->__('Toll Category Manager');
    $this->_addButtonLabel = Mage::helper('bkg_tollpolicy')->__('Add Item');
    parent::__construct();
  }
}
