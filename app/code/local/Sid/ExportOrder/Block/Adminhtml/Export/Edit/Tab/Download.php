<?php

class Sid_ExportOrder_Block_Adminhtml_Export_Edit_Tab_Download extends Mage_Adminhtml_Block_Widget_Grid
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
    
  	 $collection = Mage::getModel('exportorder/link')->getCollection();
  	 $table = $collection->getTable('exportorder/link_order');
      $collection->getSelect()
      	->join(array('orders' => $collection->getTable('exportorder/link_order') ),'orders.link_id = main_table.id')
      	->where('order_id ='. intval(Mage::registry('order')->getId()));
      $this->setCollection($collection);
      
      return parent::_prepareCollection();
  }

  protected function _afterLoadCollection()
  {
  	foreach($this->getCollection() as $item)
  	{
  		$item->setUrl($item->getUrl());
  	}
  	
  	return parent::_afterLoadCollection();
  }
  
  protected function _prepareColumns()
  {
      $this->addColumn('send_filename', array(
          'header'    => Mage::helper('exportorder')->__('Datei'),
          //'align'     =>'right',
          'width'     => '250px',
          'index'     => 'send_filename',
      ));
      
      $this->addColumn('download', array(
      		'header'    => Mage::helper('exportorder')->__('Downloads'),
      		'align'     =>'right',
      		'width'     => '50px',
      		'index'     => 'download',
      ));
      
      $this->addColumn('url', array(
      		'header'    => Mage::helper('exportorder')->__('Link'),
      		//'align'     =>'right',
      		//'width'     => '150px',
      		'index'     => 'url',
      ));

    
      
      $this->addColumn('download_time', array(
      		'header'    => Mage::helper('exportorder')->__('Download Time'),
      		'align'     =>'right',
      		'width'     => '80px',
      		'index'     => 'download_time',
      		'type'		=> 'datetime'
      ));

     
	  
      return parent::_prepareColumns();
  }


}