<?php
class B3it_Modelhistory_Block_Adminhtml_Settings_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    protected function _prepareCollection()
    {
        /**
         * @var B3it_Modelhistory_Model_Resource_History_Collection $collection
         */
        $model = Mage::getModel('b3it_modelhistory/settings');
        $collection = $model->getCollection();

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
        
        $this->addColumn('blocked', array(
            'header'    => Mage::helper('core')->__('blocked'),
            'align'     =>'left',
            'index'     => 'blocked',
            'type'      => 'options',
            'options'   => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
            
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