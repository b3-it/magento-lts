<?php

class Sid_Framecontract_Block_Adminhtml_Contract_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('contractGrid');
      $this->setDefaultSort('contract_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('framecontract/contract')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('framecontract_contract_id', array(
          'header'    => Mage::helper('framecontract')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'framecontract_contract_id',
      ));

      
      $this->addColumn('number', array(
          'header'    => Mage::helper('framecontract')->__('Number'),
          'align'     =>'left',
      	  'width'     => '80px',
          'index'     => 'contractnumber',
      ));
      
      
      $this->addColumn('title', array(
          'header'    => Mage::helper('framecontract')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
      
      $this->addColumn('start', array(
          'header'    => Mage::helper('framecontract')->__('Start Date'),
          'align'     =>'center',
      	  'width'     => '80px',
      	  'type'      => 'date',
          'index'     => 'start_date',
      ));
      
      $this->addColumn('ende', array(
          'header'    => Mage::helper('framecontract')->__('Stop Date'),
          'align'     =>'center',
      	  'width'     => '80px',
      	  'type'      => 'date',
          'index'     => 'end_date',
      ));

	  $this->addColumn('framecontract_vendor_id', array(
			'header'    => Mage::helper('framecontract')->__('Vendor'),
			'width'     => '150px',
			'index'     => 'framecontract_vendor_id',
	  		'type'      => 'options',
          	'options'   => Mage::getModel('framecontract/vendor')->toOptionArray()
      ));


      $this->addColumn('status', array(
          'header'    => Mage::helper('framecontract')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => Mage::helper('framecontract')->__('Enabled'),
              2 => Mage::helper('framecontract')->__('Disabled'),
          ),
      ));

        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('framecontract')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('framecontract')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('framecontract')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('framecontract')->__('XML'));
	  
      return parent::_prepareColumns();
  }

   

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}