<?php

class Dwd_Stationen_Block_Adminhtml_Set_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('setGrid');
      $this->setDefaultSort('updated_at');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
      $this->setDefaultFilter(array('status'=>Dwd_Stationen_Model_Set_Status::STATUS_ENABLED));
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('stationen/set')->getCollection();
      $collection->addAttributeToSelect('*');
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('entity_id', array(
          'header'    => Mage::helper('stationen')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'entity_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('stationen')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));

      
     $this->addColumn('description', array(
          'header'    => Mage::helper('stationen')->__('Description'),
          'align'     =>'left',
          'index'     => 'description',
      ));
      
      
      $this->addColumn('description', array(
          'header'    => Mage::helper('stationen')->__('Description'),
          'align'     =>'left',
          'index'     => 'description',
      ));
      
     $this->addColumn('created_at', array(
          'header'    => Mage::helper('stationen')->__('Created At'),
          'align'     =>'left',
          'index'     => 'created_at',
     	'width'		=> '150',
     	'type'	=> 'date',
      ));
      
      
      $this->addColumn('updated_at', array(
          'header'    => Mage::helper('stationen')->__('Updated At'),
          'align'     =>'left',
      	'width'		=> '150',
      	'type'	=> 'date',
          'index'     => 'updated_at',
      ));
      
      $this->addColumn('status', array(
          'header'    => Mage::helper('stationen')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => Dwd_Stationen_Model_Set_Status::getOptionArray()
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('stationen')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('stationen')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('stationen')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('stationen')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('set_id');
        $this->getMassactionBlock()->setFormFieldName('set');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('stationen')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('stationen')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('stationen/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('stationen')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('stationen')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}