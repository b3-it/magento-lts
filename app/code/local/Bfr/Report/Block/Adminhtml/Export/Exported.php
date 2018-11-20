<?php
/**
 *
 * @category   	Bfr Report
 * @package    	Bfr_Report
 * @name       	Bfr_Report_Block_ExportExported
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Report_Block_Adminhtml_Export_Exported extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_export_exported';
    $this->_blockGroup = 'bfr_report';
    $this->_headerText = Mage::helper('bfr_report')->__('Order Export');
   
   
    parent::__construct();
    $this->_removeButton('add');
  }
}
