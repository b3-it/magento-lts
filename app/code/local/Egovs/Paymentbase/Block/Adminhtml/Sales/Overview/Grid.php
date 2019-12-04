<?php
/**
 * Block Grid für Offene Bestellungen
 *
 * @category    Egovs
 * @package        Egovs_Paymentbase
 * @author         Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright    Copyright (c) 2012 EDV Beratung Hempel
 * @license        http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Sales_Overview_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Konstruktor
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
        $this->setId('sales_overview_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('created_at');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
    }

    protected function _getBillingNameExpr() {
        return new Zend_Db_Expr('CONCAT(COALESCE(billing_address.firstname, ""), " ", COALESCE(billing_address.lastname, ""))');
    }

    protected function _getBillingCompanyExpr() {
        return new Zend_DB_Expr('CONCAT(COALESCE(billing_address.company, ""), " ", COALESCE(billing_address.company2, ""), " ", COALESCE(billing_address.company3, ""))');
    }

    protected function _getBillingAddressExpr() {
        return new Zend_DB_Expr('CONCAT(COALESCE(billing_address.street, ""), " ", COALESCE(billing_address.city, ""), " ", COALESCE(billing_address.postcode, ""))');
    }

    protected function _getPaymentDeadlineExpr() {
        return new Zend_Db_Expr('date_add(main_table.created_at,INTERVAL `payment`.`paywithinxdays` DAY)');
    }

    /**
     * Collection anpassen
     *
     * @return Egovs_Paymentbase_Block_Adminhtml_Sales_Overview_Grid
     *
     * @see Mage_Adminhtml_Block_Widget_Grid::_prepareCollection()
     */
    protected function _prepareCollection() {
        /**
         * @var Mage_Sales_Model_Resource_Order_Invoice_Collection $collection
         */
        $collection = Mage::getResourceModel('sales/order_invoice_collection');

        $shipSelect = $collection->getConnection()->select();
        $shipSelect->from($collection->getTable('sales/order_item'), ['ship_order_id' => 'order_id', 'not_shiped' => new Zend_Db_Expr("sum(if(is_virtual,0,1) * (qty_ordered - qty_shipped)) > 0")]);
        $shipSelect->group('order_id');

        $collection->join(['order' => "sales/order"], 'order.entity_id=main_table.order_id', [
            "order_status"=>'status', 'order_created_at'=>'created_at', 'billing_address_id'=>'billing_address_id', 'order_increment_id'=>'increment_id'
        ]);

        $collection->join(['billing_address' => "sales/order_address"], 'billing_address.entity_id=order.billing_address_id', [
            'billing_firstname'=>'firstname', 'billing_lastname'=>'lastname'
        ]);

        $collection->getSelect()->joinLeft(array('shipment'=> $shipSelect), 'main_table.order_id=shipment.ship_order_id');
        $collection->getSelect()->joinLeft(array('payment' => $collection->getTable("sales/order_payment")), 'payment.parent_id=main_table.order_id', array('paywithinxdays'=>'paywithinxdays','method'=>'method','kassenzeichen'=>'kassenzeichen'));

        $collection->addExpressionFieldToSelect('billing_name', $this->_getBillingNameExpr(), []);
        $collection->addExpressionFieldToSelect('billing_company_full', $this->_getBillingCompanyExpr(), []);
        $collection->addExpressionFieldToSelect('billing_adr', $this->_getBillingAddressExpr(), []);

        $collection->addFilterToMap('billing_name', $this->_getBillingNameExpr());
        $collection->addFilterToMap('billing_company_full', $this->_getBillingCompanyExpr());
        $collection->addFilterToMap('billing_adr', $this->_getBillingAddressExpr());

        $collection->addExpressionFieldToSelect('zahlungsziel', $this->_getPaymentDeadlineExpr(), []);
        $collection->addFilterToMap('zahlungsziel', $this->_getPaymentDeadlineExpr());

        $collection->addFieldToFilter('order.status', ['nin' => ['complete', 'closed', 'canceled']]);

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Anpassung für Spalten
     *
     * @return Egovs_Paymentbase_Block_Adminhtml_Sales_Overview_Grid
     *
     * @see Mage_Adminhtml_Block_Widget_Grid::_prepareColumns()
     */
    protected function _prepareColumns() {

        $this->addColumn('method', array(
                'header'    => Mage::helper('sales')->__('Payment Method'),
                'index'     => 'method',
                'type'      => 'options',
                'width'     => '130px',
                'options'   => Mage::helper('paymentbase')->getActivePaymentMethods(),
                )//,
                //'billing_address'
        );

        $this->addColumn('ziel', array(
            'header'    => Mage::helper('sales')->__('Pay Within x Days'),
            'index'     => 'zahlungsziel',
            'type'      => 'datetime',
        ));

        $this->addColumn('state', array(
            'header'       => Mage::helper('sales')->__('Payment Status'),
            'index'        => 'state',
            'type'         => 'options',
            'options'      => Mage::getModel('sales/order_invoice')->getStates(),
            'renderer'     => 'Egovs_Paymentbase_Block_Adminhtml_Sales_Overview_Renderer_Paymentstate',
            'filter_index' => 'main_table.state'
        ));

         $this->addColumn('state2', array(
            'header'    => Mage::helper('sales')->__('Shipment Status'),
            'index'     => 'not_shiped',
            'type'      => 'options',
            'options'   => $this->_getShipmentstates(),
            'renderer' => 'Egovs_Paymentbase_Block_Adminhtml_Sales_Overview_Renderer_Shipmentstate'
        ));

        $this->addColumn('order_increment_id', array(
            'header'    => Mage::helper('sales')->__('Order #'),
            'index'     => 'order_increment_id',
            'type'      => 'text',
            'filter_index' => 'order.increment_id'
        ));

       $this->addColumn('kz', array(
            'header'    => Mage::helper('sales')->__('Kassenzeichen'),
            'index'     => 'kassenzeichen',
            'type'      => 'text',
        ));

       $this->addColumn('order_created_at', array(
            'header'    => Mage::helper('sales')->__('Order Date'),
            'index'     => 'order_created_at',
            'type'      => 'datetime',
           'filter_index' => 'order.created_at'
        ));

         $this->addColumn('billing_company_full', array(
            'header' => Mage::helper('sales')->__('Company'),
            'index' => 'billing_company_full',
        ));

         $this->addColumn('billing_name', array(
            'header' => Mage::helper('sales')->__('Bill to Name'),
            'index' => 'billing_name',
            //'filter_index' => Zend_Db_Expr::class
        ));

         $this->addColumn('billing_adr', array(
            'header' => Mage::helper('sales')->__('Billing Address'),
            'index' => 'billing_adr',
        ));

        /*
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('sales')->__('Action'),
                'width'     => '50px',
                'type'      => 'action',
                'getter'     => 'getOrderId',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('sales')->__('View'),
                        'url'     => array('base'=>'adminhtml/sales_order/view'),
                        'field'   => 'order_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'is_system' => true
        ));
*/
        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel XML'));

        return parent::_prepareColumns();
    }

    /**
     * Liefert die URL für eine Klick-Aktion auf einer Zeile
     *
     * @param Varien_Object $row Zeile
     *
     * @return string
     */
    public function getRowUrl($row) {
        if (!Mage::getSingleton('admin/session')->isAllowed('sales/order/view')) {
            return false;
        }

        return $this->getUrl('adminhtml/sales_order/view',
            array(
                'order_id'=> $row->getOrderId(),
            )
        );
    }

    /**
     * Liefert die URL für Ajax
     *
     * @return string
     */
    public function getGridUrl() {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    /**
     * Verfügbare Versandstatus ermitteln
     *
     * @return array
     */
    protected function _getShipmentstates() {
        $res = array();
        $res[0] = Mage::helper('paymentbase')->__('Shipped');
        $res[1] = Mage::helper('paymentbase')->__('Not Shipped');
        return $res;
    }

}
