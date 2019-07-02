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

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('bfr_eventparticipants/notification_order')->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'id',
        ));

        $this->addColumn('quote_item_id', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Quote'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index' => 'quote_item_id',
        ));
        $this->addColumn('order_item_id', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Order'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index' => 'order_item_id',
        ));
        $this->addColumn('customer_id', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Customer'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index' => 'customer_id',
        ));
        $this->addColumn('hash', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Hash'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index' => 'hash',
        ));
        $this->addColumn('status', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Status'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index' => 'status',
        ));
        $this->addColumn('event_id', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Event'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index' => 'event_id',
        ));
        $this->addColumn('signed_at', array(
            'header' => Mage::helper('bfr_eventparticipants')->__('Signed At'),
            //'align'     =>'left',
            //'width'     => '150px',
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
