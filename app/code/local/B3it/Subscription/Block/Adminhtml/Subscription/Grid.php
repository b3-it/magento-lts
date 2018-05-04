<?php
/**
 * B3it Subscription
 *
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Block_Adminhtml_Subscription_Grid
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 2014 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Block_Adminhtml_Subscription_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('subscriptionGrid');
		$this->setDefaultSort('id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		 
		$exp = new Zend_Db_Expr('(SELECT increment_id from sales_flat_order where sales_flat_order.entity_id=main_table.first_order_id) as first_order_increment_id');
		 
		$collection = Mage::getModel('b3it_subscription/subscription')->getCollection();
		$collection->getSelect()
		->distinct()
		->columns($exp)
		->join(array('orderitem'=>'sales_flat_order_item'),'orderitem.item_id = main_table.current_orderitem_id')
		->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.current_order_id',array('order_increment_id'=>'increment_id'))
		//->join(array('first_order'=>'sales_flat_order'),'order.entity_id=main_table.first_order_id',array('first_order_increment_id'=>'increment_id'))
		->join(array('customer'=>'customer_entity'),'order.customer_id=customer.entity_id',array('email'=>'email'))
		
		;

		//die($collection->getSelect()->__toString());
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	/**
	 * FilterIndex
	 *
	 * @param Mage_Core_Model_Resource_Db_Collection_Abstract $collection Collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column         $column     Column
	 *
	 * @return void
	 */
	protected function _filterFirstOrderIncrementIdCondition($collection, $column) {
		if (!$value = $column->getFilter()->getValue()) {
			return;
		}
		$table = $collection->getTable("sales/order");
		$condition = "(SELECT increment_id from $table where $table.entity_id=main_table.first_order_id) like ?";
		$collection->getSelect()->where($condition, "%$value%");
	}

	protected function _prepareColumns()
	{
		$this->addColumn('id', array(
				'header'    => Mage::helper('b3it_subscription')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'id',
		));


		$this->addColumn('first_order_increment_id', array(
				'header'    => Mage::helper('b3it_subscription')->__('Initial Order'),
				'align'     =>'left',
				'index'     => 'first_order_increment_id',
				'width'     => '150px',
				'filter_condition_callback' => array($this, '_filterFirstOrderIncrementIdCondition'),

				'link_index' => 'first_order_id',
				'link_param' =>'order_id',
				'link_url' => 'adminhtml/sales_order/view',
				'renderer' =>  'egovsbase/adminhtml_widget_grid_column_renderer_link',
		));


		$this->addColumn('order_increment_id', array(
				'header'   => Mage::helper('b3it_subscription')->__('Order'),

				'index'     => 'order_increment_id',
				'width'     => '150px',
				'filter_index' => 'order.increment_id',
				'link_index' => 'current_order_id',
				'link_param' =>'order_id',
				'link_url' => 'adminhtml/sales_order/view',
				'renderer' =>  'egovsbase/adminhtml_widget_grid_column_renderer_link',
		));


		$this->addColumn('email', array(
				'header'    => Mage::helper('b3it_subscription')->__('Email'),
				'align'     =>'left',
				'index'     => 'email',
				'width'     => '150px',
		));


		$this->addColumn('sku', array(
				'header'    => Mage::helper('b3it_subscription')->__('sku'),
				'align'     =>'left',
				'index'     => 'sku',
				'width'     => '150px',
		));

		$this->addColumn('name', array(
				'header'    => Mage::helper('b3it_subscription')->__('Product'),
				'align'     =>'left',
				'index'     => 'name',
				'width'     => '150px',
		));


		

		$this->addColumn('start_date', array(
				'header'    => Mage::helper('b3it_subscription')->__('Start Date'),
				'align'     =>'left',
				'index'     => 'start_date',
				'width'     => '150px',
				'type'		=> 'date'
		));


		$this->addColumn('stop_date', array(
				'header'    => Mage::helper('b3it_subscription')->__('End Date'),
				'align'     =>'left',
				'index'     => 'stop_date',
				'width'     => '150px',
				'type' => 'date'
		));

		$this->addColumn('renewal_date', array(
				'header'    => Mage::helper('b3it_subscription')->__('Renewal Date'),
				'align'     =>'left',
				'index'     => 'renewal_date',
				'width'     => '150px',
				'type' => 'date'
		));

		$statuses = Mage::getSingleton('b3it_subscription/status')->getOptionArray();
		$this->addColumn('status', array(
				'header'    => Mage::helper('b3it_subscription')->__('Status'),
				'align'     => 'left',
				'width'     => '80px',
				'index'     => 'status',
				'filter_index' => 'main_table.status',
				'type'      => 'options',
				'options'   => $statuses

		));

		$statuses = Mage::getSingleton('b3it_subscription/renewalstatus')->getOptionArray();
		$this->addColumn('renewal_status', array(
				'header'    => Mage::helper('b3it_subscription')->__('Renewal Status'),
				'align'     => 'left',
				'width'     => '80px',
				'index'     => 'renewal_status',
				'type'      => 'options',
				'options'   => $statuses

		));

		$this->addColumn('action',
				array(
						'header'    =>  Mage::helper('b3it_subscription')->__('Action'),
						'width'     => '100',
						'type'      => 'action',
						'getter'    => 'getId',
						'actions'   => array(
								array(
										'caption'   => Mage::helper('b3it_subscription')->__('Edit'),
										'url'       => array('base'=> '*/*/edit'),
										'field'     => 'id'
								),
								 
						),
						'filter'    => false,
						'sortable'  => false,
						'index'     => 'stores',
						'is_system' => true,
				));

		
		$this->addExportType('*/*/exportCsv', Mage::helper('b3it_subscription')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('b3it_subscription')->__('XML'));
		 
		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('subscription_id');
		$this->getMassactionBlock()->setFormFieldName('b3it_subscription');


		$statuses = Mage::getSingleton('b3it_subscription/status')->getOptionArray();

		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
				'label'=> Mage::helper('b3it_subscription')->__('Change status'),
				'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
				'additional' => array(
						'visibility' => array(
								'name' => 'status',
								'type' => 'select',
								'class' => 'required-entry',
								'label' => Mage::helper('b3it_subscription')->__('Status'),
								'values' => $statuses
						)
				)
		));
		return $this;
	}

	public function getRowUrl($row)
	{
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}

}