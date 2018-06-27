<?php
/**
 *
 * @category   	Gka Reports
 * @package    	Gka_Reports
 * @name       	Gka_Reports_Block_Adminhtml_Overview
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Reports_Block_Adminhtml_Overview extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_overview';
    $this->_blockGroup = 'gka_reports';
    $this->_headerText = Mage::helper('gka_reports')->__('Overview');



    parent::__construct();
      $this->_removeButton('add');
  }
}
