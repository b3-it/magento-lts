<?php

class Dwd_ConfigurableVirtual_Block_Adminhtml_Credential_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
      $collection = Mage::getModel('configvirtual/purchased_item')->getCollection();
      $collection->getSelect()
      	->join(array('credential'=>'configvirtual_purchased_credential'),'main_table.credential_id=credential.credential_id',array('customer_id','username','password','credential_id'))
      	->joinleft(array('stationen'=>'stationen_entity'),'main_table.station_id = stationen.entity_id',array('stationskennung','st_update'=>'updated_at'))
      	->join(array('purchased'=>'configvirtual_purchased'),'main_table.purchased_id = purchased.purchased_id',array('order_id','order_increment_id'))
      	->join(array('order'=>'sales_flat_order'),'order.entity_id = purchased.order_id',array('order_status'=>'status','customer_email'=>'customer_email','order_date'=>'created_at'))
      	->join(array('order_item'=>'sales_flat_order_item'),'order_item.item_id = main_table.order_item_id',array('period_start','period_end'))
      	;
      //die($collection->getSelect()->__toString());
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	/*
      $this->addColumn('configurablevirtual_credential_id', array(
          'header'    => Mage::helper('configvirtual')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'credential_id',
      ));
      */
      $this->addColumn('item_id', array(
          'header'    => Mage::helper('configvirtual')->__('Item ID'),
          'align'     =>'right',
          'width'     => '50px',
      	  'type'	=> 'number',
          'index'     => 'item_id',
      	'filter_index' => 'main_table.item_id'
      ));
      
     $this->addColumn('customer_id', array(
          'header'    => Mage::helper('configvirtual')->__('Customer ID'),
          'align'     =>'right',
          'width'     => '50px',
      	  'type'	=> 'number',
          'index'     => 'customer_id',
     		'filter_index' => 'credential.customer_id'
      ));
      
      $this->addColumn('customer_email', array(
          'header'    => Mage::helper('configvirtual')->__('Customer Email'),
             'width'     => '120px',
             'index'     => 'customer_email',
      ));
      
     $this->addColumn('order_date', array(
          'header'    => Mage::helper('configvirtual')->__('Order Date'),
             'width'     => '80px',
     		'type'=>'date',
             'index'     => 'order_date',
     'filter_index'	=> 'order.created_at'
      ));
            
      
      $this->addColumn('order_increment_id', array(
          'header'    => Mage::helper('configvirtual')->__('Order ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'order_increment_id',
      ));

      $this->addColumn('username', array(
          'header'    => Mage::helper('configvirtual')->__('User Name'),
          'align'     =>'left',
          'index'     => 'username',
      ));
      
      $this->addColumn('password', array(
          'header'    => Mage::helper('configvirtual')->__('Password'),
          'align'     =>'left',
      	  'width' => '120',
          'index'     => 'password',
      ));
      
      $this->addColumn('created_at', array(
          'header'    => Mage::helper('configvirtual')->__('Created At'),
          'align'     =>'left',
      	  'width' => '120',
      	  'type' => 'datetime',
          'index'     => 'created_at',
      	  'filter_index'     => 'main_table.created_at',
      ));
      
      $this->addColumn('updated_at', array(
          'header'    => Mage::helper('configvirtual')->__('Updated At'),
          'align'     =>'left',
      	  'width'	  => '120',
      	  'type' 	  => 'datetime',
          'index'     => 'updated_at',
      	  'filter_index'     => 'main_table.updated_at',
      ));
      
     $this->addColumn('stationskennung', array(
          'header'    => Mage::helper('configvirtual')->__('Station'),
          'align'     =>'left',
      	  'width' => '120',
          'index'     => 'stationskennung',
      ));
      
     $this->addColumn('external_link_url', array(
          'header'    => Mage::helper('configvirtual')->__('URL'),
          'align'     =>'left',
      	  'width' => '200',
          'index'     => 'external_link_url',
      ));
      
	  
     $this->addColumn('order_status', array(
            'header' => Mage::helper('configvirtual')->__('Order Status'),
            'index' => 'order_status',
     		'filter_index' =>'order.status',
            'type'  => 'options',
            'width' => '70px',
            'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
        ));
        
        
        
      $this->addColumn('period_start', array(
          'header'    => Mage::helper('configvirtual')->__('Period Start'),
          'align'     =>'left',
      	  'width'	  => '120',
      	  'type' 	  => 'datetime',
          'index'     => 'period_start',
      ));
      
      $this->addColumn('period_end', array(
          'header'    => Mage::helper('configvirtual')->__('Period End'),
          'align'     =>'left',
      	  'width'	  => '120',
      	  'type' 	  => 'datetime',
          'index'     => 'period_end',
      ));
        
      
     $this->addColumn('st_update', array(
          'header'    => Mage::helper('configvirtual')->__('Station Update'),
          'align'     =>'left',
      	  'width'	  => '120',
      	  'type' 	  => 'datetime',
          'index'     => 'st_update',
     	  'filter_index' =>'stationen.updated_at',
      ));
/*
      $this->addColumn('status', array(
          'header'    => Mage::helper('configvirtual')->__('Status'),
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
      $this->addColumn('category_id', array(
          'header'    => Mage::helper('configvirtual')->__('Category'),
          'align'     =>'left',
      	  'width'     => '200px',
	 	  'type'	  => 'options',
	 	  'options'   => Mage::helper('stationen')->getCategoriesAsOptionValueArray(),
          'index'     => 'category_id',
      ));
      
     
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('configvirtual')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getOrderId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('configvirtual')->__('Edit Order'),
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
                'header'    =>  Mage::helper('configvirtual')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getCredentialId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('configvirtual')->__('Edit Credential'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('configvirtual')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('configvirtual')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function x_prepareMassaction()
    {
        $this->setMassactionIdField('credential_id');
        $this->getMassactionBlock()->setFormFieldName('credential');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('configvirtual')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('configvirtual')->__('Are you sure?')
        ));

        
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getCredentialId()));
  }

}