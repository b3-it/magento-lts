<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Block_ComponentsFormatentity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Block_Adminhtml_Period extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_period';
    $this->_blockGroup = 'b3it_subscription';
    $this->_headerText = Mage::helper('b3it_subscription')->__('Period Manager');
   
    parent::__construct();
  }
}
