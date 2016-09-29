<?php

class Sid_ExportOrder_Block_Adminhtml_Export_Edit_Tab_Export extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('transmitGrid');
      $this->setDefaultSort('transmit_date');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
      $this->setUseAjax(true);
      //$this->_headersVisibility = false;
      
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('exportorder/order')->getCollection();
      $collection->getSelect()
      	->where('order_id ='. intval(Mage::registry('order')->getId()));
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('message', array(
          'header'    => Mage::helper('exportorder')->__('Message'),
          'align'     =>'right',
          //'width'     => '50px',
          'index'     => 'message',
      ));
 
    
      
      $this->addColumn('update_at', array(
      		'header'    => Mage::helper('exportorder')->__('Verarbeitet'),
      		'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'update_at',
      		'type' 		=> 'datetime'
      ));

      $this->addColumn('export_status', array(
      		'header' => Mage::helper('sales')->__('Export Status'),
      		'index' => 'status',
      		'type'  => 'options',
      		'width' => '70px',
      		'options' =>Sid_ExportOrder_Model_Syncstatus::getOptionArray(),
      		'filter_index' => 'status'
      ));
      
	  
      return parent::_prepareColumns();
  }


}