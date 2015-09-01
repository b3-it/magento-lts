<?php

class Sid_Framecontract_Block_Adminhtml_Contract_Edit_Tab_Transmit_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('transmitGrid');
      $this->setDefaultSort('transmit_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->_headersVisibility = false;
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('framecontract/transmit')->getCollection();
      $collection->getSelect()->where('framecontract_contract_id='. intval(Mage::registry('contract_data')->getId()));
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('framecontract_transmit_id', array(
          'header'    => Mage::helper('framecontract')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'framecontract_transmit_id',
      ));

      $this->addColumn('owner', array(
          'header'    => Mage::helper('framecontract')->__('Owner'),
          'align'     =>'left',
          'index'     => 'owner',
      ));
      
     $this->addColumn('transmit_date', array(
          'header'    => Mage::helper('framecontract')->__('Date'),
          'align'     =>'left',
          'index'     => 'transmit_date',
      ));
      
     $this->addColumn('recipient', array(
          'header'    => Mage::helper('framecontract')->__('Recipient'),
          'align'     =>'left',
          'index'     => 'recipient',
      ));


	  
      return parent::_prepareColumns();
  }



}