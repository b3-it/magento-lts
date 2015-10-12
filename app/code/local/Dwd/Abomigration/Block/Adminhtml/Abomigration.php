<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Dwd
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Dwd_Abomigration_Block_Adminhtml_Abomigration extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_abomigration';
    $this->_blockGroup = 'abomigration';
    $this->_headerText = Mage::helper('abomigration')->__('Migration Abonements');
    //$this->_addButtonLabel = Mage::helper('abomigration')->__('Add Item');
    parent::__construct();
    $this->removeButton('add');
  }
}