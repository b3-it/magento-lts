<?php
/**
 * Slpb Customer
 * 
 * 
 * @category   	Slpb
 * @package    	Slpb_Customer
 * @name       	Slpb_Customer_Block_Adminhtml_Sales
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Slpb_Customer_Block_Adminhtml_Sales extends Mage_Adminhtml_Block_Widget_Grid_Container
{
  public function __construct()
  {
    $this->_controller = 'adminhtml_sales';
    $this->_blockGroup = 'slpbcustomer';
    $this->_headerText = Mage::helper('slpbcustomer')->__('Customers last order');
   
    
    parent::__construct();
    
    $this->removeButton('add');
    
  }
}