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
        $collection->addFieldToFilter(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS, array('gt' => 0));
        $collection->join(array('sales_order' => 'sales/order'), 'main_table.parent_id = sales_order.entity_id', array('increment_id', 'store_id'));

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

        if (!Mage::app()->isSingleStoreMode()) {
            $this->addColumn('store_id', array(
                'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
                'index'     => 'store_id',
                'type'      => 'store',
                'store_view'=> true,
                'display_deleted' => true,
                'escape'  => true,
            ));
        }

        $this->addColumn('apr_status', array(
                'header'    => Mage::helper('paymentbase')->__('Status'),
                'width' => '80px',
                'index'     => Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_STATUS,
                'type'      => 'options',
                'options'    => Mage::getModel('paymentbase/system_config_source_incomingPaymentStatus')->toArray()
            )
        );

        $this->addColumn('error_count', array(
            'header'=> Mage::helper('sales')->__('Errors #'),
            'width' => '80px',
            'type'  => 'number',
            'index' => Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_APR_ERROR_COUNT,
        ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('paymentbase')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getParentId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('paymentbase')->__('View'),
                        'url'       => array('base'=> '*/*/view'),
                        'field'     => 'order_id',
                        'data-column' => 'action'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
            ));

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

        return $this->getUrl('*/*/view',
            array(
                'order_id'=> $row->getParentId(),
            )
        );
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}
