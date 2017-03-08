<?php
class B3it_Modelhistory_Block_Adminhtml_Modelhistory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection()
    {
        /**
         * @var B3it_Modelhistory_Model_Resource_History_Collection $collection
         */
        $model = Mage::getModel('b3it_modelhistory/history');
        $collection = $model->getCollection();

        // complex default sorting
        if (!$this->getParam($this->getVarNameSort(), $this->_defaultSort)) {
            $collection->addAttributeToSort('model');
            $collection->addAttributeToSort('model_id');
            $collection->addAttributeToSort('rev', 'desc');
        }

        $this->setCollection($collection);
        return parent::_prepareCollection();
    }
    
    protected function _prepareColumns()
    {
        /*
        $this->addColumn('id', array(
            'header'    => Mage::helper('core')->__('ID'),
            'align'     =>'right',
            'width'     => '50px',
            'index'     => 'id',
        ));
        //*/

        $this->addColumn('model', array(
            'header'    => Mage::helper('core')->__('Model'),
            'align'     =>'left',
            'index'     => 'model',
        ));

        $this->addColumn('model_id', array(
            'header'    => Mage::helper('core')->__('Model ID'),
            'align'     =>'left',
            'index'     => 'model_id',
            'type'      => 'number'
        ));

        $this->addColumn('type', array(
            'header'    => Mage::helper('core')->__('Type'),
            'align'     => 'left',
            'index'     => 'type',
            'type'      => 'options',
            'options'   => array(1 => "hinzugefügt", 2 => "geändert", 3 => "gelöscht")
        ));

        $this->addColumn('user', array(
            'header'    => Mage::helper('core')->__('User'),
            'align'     =>'left',
            'index'     => 'user',
        ));
        $this->addColumn('ip', array(
            'header'    => Mage::helper('core')->__('IP'),
            'align'     =>'left',
            'index'     => 'ip',
        ));
        $this->addColumn('date', array(
            'header'    => Mage::helper('core')->__('Datum'),
            'align'     =>'left',
            'index'     => 'date',
            'type'      => 'datetime',
            'renderer'  => 'B3it_Modelhistory_Block_Adminhtml_Widget_Grid_Column_Renderer_Datetime',
            'use_time_zone' => false
        ));
        
        //*
        $this->addColumn('rev', array(
            'header'    => Mage::helper('core')->__('Revision'),
            'align'     =>'left',
            'index'     => 'rev',
            'type'      => 'number'
        ));
        //*/
        $this->addColumn('value', array(
            'header'    => Mage::helper('core')->__('Diff'),
            'align'     =>'left',
            'index'     => 'value',
            'width'     => '150px',
            'renderer'  => 'B3it_Modelhistory_Block_Adminhtml_Widget_Grid_Column_Renderer_Diff',
            'column_css_class' => 'finediff',
            'short_diff' => true
        ));

//         $this->addColumn('action',
//             array(
//                 'header'    => Mage::helper('core')->__('Action'),
//                 'width'     => '50px',
//                 'type'      => 'action',
//                 'getter'    => 'getId',
//                 'actions'   => array(
//                     array(
//                         'caption' => Mage::helper('core')->__('Restore'),
//                         'url'     => array(
//                             'base' => '*/*/restore'
//                             //'params'=>array('store'=>$this->getRequest()->getParam('store'))
//                         ),
//                         'field'   => 'id',
//                         'confirm' => true
//                     )
//                 ),
//                 'filter'    => false,
//                 'sortable'  => false,
//                 'renderer' => 'B3it_Modelhistory_Block_Adminhtml_Widget_Grid_Column_Renderer_Actions'
//             ));

        return parent::_prepareColumns();
    }
}