<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Sid
 *  @package  Sid_Haushalt
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Haushalt_Block_Adminhtml_Haushalt extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_haushalt';
    $this->_blockGroup = 'haushalt';
    $this->_headerText = Mage::helper('haushalt')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('haushalt')->__('Add Item');
    parent::__construct();
  }
}