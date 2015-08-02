<?php

class Egovs_Informationservice_Block_Adminhtml_Requesttype_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('requesttypeGrid');
      $this->setDefaultSort('requesttype_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('informationservice/requesttype')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('requesttype_id', array(
          'header'    => Mage::helper('informationservice')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'requesttype_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('informationservice')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));


      
      $this->addColumn('direction', array(
          'header'    => Mage::helper('informationservice')->__('Type'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'direction',
          'type'      => 'options',
          'options'   => Mage::getModel('informationservice/requesttype')->directionToOptionValueArray(),
      ));
  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('informationservice')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('informationservice')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
	
      return parent::_prepareColumns();
  }

 
  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}