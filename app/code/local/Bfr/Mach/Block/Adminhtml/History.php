<?php
/**
 * Bfr Mach
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Block_Adminhtml_History
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Block_Adminhtml_History extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_history';
    $this->_blockGroup = 'bfr_mach';
    $this->_headerText = Mage::helper('bfr_mach')->__('Mach Export');
  
    parent::__construct();
    $this->removeButton('add');
  }
}