<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Gka
 *  @package  Gka_Reports
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_Reports_Block_Adminhtml_Reports extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_reports';
    $this->_blockGroup = 'reports';
    $this->_headerText = Mage::helper('reports')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('reports')->__('Add Item');
    parent::__construct();
  }
}