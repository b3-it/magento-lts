<?php

class Sid_Framecontract_Block_Adminhtml_Order_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('orderGrid');
      $this->setDefaultSort('order_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('framecontract/order')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('framecontract_order_id', array(
          'header'    => Mage::helper('framecontract')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'framecontract_order_id',
      ));

      $this->addColumn('order', array(
          'header'    => Mage::helper('framecontract')->__('Order'),
          'align'     =>'left',
          'index'     => 'order_id',
      ));
      
       $this->addColumn('contract', array(
          'header'    => Mage::helper('framecontract')->__('Contract'),
          'align'     =>'left',
          'index'     => 'framecontract_id',
      ));
      
      $this->addColumn('address', array(
          'header'    => Mage::helper('framecontract')->__('Address'),
          'align'     =>'left',
          'index'     => 'shipping_order_address_id',
      ));
      
     $this->addColumn('principal_email', array(
          'header'    => Mage::helper('framecontract')->__('Principal Email'),
          'align'     =>'left',
          'index'     => 'principal_email',
      ));
      
     $this->addColumn('vendor_email', array(
          'header'    => Mage::helper('framecontract')->__('Vendor Email'),
          'align'     =>'left',
          'index'     => 'vendor_email',
      ));
      
      $this->addColumn('transmit_date', array(
          'header'    => Mage::helper('framecontract')->__('Date'),
          'align'     =>'left',
          'index'     => 'transmit_date',
      ));


		
		$this->addExportType('*/*/exportCsv', Mage::helper('framecontract')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('framecontract')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  

 

}