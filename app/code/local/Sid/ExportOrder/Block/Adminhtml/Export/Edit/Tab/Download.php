<?php

class Sid_ExportOrder_Block_Adminhtml_Export_Edit_Tab_Download extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('downloadGrid');
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
      	->join(array('orders' => $collection->getTable('exportorder/link_order') ),'orders.link_id = main_table.id',array('link_id'=>'link_id'))
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
      
      $this->addColumn('link_status', array(
      		'header' => Mage::helper('sales')->__('Link Status'),
      		'index' => 'link_status',
      		'type'  => 'options',
      		'width' => '70px',
      		'options' =>Sid_ExportOrder_Model_Linkstatus::getOptionArray(),
      		'filter_index' => 'status'
      ));

      $order = Mage::registry('order');
//       $this->addColumn('action',
//       		array(
//       				'header'    =>  Mage::helper('exportorder')->__('Action'),
//       				'width'     => '100',
//       				'type'      => 'action',
//       				'getter'    => 'getLinkId',
//       				'actions'   => array(
//       						array(
//       								'caption'   => Mage::helper('exportorder')->__('Delete'),
//       								//'url'       => array('base'=> '*/*/deleteLink','params'=>array('id' => $order->getId())),
//       								'field'     => 'linkid',
//       								'onclick'   => 'deleteLink($link_id)',
//       						)
//       				),
//       				'filter'    => false,
//       				'sortable'  => false,
//       				'index'     => 'stores',
//       				'is_system' => true,
//       		));
      
      $this->addColumn('action1', 
      		array(
	      		'header'    => Mage::helper('exportorder')->__('Action'),
	      		'renderer' => "sid_exportorder/adminhtml_grid_action",
	      		'getter'    => 'getLinkId',
	      				'actions'   => array(
	      						array(
	      								'caption'   => Mage::helper('exportorder')->__('Delete'),
	      								//'url'       => array('base'=> '*/*/deleteLink','params'=>array('id' => $order->getId())),
	      								'field'     => 'linkid',
	      								'onclick'   => 'deleteLink($link_id)',
	      						)
	      				),
      					'status'	=> 'link_status',
      					'hide_on'	=> Sid_ExportOrder_Model_Linkstatus::STATUS_DISABLED,
	      				'filter'    => false,
	      				'sortable'  => false,
	      				'index'     => 'stores',
	      				'is_system' => true,
      		));

      return parent::_prepareColumns();
  }

  public function getGridUrl($params = array())
  {
  	if (!isset($params['_current'])) {
  		$params['_current'] = true;
  	}
  	return $this->getUrl('*/*/downloadgrid', $params);
  }
  
  public function _toHtml()
  {
  		
  		$html = array();
  		$html[]= "<script>";
  		$html[]= "function deleteLink(id){";
  		$html[]= 'var url = "'.$this->getUrl('*/*/deleteLink',array('id' => intval(Mage::registry('order')->getId()),'linkid'=>'xxx')).'";';  		
  		$html[]= "url = url.replace('xxx',id);";
  		$html[]= $this->getJsObjectName().".reload(url)";
  		$html[]= "}";
  		$html[]= "</script>";
  		
  		
  		return parent::_toHtml(). implode(' ',$html);
  		
  		
  }
}