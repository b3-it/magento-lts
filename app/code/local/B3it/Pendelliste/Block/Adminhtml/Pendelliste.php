<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category B3it
 *  @package  B3it_Pendelliste
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class B3it_Pendelliste_Block_Adminhtml_Pendelliste extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_pendelliste';
    $this->_blockGroup = 'pendelliste';
    $this->_headerText = Mage::helper('pendelliste')->__('Item Manager');
    $this->_addButtonLabel = Mage::helper('pendelliste')->__('Add Item');
    parent::__construct();
  }
}