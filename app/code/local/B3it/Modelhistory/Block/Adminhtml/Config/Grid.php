<?php
class B3it_Modelhistory_Block_Adminhtml_Config_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection()
    {
        /**
         * @var B3it_Modelhistory_Model_Resource_Config_Collection $collection
         */
        $model = Mage::getModel('b3it_modelhistory/config');
        $collection = $model->getCollection();
        
        $this->_defaultSort = "date";
        
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

        $this->addColumn('path', array(
            'header'    => Mage::helper('core')->__('Path'),
            'align'     => 'left',
            'index'     => 'path',
            'type'      => 'text'
        ));

        /*/
        $this->addColumn('model_id', array(
            'header'    => Mage::helper('core')->__('Model ID'),
            'align'     =>'left',
            'index'     => 'model_id',
            'type'      => 'number'
        ));
        //*/

        $this->addColumn('store_code', array(
            'header'    => Mage::helper('core')->__('Store'),
            'align'     => 'left',
            'index'     => 'store_code',
            //'renderer'  => 'Mage_Adminhtml_Block_System_Store_Grid_Render_Store'
        ));

        $this->addColumn('website_code', array(
            'header'    => Mage::helper('core')->__('Website'),
            'align'     => 'left',
            'index'     => 'website_code',
            //'renderer'  => 'Mage_Adminhtml_Block_System_Store_Grid_Render_Website'
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
            'align'     => 'left',
            'index'     => 'user',
        ));
        $this->addColumn('ip', array(
            'header'    => Mage::helper('core')->__('IP'),
            'align'     => 'left',
            'index'     => 'ip'
        ));
        $this->addColumn('date', array(
            'header'    => Mage::helper('core')->__('Datum'),
            'align'     => 'left',
            'index'     => 'date',
            'type'      => 'datetime'
        ));
        
        //*/
        $this->addColumn('rev', array(
            'header'    => Mage::helper('core')->__('Revision'),
            'align'     => 'left',
            'index'     => 'rev',
            'type'      => 'number'
        ));
        //*/

        $this->addColumn('value', array(
            'header'    => Mage::helper('core')->__('Diff'),
            'align'     => 'left',
            'index'     => 'value',
            'width'     => '150px',
            'renderer'  => 'B3it_Modelhistory_Block_Adminhtml_Widget_Grid_Column_Renderer_Diff',
            'column_css_class' => 'finediff',
            'short_diff' => false
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
//                             'base' => '*/*/restore',
//                             //'params'=>array('store'=>$this->getRequest()->getParam('store'))
//                         ),
//                         'field'   => 'id'
//                     )
//                 ),
//                 'filter'    => false,
//                 'sortable'  => false,
//                 'renderer' => 'B3it_Modelhistory_Block_Adminhtml_Widget_Grid_Column_Renderer_Actions'
//             ));

        return parent::_prepareColumns();
    }
}