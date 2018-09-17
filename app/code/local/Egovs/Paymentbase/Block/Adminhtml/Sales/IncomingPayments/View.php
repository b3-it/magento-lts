<?php

/**
 * Class Egovs_Paymentbase_Block_Adminhtml_Sales_IncomingPayments_Grid
 *
 * @category  Egovs
 * @package   Egovs_Paymentbase
 * @author    Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright Copyright (c) 2018 B3 IT Systeme GmbH - https://www.b3-it.de
 * @license   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Sales_IncomingPayments_View extends Mage_Adminhtml_Block_Widget_Form_Container
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
    public function __construct() {
        $this->_objectId    = 'order_id';
        $this->_blockGroup  = 'paymentbase';
        $this->_controller  = 'adminhtml_sales_incomingPayments';
        $this->_mode        = 'view';

        parent::__construct();

        $this->_removeButton('delete');
        $this->_removeButton('reset');
        $this->_removeButton('save');

        $resetUrl = $this->getUrl('*/*/reset', array('order_id' => $this->getRequest()->getParam('order_id')));
        $this->_addButton('reset', array(
            'label'     => Mage::helper('adminhtml')->__('Reset'),
            'onclick'   => "setLocation('$resetUrl')",
            'class'   => 'task'
        ), -1);

        $this->setId('sales_incomingpayments_view');
    }

    /**
     * Retrieve available order
     *
     * @return Mage_Sales_Model_Order
     */
    public function getOrder()
    {
        if ($this->hasOrder()) {
            return $this->getData('order');
        }
        if (Mage::registry('current_order')) {
            return Mage::registry('current_order');
        }
        if (Mage::registry('order')) {
            return Mage::registry('order');
        }
        Mage::throwException(Mage::helper('sales')->__('Cannot get the order instance.'));
    }

    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/' . $action);
    }

    public function getHeaderText()
    {
        return Mage::helper('paymentbase')->__('Incoming Payment Transactions for Kassenzeichen %s', $this->getOrder()->getPayment()->getKassenzeichen());
    }
}
