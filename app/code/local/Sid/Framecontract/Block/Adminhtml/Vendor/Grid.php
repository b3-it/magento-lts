<?php

class Sid_Framecontract_Block_Adminhtml_Vendor_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('vendorGrid');
      $this->setDefaultSort('vendor_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('framecontract/vendor')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('framecontract_vendor_id', array(
          'header'    => Mage::helper('framecontract')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'framecontract_vendor_id',
      ));

      $this->addColumn('company', array(
          'header'    => Mage::helper('framecontract')->__('Company'),
          'align'     =>'left',
          'index'     => 'company',
      ));
      
      $this->addColumn('operator', array(
          'header'    => Mage::helper('framecontract')->__('Operator'),
          'align'     =>'left',
      	  'width'     => '150px',
          'index'     => 'operator',
      ));
      
     $this->addColumn('street', array(
          'header'    => Mage::helper('framecontract')->__('Street'),
          'align'     =>'left',
      	  'width'     => '100px',
          'index'     => 'street',
      ));
      
     $this->addColumn('city', array(
          'header'    => Mage::helper('framecontract')->__('City'),
          'align'     =>'left',
      	  'width'     => '100px',
          'index'     => 'city',
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