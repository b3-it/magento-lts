<?php
/**
 *
 * @category   	Dwd Fix
 * @package    	Dwd_Fix
 * @name       	Dwd_Fix_Block_RechnungRechnung
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Fix_Block_Adminhtml_Rechnung_Rechnung extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_rechnung_rechnung';
    $this->_blockGroup = 'dwd_fix';
    $this->_headerText = Mage::helper('dwd_fix')->__('Rechnung Manager');
    $this->_addButtonLabel = Mage::helper('dwd_fix')->__('Send Invoices');
    parent::__construct();
  }
}
