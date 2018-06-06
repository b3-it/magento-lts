<?php
/**
*
* @category   	Egovs ContextHelp
* @package    	Egovs_ContextHelp
* @name       	Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Grid
* @author 		Holger Kögel <h.koegel@b3-it.de>
* @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
* @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
*/
class Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('contexthelpGrid');
        $this->setDefaultSort('contexthelp_id');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);

        $this->_emptyText = Mage::helper('adminhtml')->__('No records found.');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('contexthelp/contexthelp')->getCollection();

        foreach($collection as $item) {
            if( $item->getStoreIds() ) {
                $item->setStoreIds( explode( ',', $item->getStoreIds() ) );
            }
            else {
                $item->setStoreIds( array('0') );
            }
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'    => Mage::helper('contexthelp')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'id',
        ));

        $this->addColumn('title', array(
            'header'    => Mage::helper('contexthelp')->__('Title'),
            //'align'     =>'left',
            //'width'     => '150px',
            'index'     => 'title',
        ));

        $this->addColumn('store_ids', array(
            'header'     => Mage::helper('cms')->__('Store View'),
            'index'      => 'store_ids',
            'type'       => 'store',
            'width'      => '300px',
            'store_all'  => true,
            'store_view' => true,
            'sortable'   => false,
            'filter_condition_callback'
                         => array($this, '_filterStoreCondition'),
        ));

        $this->addColumn('package_theme', array(
            'header'     => Mage::helper('widget')->__('Design Package/Theme'),
            'index'      => 'package_theme',
            'type'       => 'theme',
            'width'      => '200px',
            'with_empty' => true,
        ));

        $this->addColumn('category_id', array(
            'header'    => Mage::helper('contexthelp')->__('Category'),
            'type'      => 'options',
            'options'   => Mage::getModel('contexthelp/category')->getOptions(),
            'width'     => '200px',
            'index'     => 'category_id',
        ));

        $this->addColumn('action', array(
            'header'    =>  Mage::helper('contexthelp')->__('Action'),
            'width'     => '100',
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption'   => Mage::helper('contexthelp')->__('Edit'),
                    'url'       => array('base'=> '*/*/edit'),
                    'field'     => 'id'
                )
            ),
            'filter'    => false,
            'sortable'  => false,
            'index'     => 'stores',
            'is_system' => true,
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('contexthelp')->__('CSV'));
        $this->addExportType('*/*/exportXml', Mage::helper('contexthelp')->__('XML'));
        $this->addExportType('*/*/exportExcel', Mage::helper('contexthelp')->__('XML (Excel)'));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('contexthelp_ids');

        $this->getMassactionBlock()->addItem('delete', array(
            'label'    => Mage::helper('contexthelp')->__('Delete'),
            'url'      => $this->getUrl('*/*/massDelete'),
            'confirm'  => Mage::helper('contexthelp')->__('Are you sure?')
        ));

        return $this;
    }

    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        $this->getCollection()->addStoreFilter($value);
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
