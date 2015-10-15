<?php
/**
 * Dimdi Report
 *
 *
 * @category   	Dimdi_Report
 * @package    	Dimdi_Report
 * @name        Dimdi_Report_Block_Adminhtml_Access
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dimdi_Report_Block_Adminhtml_Access extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_access';
    $this->_blockGroup = 'dimdireport';
    $this->_headerText = Mage::helper('dimdireport')->__('Access Overview');
    
    parent::__construct();
    $this->removeButton('add');
  }
}