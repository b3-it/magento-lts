<?php
/**
 * Block für Offene Bestellungen
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Sales_Overview extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
    public function __construct() {
        $this->_controller = 'adminhtml_sales_overview';
        $this->_blockGroup = 'paymentbase';
        $this->_headerText = Mage::helper('sales')->__('Orders Overview');
        parent::__construct();
        $this->_removeButton('add');
    }

    public function xxgetPaymentInfoHtml()
    {
        return $this->getChildHtml('payment_info');
    }
}
