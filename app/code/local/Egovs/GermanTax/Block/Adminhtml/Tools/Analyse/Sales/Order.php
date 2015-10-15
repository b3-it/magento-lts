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
class Egovs_GermanTax_Block_Adminhtml_Tools_Analyse_Sales_Order extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct() {
    	$this->_blockGroup = 'germantax';
        $this->_controller = 'adminhtml_tools_analyse_sales_order';
        $this->_headerText = Mage::helper('sales')->__('Orders');
        //$this->_addButtonLabel = Mage::helper('sales')->__('Create New Order');
        parent::__construct();
       	$this->_removeButton('add');
        
    }


}
