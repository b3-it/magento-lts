<?php
/**
 * Sid ExportOrder
 *
 *
 * @category   	Sid
 * @package    	Sid_ExportOrder
 * @name       	Sid_ExportOrder_Block_Adminhtml_Export_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Block_Adminhtml_Export_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('exportGrid');
      $this->setDefaultSort('export_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  /**
   * Retrieve collection class
   *
   * @return string
   */
  protected function _getCollectionClass()
  {
  	return 'sales/order_grid_collection';
  }
  
  protected function _prepareCollection()
  {
  	$collection = Mage::getResourceModel($this->_getCollectionClass());
  	$collection->getSelect()
  		->joinleft(array('export'=>$collection->getTable('exportorder/order')),'main_table.entity_id = export.order_id',array('export_status'=>'status','message'))
  		->columns(new Zend_Db_Expr(" (CASE main_table.status WHEN 'closed' THEN 2 WHEN 'canceled' THEN 2 ELSE 1 END)  as order_numstatus"))
  	;
//die($collection->getSelect()->__toString());  		
  	$this->setCollection($collection);
  	return parent::_prepareCollection();
  }
  
  protected function _prepareColumns()
  {
  
  	$this->addColumn('real_order_id', array(
  			'header'=> Mage::helper('sales')->__('Order #'),
  			'width' => '80px',
  			'type'  => 'text',
  			'index' => 'increment_id',
  	));
  
  	if (!Mage::app()->isSingleStoreMode()) {
  		$this->addColumn('store_id', array(
  				'header'    => Mage::helper('sales')->__('Purchased From (Store)'),
  				'index'     => 'store_id',
  				'type'      => 'store',
  				'store_view'=> true,
  				'display_deleted' => true,
  		));
  	}
  
  	$this->addColumn('created_at', array(
  			'header' => Mage::helper('sales')->__('Purchased On'),
  			'index' => 'created_at',
  			'type' => 'datetime',
  			'width' => '100px',
  	));
  
  	$this->addColumn('billing_name', array(
  			'header' => Mage::helper('sales')->__('Bill to Name'),
  			'index' => 'billing_name',
  	));
  

  	$this->addColumn('base_grand_total', array(
  			'header' => Mage::helper('sales')->__('G.T. (Base)'),
  			'index' => 'base_grand_total',
  			'type'  => 'currency',
  			'currency' => 'base_currency_code',
  	));
  
 
  
  	$this->addColumn('status', array(
  			'header' => Mage::helper('sales')->__('Order Status'),
  			'index' => 'status',
  			'type'  => 'options',
  			'width' => '70px',
  			'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
  			'filter_index' => 'main_table.status'
  			
  	));
  	
  	$this->addColumn('export_status', array(
  			'header' => Mage::helper('sales')->__('Export Status'),
  			'index' => 'export_status',
  			'type'  => 'options',
  			'width' => '70px',
  			'options' =>Sid_ExportOrder_Model_Syncstatus::getOptionArray(),
  			'filter_index' => 'export.status'
  	));
  	
  	$this->addColumn('message', array(
  			'header' => Mage::helper('sales')->__('Message'),
  			'index' => 'message',
  	));
  	
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('exportorder')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('exportorder')->__('Details'),
                        'url'       => array('base'=> '*/*/show'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        
        $this->addColumn('action1',
        		array(
        				'header'    =>  Mage::helper('exportorder')->__('Action'),
        				'width'     => '100',
        				'type'      => 'action',
        				'getter'    => 'getId',
        				'actions'   => array(
        						array(
        								'caption'   => Mage::helper('exportorder')->__('Download'),
        								'url'       => array('base'=> '*/*/download'),
        								'field'     => 'id'
        						)
        				),
        				'filter'    => false,
        				'sortable'  => false,
        				'index'     => 'stores',
        				'is_system' => true,
        		));
        $this->addColumn('action2',
        		array(
        				'header'    =>  Mage::helper('exportorder')->__('Action'),
        				'width'     => '100',
        				'type'      => 'action',
        				'renderer' => "sid_exportorder/adminhtml_grid_action",
        				'getter'    => 'getId',
        				'actions'   => array(
        						array(
        								'caption'   => Mage::helper('exportorder')->__('Resend'),
        								'url'       => '#',// array('base'=> '*/*/resend'),
        								'field'     => 'id',
        								'onclick' => 'resend($entity_id);'
        						)
        				),
        				'filter'    => false,
        				'status'	=> 'order_numstatus',
        				'hide_on'	=> 2,
        				'sortable'  => false,
        				'index'     => 'stores',
        				'is_system' => true,
        		));

		//$this->addExportType('*/*/exportCsv', Mage::helper('exportorder')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('exportorder')->__('XML'));

      return parent::_prepareColumns();
  }

  public function _toHtml()
  {
  
  	$html = array();
  	$html[]= "<script type=\"text/javascript\">";
  	$html[]= "function resend(id){";
  	$html[]= 'var url = "'.$this->getUrl('*/*/resend',array('id' => 'xxx')).'";';
  	$html[]= "url = url.replace('xxx',id);";
  	$html[]= "new Ajax.Request(url, {method:'get', onSuccess: function(transport) {";
    $html[]= "$('messages').update(transport.responseText);";
    //$html[]= "alert(transport.responseText);";
  	$html[]= "}})";
  	$html[]= "}";
  	$html[]= "</script>";
  
  
  	return parent::_toHtml(). implode(' ',$html);
  
  
  }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/show', array('id' => $row->getId()));
  }

}
