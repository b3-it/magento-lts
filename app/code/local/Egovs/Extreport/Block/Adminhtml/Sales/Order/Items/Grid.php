<?php
/**
 * Tax
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 - 2015 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Order_Items_Grid extends Mage_Adminhtml_Block_Widget_Grid
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
				'billing_address_id'=>'billing_address_id','order_date'=>'created_at','customer_email'=>'customer_email','customer_lastname'=>'customer_lastname','order_status'=>'status'))
				->join(array('billing_address'=>'sales_flat_order_address'),'billing_address.entity_id=sales.billing_address_id',array('billing_firstname'=>'firstname','billing_lastname'=>'lastname'))
				->columns('CONCAT(COALESCE(billing_address.firstname, ""), " ", COALESCE(billing_address.lastname, "")) as billing_name')
				//->columns('CONCAT(billing_address.company, " ",billing_addresss.company2," ", billing_address.company3) as shipping_company_full')
		->columns('CONCAT(COALESCE(billing_address.street, ""), " ", COALESCE(billing_address.city, "")," ", COALESCE(billing_address.postcode, "")) as shipping_adr')
		;
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}
	
	protected function _prepareColumns()
	{
		$this->addColumn('order_increment_id', array(
				'header'    => Mage::helper('extreport')->__('Order ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'order_increment_id',
				'filter_index' => 'sales.increment_id'
		));
	
		$this->addColumn('order_date', array(
				'header'    => Mage::helper('extreport')->__('Order Date'),
				//'align'     =>'left',
				'type'	=>'date',
				'width'     => '80px',
				'index'     => 'order_date',
				'filter_index' => 'sales.created_at'
		));
	
		$this->addColumn('sku', array(
				'header'    => Mage::helper('extreport')->__('sku'),
				//'align'     =>'left',
				'width'     => '80px',
				'index'     => 'sku',
		));
	
		$this->addColumn('name', array(
				'header'    => Mage::helper('extreport')->__('Product'),
				//'align'     =>'left',
				//'width'     => '100px',
				'index'     => 'name',
		));
	
		$this->addColumn('qty_ordered', array(
				'header'    => Mage::helper('extreport')->__('Qty'),
				//'align'     =>'left',
				'width'     => '100px',
				'index'     => 'qty_ordered',
	
		));
	
		$this->addColumn('customer_email', array(
				'header'    => Mage::helper('extreport')->__('Email'),
				//'align'     =>'left',
				'width'     => '100px',
				'index'     => 'customer_email',
				'filter_index' => 'sales.customer_email',
				'renderer'	=> 'extreport/widget_grid_column_renderer_plaintext'
		));
	
		$this->addColumn('billing_name', array(
				'header'    => Mage::helper('extreport')->__('Name'),
				//'align'     =>'left',
				'width'     => '100px',
				'index'     => 'billing_name',
				'filter_condition_callback' => array($this, '_filterShippingNameCondition'),
				'renderer'	=> 'extreport/widget_grid_column_renderer_plaintext'
		));
	
		$this->addColumn('customer_company', array(
				'header'    => Mage::helper('extreport')->__('Company'),
				//'align'     =>'left',
				'width'     => '100px',
				'index'     => 'customer_company',
				'filter_index' => 'sales.customer_company',
				'renderer'	=> 'extreport/widget_grid_column_renderer_plaintext'
		));
	
		$this->addColumn('shipping_adr', array(
				'header'    => Mage::helper('extreport')->__('Billing Address'),
				//'align'     =>'left',
				'width'     => '200px',
				'index'     => 'shipping_adr',
				'filter_condition_callback' => array($this, '_filterShippingAddressCondition'),
				'renderer'	=> 'extreport/widget_grid_column_renderer_plaintext'
		));
	
		$this->addColumn('order_status', array(
				'header' => Mage::helper('sales')->__('Status'),
				'index' => 'order_status',
				'type'  => 'options',
				'width' => '70px',
				'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
				'filter_condition_callback' => array($this, '_filterStatusCondition'),
		));
		
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
	
		$condition = 'CONCAT(COALESCE(billing_address.firstname, ""), " ", COALESCE(billing_address.lastname, "")) like ?';
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
	
		$condition = 'CONCAT(COALESCE(billing_address.street, ""), " ", COALESCE(billing_address.city, ""), " ", COALESCE(billing_address.postcode, "")) like ?';
		$collection->getSelect()->where($condition, "%$value%");
	}
	
	/**
	 * Filter für Status
	 *
	 * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
	 *
	 * @return void
	 */
	protected function _filterStatusCondition($collection, $column) {
		if (!$value = $column->getFilter()->getValue()) {
			return;
		}
	
		$condition = '(sales.status=?)';
		$collection->getSelect()->where($condition, $value);
	}
	
	
	

	
}
