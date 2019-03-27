<?php
/**
 *
 * @category   	Gka Internalpayid
 * @package    	Gka_InternalPayId
 * @name       	Gka_InternalPayId_Block_EpayblClient
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_InternalPayId_Block_Adminhtml_Epaybl_Client extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_epaybl_client';
    $this->_blockGroup = 'internalpayid';
    $this->_headerText = Mage::helper('internalpayid')->__('Specialized Procedure Manager');
    $this->_addButtonLabel = Mage::helper('internalpayid')->__('Add Item');
    parent::__construct();
  }
}
