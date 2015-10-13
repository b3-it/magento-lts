<?php

class Dwd_Stationen_Block_Adminhtml_Stationen_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('stationenGrid');
      $this->setDefaultSort('name');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setDefaultFilter(array('status'=>Dwd_Stationen_Model_Stationen_Status::STATUS_ACTIVE));
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('stationen/stationen')->getCollection();
      $collection->addAttributeToSelect('*');
      $this->setCollection($collection);
      //die($collection->getSelect()->__toString());
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('stationskennung', array(
          'header'    => Mage::helper('stationen')->__('Kennung'),
          'align'     =>'right',
          'width'     => '150px',
          'index'     => 'stationskennung',
      	  'use_index'     => 'stationskennung',
      	//'filter_index' => 'e.stationskennung'
      ));
     $this->addColumn('mirakel', array(
          'header'    	=> Mage::helper('stationen')->__('Mirakel ID'),
          'align'     	=>'right',
          'width'     	=> '100px',
          'index'     	=> 'mirakel_id', 
      ));
      
      $this->addColumn('name', array(
          'header'    => Mage::helper('stationen')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      //'width'     => '150px',
      ));
      
      $filter = Mage::getModel('stationen/entity_attribute_source_filter'); 
      $filter->setConfigKey('messnetz');
      $this->addColumn('messnetz', array(
          'header'    => Mage::helper('stationen')->__('Messnetz'),
          'align'     =>'left',
          'index'     => 'messnetz',
     	  'width'     => '150px',
      	  'type'      => 'options',
          'options'   => $filter->getOptionArray(),
      ));
      
     $filter->setConfigKey('styp');
     $this->addColumn('styp', array(
          'header'    => Mage::helper('stationen')->__('styp'),
          'align'     =>'left',
          'index'     => 'styp',
      	  'width'     => '150px',
          'type'      => 'options',
          'options'   => $filter->getOptionArray(),
      ));
      
      $filter->setConfigKey('ktyp');
      $this->addColumn('ktyp', array(
          'header'    => Mage::helper('stationen')->__('ktyp'),
          'align'     =>'left',
          'index'     => 'ktyp',
      	  'width'     => '150px',
          'type'      => 'options',
          'options'   => $filter->getOptionArray(),
      ));
      /*
      $this->addColumn('short_description', array(
          'header'    => Mage::helper('stationen')->__('Short Description'),
          'align'     =>'left',
          'index'     => 'short_description',
      ));
      */
      $this->addColumn('avail_from', array(
          'header'    => Mage::helper('stationen')->__('Start Date'),
          'align'     =>'left',
          'index'     => 'avail_from',
       	  'type'	=>'date',
      	  'width'	=> '80px',
      ));
      
      $this->addColumn('avail_to', array(
          'header'    => Mage::helper('stationen')->__('End Date'),
          'align'     =>'left',
          'index'     => 'avail_to',
      	  'type'	=>'date',
      	  'width'	=> '80px',
      ));
      
     $this->addColumn('lat', array(
          'header'    => Mage::helper('stationen')->__('Latitude'),
          'align'     =>'left',
          'index'     => 'lat',
     	'type'	=> 'number',
     		'width'	=> '100px',
      ));
      
      $this->addColumn('lon', array(
          'header'    => Mage::helper('stationen')->__('Longitude'),
          'align'     =>'left',
          'index'     => 'lon',
      	'type'	=> 'number',
      		'width'	=> '100px',
      ));
      
      $this->addColumn('height', array(
          'header'    => Mage::helper('stationen')->__('Height NN'),
          'align'     =>'left',
          'index'     => 'height',
      'type'	=> 'number',
      		'width'	=> '80px',
      ));
      
      $this->addColumn('updated_at', array(
          'header'    => Mage::helper('stationen')->__('Updated At'),
          'align'     =>'left',
          'index'     => 'updated_at',
      	  'type'	=> 'date',	
      	  'width'	=> '80px',
      ));

	  
      $this->addColumn('status', array(
          'header'    => Mage::helper('stationen')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => Dwd_Stationen_Model_Stationen_Status::getOptionArray()
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
        $this->setMassactionIdField('stationen_id');
        $this->getMassactionBlock()->setFormFieldName('stationen');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('stationen')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('stationen')->__('Are you sure?')
        ));

        $statuses = Dwd_Stationen_Model_Stationen_Status::getOptionArray();

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