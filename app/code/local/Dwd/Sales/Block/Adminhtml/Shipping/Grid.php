<?php

class Dwd_Sales_Block_Adminhtml_Shipping_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('shippingGrid');
      $this->setDefaultSort('shipping_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('sales/order_item')->getCollection();
      $collection->getSelect()
      	->join(array('sales'=>'sales_flat_order'),'sales.entity_id=main_table.order_id',array('order_increment_id'=>'increment_id','customer_company'=>'customer_company',
      			'shipping_address_id'=>'shipping_address_id','order_date'=>'created_at','customer_email'=>'customer_email','customer_lastname'=>'customer_lastname'))
      	->where("main_table.is_virtual = 0 AND qty_ordered > qty_shipped and sales.status='processing'")
      	->join(array('shipping_address'=>'sales_flat_order_address'),'shipping_address.entity_id=sales.shipping_address_id',array('shipping_firstname'=>'firstname','shipping_lastname'=>'lastname'))
		->columns('CONCAT(COALESCE(shipping_address.firstname, ""), " ", COALESCE(shipping_address.lastname, "")) as shipping_name')
		//->columns('CONCAT(shipping_address.company, " ",shipping_addresss.company2," ", shipping_address.company3) as shipping_company_full')
		->columns('CONCAT(COALESCE(shipping_address.street, ""), " ", COALESCE(shipping_address.city, "")," ", COALESCE(shipping_address.postcode, "")) as shipping_adr')   	
      	;
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('order_increment_id', array(
          'header'    => Mage::helper('dwdsales')->__('Order ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'order_increment_id',
      	 'filter_index' => 'sales.increment_id'
      ));

      $this->addColumn('order_date', array(
          'header'    => Mage::helper('dwdsales')->__('Order Date'),
          //'align'     =>'left',
          'type'	=>'date',
         'width'     => '80px',
          'index'     => 'order_date',
      	'filter_index' => 'sales.created_at'
      ));
      
      $this->addColumn('sku', array(
          'header'    => Mage::helper('dwdsales')->__('sku'),
          //'align'     =>'left',
         'width'     => '80px',
          'index'     => 'sku',
      ));
      
      $this->addColumn('name', array(
          'header'    => Mage::helper('dwdsales')->__('Product'),
          //'align'     =>'left',
         //'width'     => '100px',
          'index'     => 'name',
      ));
      
      $this->addColumn('qty_ordered', array(
          'header'    => Mage::helper('dwdsales')->__('Qty'),
          //'align'     =>'left',
         'width'     => '100px',
          'index'     => 'qty_ordered',

      ));
      
      $this->addColumn('customer_email', array(
          'header'    => Mage::helper('dwdsales')->__('Email'),
          //'align'     =>'left',
         'width'     => '100px',
          'index'     => 'customer_email',
      	'filter_index' => 'sales.customer_email',
      		'renderer'	=> 'dwdsales/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
      $this->addColumn('shipping_name', array(
          'header'    => Mage::helper('dwdsales')->__('Name'),
          //'align'     =>'left',
         'width'     => '100px',
          'index'     => 'shipping_name',
      	  'filter_condition_callback' => array($this, '_filterShippingNameCondition'),
      		'renderer'	=> 'dwdsales/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
      $this->addColumn('customer_company', array(
          'header'    => Mage::helper('dwdsales')->__('Company'),
          //'align'     =>'left',
         'width'     => '100px',
          'index'     => 'customer_company',
      	'filter_index' => 'sales.customer_company',
      		'renderer'	=> 'dwdsales/adminhtml_widget_grid_column_renderer_plaintext'
      ));

      $this->addColumn('shipping_adr', array(
          'header'    => Mage::helper('dwdsales')->__('Address'),
          //'align'     =>'left',
         'width'     => '200px',
         'index'     => 'shipping_adr',
      		'filter_condition_callback' => array($this, '_filterShippingAddressCondition'),
      		'renderer'	=> 'dwdsales/adminhtml_widget_grid_column_renderer_plaintext'
      ));
      
      
      
	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('sales')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */
/*
      $this->addColumn('status', array(
          'header'    => Mage::helper('sales')->__('Status'),
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
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('sales')->__('Action'),
                'width'     => '140',
                'type'      => 'action',
                'getter'    => 'getOrderId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('sales')->__('View Order'),
                        'url'       => array('base'=> 'adminhtml/sales_order/view'),
                        'field'     => 'order_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('sales')->__('XML'));
	  
      return parent::_prepareColumns();
  }

  
  /**
   * Filter fÃ¼r Titel
   *
   * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
   * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
   *
   * @return void
   */
  protected function _filterShippingNameCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}

  	$condition = 'CONCAT(COALESCE(shipping_address.firstname, ""), " ", COALESCE(shipping_address.lastname, "")) like ?';
  	$collection->getSelect()->where($condition, "%$value%");
  }
  
  /**
   * Filter fÃ¼r Titel
   *
   * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
   * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
   *
   * @return void
   */
  protected function _filterShippingAddressCondition($collection, $column) {
  	if (!$value = $column->getFilter()->getValue()) {
  		return;
  	}
  
  	$condition = 'CONCAT(COALESCE(shipping_address.street, ""), " ", COALESCE(shipping_address.city, ""), " ", COALESCE(shipping_address.postcode, "")) like ?';
  	$collection->getSelect()->where($condition, "%$value%");
  }
  
  

  public function xgetRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}