<?php

/**
 *
 * @category    Bfr Eventparticipants
 * @package     Bfr_Eventparticipants
 * @name        Bfr_Eventparticipants_Block_Adminhtml_Notification_Order_Grid
 * @author      Holger Kögel <h.koegel@b3-it.de>
 * @copyright   Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Eventparticipants_Block_Adminhtml_Notification_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('notification_orderGrid');
        $this->setDefaultSort('notification_order_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bfr_eventparticipants/notification_order')->getCollection();
        $collection->getSelect()
            ->join(['orderItem' => $collection->getTable('sales/order_item')],'orderItem.item_id = main_table.order_item_id',['item_id'])
            ->join(['order' => $collection->getTable('sales/order')],'order.entity_id = orderItem.order_id',['increment_id'])
            ->join(['customer' => $collection->getTable('customer/entity')], 'main_table.customer_id = customer.entity_id',['email'])
            ->join(['event' => $collection->getTable('eventmanager/event')],'main_table.event_id = event.event_id',['title']);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * @return Mage_Adminhtml_Block_Widget_Grid
     * @throws Exception
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));
        $this->addColumn('order_id', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Order'),
            'index' => 'increment_id',
        ));
        $this->addColumn('customer_email', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Customer'),
            'index' => 'email',
        ));
        $this->addColumn('status', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Status'),
            'index' => 'status',
            'type'  => 'options',
            'options' => Bfr_Eventparticipants_Model_Resource_Accepted::getOptionArray(),
            'filter_index' => 'main_table.status'
        ));
        $this->addColumn('event_name', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Event'),
            'index' => 'title',
        ));
        $this->addColumn('signed_at', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Signed At'),
            'index' => 'signed_at',
        ));

        $this->addColumn('action',
            array(
                'header' => Mage::helper('bfr_eventparticipants')->__('Action'),
                'width' => '100',
                'type' => 'action',
                'getter' => 'getId',
                'actions' => array(
                    array(
                        'caption' => Mage::helper('bfr_eventparticipants')->__('Edit'),
                        'url' => array('base' => '*/*/edit'),
                        'field' => 'id'
                    )
                ),
                'filter' => false,
                'sortable' => false,
                'index' => 'stores',
                'is_system' => true,
            ));

        $this->addExportType('*/*/exportCsv', Mage::helper('bfr_eventparticipants')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('bfr_eventparticipants')->__('XML'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('notificationorder_ids');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => Mage::helper('bfr_eventparticipants')->__('Delete'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => Mage::helper('bfr_eventparticipants')->__('Are you sure?')
        ));

        return $this;
    }

    public function getGridUrl($params = array())
    {
        if (!isset($params['_current'])) {
            $params['_current'] = true;
        }
        return $this->getUrl('*/*/*', $params);

    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
