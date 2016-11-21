<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_GermanTax
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Order_Items extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct() {
    	$this->_blockGroup = 'extreport';
        $this->_controller = 'sales_order_items';
        $this->_headerText = Mage::helper('sales')->__('Orders');
        
        parent::__construct();
       	$this->_removeButton('add');
        
    }


}
