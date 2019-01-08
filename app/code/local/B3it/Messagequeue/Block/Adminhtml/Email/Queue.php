<?php
/**
 *
 * @category   	B3it Messagequeue
 * @package    	b3it_mq
 * @name       	B3it_Messagequeue_Block_EmailQueue
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Block_Adminhtml_Email_Queue extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_email_queue';
    $this->_blockGroup = 'b3it_mq';
    $this->_headerText = Mage::helper('b3it_mq')->__('Email Queue Manager');
    $this->_addButtonLabel = Mage::helper('b3it_mq')->__('Add Item');
    parent::__construct();
  }
}
