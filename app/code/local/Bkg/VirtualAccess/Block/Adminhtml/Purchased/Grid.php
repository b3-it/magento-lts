<?php

class Bkg_VirtualAccess_Block_Adminhtml_Purchased_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('credentialGrid');
      $this->setDefaultSort('credential_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('virtualaccess/purchased')->getCollection();
      $collection->getSelect()
       	->join(array('order'=>'sales_flat_order'),'order.entity_id = main_table.order_id',array('order_status'=>'status','customer_email'=>'customer_email','order_date'=>'created_at'))
      	->join(array('order_item'=>'sales_flat_order_item'),'order_item.item_id = main_table.order_item_id',array('name'=>'name'))
      	;
      //die($collection->getSelect()->__toString());
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	/*
      $this->addColumn('configurablevirtual_credential_id', array(
          'header'    => Mage::helper('virtualaccess')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'credential_id',
      ));
      */
      $this->addColumn('item_id', array(
          'header'    => Mage::helper('virtualaccess')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
      	  'type'	=> 'number',
          'index'     => 'id',
      	'filter_index' => 'main_table.id'
      ));
      
      $this->addColumn('oracle_acount_id', array(
      		'header'    => Mage::helper('virtualaccess')->__('External Account Id'),
      		'align'     =>'left',
      		'width' => '100',
      		'index'     => 'oracle_account_id',
      ));
     $this->addColumn('customer_id', array(
          'header'    => Mage::helper('virtualaccess')->__('Customer ID'),
          'align'     =>'right',
          'width'     => '50px',
      	  'type'	=> 'number',
          'index'     => 'customer_id',
     		'filter_index' => 'credential.customer_id'
      ));
      
      $this->addColumn('customer_email', array(
          'header'    => Mage::helper('virtualaccess')->__('Customer Email'),
             'width'     => '120px',
             'index'     => 'customer_email',
      ));
      
     $this->addColumn('order_date', array(
          'header'    => Mage::helper('virtualaccess')->__('Order Date'),
             'width'     => '80px',
     		'type'=>'date',
             'index'     => 'order_date',
     'filter_index'	=> 'order.created_at'
      ));
            
      
      $this->addColumn('order_increment_id', array(
          'header'    => Mage::helper('virtualaccess')->__('Order ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'order_increment_id',
      ));


/*
      
      $this->addColumn('created_at', array(
          'header'    => Mage::helper('virtualaccess')->__('Created At'),
          'align'     =>'left',
      	  'width' => '120',
      	  'type' => 'datetime',
          'index'     => 'created_at',
      	  'filter_index'     => 'main_table.created_at',
      ));
      
      $this->addColumn('updated_at', array(
          'header'    => Mage::helper('virtualaccess')->__('Updated At'),
          'align'     =>'left',
      	  'width'	  => '120',
      	  'type' 	  => 'datetime',
          'index'     => 'updated_at',
      	  'filter_index'     => 'main_table.updated_at',
      ));
      

*/      
     $this->addColumn('base_url', array(
          'header'    => Mage::helper('virtualaccess')->__('URL'),
          'align'     =>'left',
      	  'width' => '200',
          'index'     => 'base_url',
      ));
      
	  
     $this->addColumn('order_status', array(
            'header' => Mage::helper('virtualaccess')->__('Order Status'),
            'index' => 'order_status',
     		'filter_index' =>'order.status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));
     
     $this->addColumn('status', array(
     		'header' => Mage::helper('virtualaccess')->__('Status'),
     		'index' => 'status',
    		
     		'type'  => 'options',
     		'width' => '70px',
     		'options' =>Bkg_VirtualAccess_Model_Service_AccountStatus::getOptionArray()
     ));
     
     $this->addColumn('sync_status', array(
     		'header' => Mage::helper('virtualaccess')->__('Sync Status'),
     		'index' => 'sync_status',
     		
     		'type'  => 'options',
     		'width' => '70px',
     		'options' => Bkg_VirtualAccess_Model_Service_Syncstatus::getOptionArray()
     ));


	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('virtualaccess')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getOrderId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('virtualaccess')->__('Edit Order'),
                        'url'       => array('base'=> 'adminhtml/sales_order/view'),
                        'field'     => 'order_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
        
        $this->addColumn('action2',
        		array(
        				'header'    =>  Mage::helper('virtualaccess')->__('Action'),
        				'width'     => '100',
        				'type'      => 'action',
        				'getter'    => 'getId',
        				'actions'   => array(
        						array(
        								'caption'   => Mage::helper('virtualaccess')->__('Synchronice'),
        								'url'       => array('base'=> 'adminhtml/virtualaccess_purchased/sync'),
        								'field'     => 'id'
        						)
        				),
        				'filter'    => false,
        				'sortable'  => false,
        				'index'     => 'stores',
        				'is_system' => true,
        		));
      
		
		$this->addExportType('*/*/exportCsv', Mage::helper('virtualaccess')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('virtualaccess')->__('XML'));
	  
      return parent::_prepareColumns();
  }



  public function xgetRowUrl($row)
  {
      return $this->getUrl('*/*/show', array('id' => $row->getItemId()));
  }

}