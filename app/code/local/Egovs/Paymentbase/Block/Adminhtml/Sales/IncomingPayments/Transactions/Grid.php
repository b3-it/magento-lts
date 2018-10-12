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
class Egovs_Paymentbase_Block_Adminhtml_Sales_IncomingPayments_Transactions_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
    public function __construct() {
        parent::__construct();
        $this->setId('sales_incoming_payments_transaction_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('epaybl_capture_date');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
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

    /**
     * Collection anpassen
     * 
     * @return Egovs_Paymentbase_Block_Adminhtml_Sales_IncomingPayments_Grid
     * 
     * @see Mage_Adminhtml_Block_Widget_Grid::_prepareCollection()
     */
    protected function _prepareCollection() {
 		/** @var \Mage_Sales_Model_Resource_Order_Payment_Collection $collection */
        $collection = Mage::getResourceModel('paymentbase/incoming_payment_collection');

        $collection->addFieldToFilter('order_id', $this->getOrder()->getId());

        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Anpassungen für Filter
     * 
     * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Spalte
     * 
     * @return Egovs_Paymentbase_Block_Adminhtml_Sales_IncomingPayments_Grid
     * 
     * @see Mage_Adminhtml_Block_Widget_Grid::_addColumnFilterToCollection()
     */
    protected function _addColumnFilterToCollection($column) {
        return parent::_addColumnFilterToCollection($column);
    }

    /**
     * Anpassung für Spalten
     * 
     * @return Egovs_Paymentbase_Block_Adminhtml_Sales_IncomingPayments_Grid
     * 
     * @see Mage_Adminhtml_Block_Widget_Grid::_prepareColumns()
     */
    protected function _prepareColumns() {

        $this->addColumn('epaybl_capture_date', array(
            'header' => Mage::helper('sales')->__('Capture Date'),
            'index' => 'epaybl_capture_date',
            'type' => 'datetime',
            'width' => '100px',
        ));

        $this->addColumn('base_paid', array(
            'header' => Mage::helper('paymentbase')->__('Paid (Base)'),
            'index' => 'base_paid',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

        $this->addColumn('base_total_paid', array(
            'header' => Mage::helper('paymentbase')->__('Total Paid (Base)'),
            'index' => 'base_total_paid',
            'type'  => 'currency',
            'currency' => 'base_currency_code',
        ));

        $this->addColumn('message', array(
            'header' => Mage::helper('paymentbase')->__('Message'),
            'index' => 'message',
        ));

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}
