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
class Egovs_Paymentbase_Block_Adminhtml_Sales_IncomingPayments_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
    public function __construct() {
        parent::__construct();
        $this->setId('sales_incoming_payments_grid');
        $this->setUseAjax(true);
        $this->setDefaultSort('kassenzeichen');
        $this->setDefaultDir('DESC');
        $this->setSaveParametersInSession(true);
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
        $collection = Mage::getResourceModel('sales/order_payment_collection');

        $collection->addFieldToFilter('kassenzeichen', array('notnull' => true));
        $collection->addFieldToFilter(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS, array('notnull' => true));
        $collection->join(array('sales_order' => 'sales/order'), 'main_table.parent_id = sales_order.entity_id', 'increment_id');

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

    	$this->addColumn('kassenzeichen', array(
				'header'    => Mage::helper('paymentbase')->__('Kassenzeichen'),
                'width' => '80px',
				'index'     => 'kassenzeichen',
				'type'      => 'text',
				)
		);

        $this->addColumn('real_order_id', array(
            'header'=> Mage::helper('sales')->__('Order #'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'increment_id',
        ));

        $this->addColumn('apr_status', array(
                'header'    => Mage::helper('paymentbase')->__('Status'),
                'width' => '80px',
                'index'     => Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS,
                //TODO Should be options
                'type'      => 'text',
            )
        );

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
}
