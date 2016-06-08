<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Block_Adminhtml_Event
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Block_Adminhtml_Event extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_event';
    $this->_blockGroup = 'eventmanager';
    $this->_headerText = Mage::helper('eventmanager')->__('Event Manager');
    $this->_addButtonLabel = Mage::helper('eventmanager')->__('Add Event');
    parent::__construct();
  }
}