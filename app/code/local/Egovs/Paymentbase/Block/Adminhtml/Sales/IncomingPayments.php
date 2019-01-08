<?php

/**
 * Class Egovs_Paymentbase_Block_Adminhtml_Sales_IncomingPayments
 *
 * @category  Egovs
 * @package   Egovs_Paymentbase
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Sales_IncomingPayments extends Mage_Adminhtml_Block_Widget_Grid_Container
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
    public function __construct() {
        $this->_controller = 'adminhtml_sales_incomingPayments';
        $this->_blockGroup = 'paymentbase';
        $this->_headerText = Mage::helper('sales')->__('Incoming Payments');
        parent::__construct();
        $this->_removeButton('add');
        $this->_addButton(
            'run_button',
            array(
                'label'     => Mage::helper('adminhtml')->__('Retrieve Payments'),
                'onclick'   => "setLocation('{$this->getUrl('*/paymentbase_retrievepayedorders/index')}')",
                'class'   => 'task'
            )
        );
    }
}
