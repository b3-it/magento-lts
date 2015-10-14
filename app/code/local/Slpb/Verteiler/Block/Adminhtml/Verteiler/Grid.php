<?php

class Slpb_Verteiler_Block_Adminhtml_Verteiler_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('verteilerGrid');
      $this->setDefaultSort('verteiler_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('verteiler/verteiler')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('verteiler_id', array(
          'header'    => Mage::helper('verteiler')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'verteiler_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('verteiler')->__('Name'),
          'align'     =>'left',
      		'width'	=> '300',
          'index'     => 'name',
      ));
      
      $this->addColumn('description', array(
          'header'    => Mage::helper('verteiler')->__('description'),
          'align'     =>'left',
          'index'     => 'description',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('verteiler')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
/*
      $this->addColumn('status', array(
          'header'    => Mage::helper('verteiler')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	*/  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('verteiler')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('verteiler')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('verteiler')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('verteiler')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function x_prepareMassaction()
    {
        $this->setMassactionIdField('verteiler_id');
        $this->getMassactionBlock()->setFormFieldName('verteiler');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('verteiler')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('verteiler')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('verteiler/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('verteiler')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('verteiler')->__('Status'),
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