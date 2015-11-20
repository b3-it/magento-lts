<?php
/**
 * Dwd Abo
 *
 *
 * @category   	Dwd
 * @package    	Dwd_Abo
 * @name       	Dwd_Abo_Block_Adminhtml_Abo_Grid
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Abo_Block_Adminhtml_Abo_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('aboGrid');
		$this->setDefaultSort('abo_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		 
		$exp = new Zend_Db_Expr('(SELECT increment_id from sales_flat_order where sales_flat_order.entity_id=main_table.first_order_id) as first_order_increment_id');
		 
		$collection = Mage::getModel('dwd_abo/abo')->getCollection();
		$collection->getSelect()
		->distinct()
		->columns($exp)
		->join(array('orderitem'=>'sales_flat_order_item'),'orderitem.item_id = main_table.current_orderitem_id')
		->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.current_order_id',array('order_increment_id'=>'increment_id'))
		//->join(array('first_order'=>'sales_flat_order'),'order.entity_id=main_table.first_order_id',array('first_order_increment_id'=>'increment_id'))
		->join(array('customer'=>'customer_entity'),'order.customer_id=customer.entity_id',array('email'=>'email'))
		->joinleft(array('stationen'=>'stationen_entity'),'stationen.entity_id=orderitem.station_id',array('stationskennung'=>'stationskennung'))
		->joinleft(array('icd'=>'icd_orderitem'),'icd.order_item_id=main_table.current_orderitem_id',array('icd_id'=>'id'))
		->joinleft(array('periode'=>'periode_periode'),'periode.entity_id=orderitem.period_id',array('periode'=>'label'))
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
		$this->addColumn('abo_id', array(
				'header'    => Mage::helper('dwd_abo')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'abo_id',
		));


		$this->addColumn('first_order_increment_id', array(
				'header'    => Mage::helper('dwd_abo')->__('Initial Order'),
				'align'     =>'left',
				'index'     => 'first_order_increment_id',
				'width'     => '150px',
				'filter_condition_callback' => array($this, '_filterFirstOrderIncrementIdCondition'),

				'link_index' => 'first_order_id',
				'link_param' =>'order_id',
				'link_url' => 'adminhtml/sales_order/view',
				'renderer' =>  'egovsbase/adminhtml_widget_grid_column_renderer_link',
		));

		/*
		 $this->addColumn('order_increment_id', array(
		 		'header'    => Mage::helper('dwd_abo')->__('Order'),
		 		'align'     =>'left',
		 		'index'     => 'order_increment_id',
		 		'width'     => '150px',
		 		'filter_index' => 'order.increment_id'
		 ));

		*/
		$this->addColumn('order_increment_id', array(
				'header'   => Mage::helper('dwd_abo')->__('Order'),

				'index'     => 'order_increment_id',
				'width'     => '150px',
				'filter_index' => 'order.increment_id',
				'link_index' => 'current_order_id',
				'link_param' =>'order_id',
				'link_url' => 'adminhtml/sales_order/view',
				'renderer' =>  'egovsbase/adminhtml_widget_grid_column_renderer_link',
		));


		$this->addColumn('email', array(
				'header'    => Mage::helper('dwd_abo')->__('Email'),
				'align'     =>'left',
				'index'     => 'email',
				'width'     => '150px',
		));


		$this->addColumn('sku', array(
				'header'    => Mage::helper('dwd_abo')->__('sku'),
				'align'     =>'left',
				'index'     => 'sku',
				'width'     => '150px',
		));

		$this->addColumn('name', array(
				'header'    => Mage::helper('dwd_abo')->__('Product'),
				'align'     =>'left',
				'index'     => 'name',
				'width'     => '150px',
		));


		$this->addColumn('stationskennung', array(
				'header'    => Mage::helper('dwd_abo')->__('Station'),
				'align'     =>'left',
				'index'     => 'stationskennung',
				'width'     => '150px',
		));
		
		$this->addColumn('periode', array(
				'header'    => Mage::helper('dwd_abo')->__('Periode'),
				'align'     =>'left',
				'index'     => 'periode',
				'width'     => '150px',
				'filter_index' => 'periode.label'
		));

		$this->addColumn('start_date', array(
				'header'    => Mage::helper('dwd_abo')->__('Start Date'),
				'align'     =>'left',
				'index'     => 'start_date',
				'width'     => '150px',
				'type'		=> 'date'
		));


		$this->addColumn('stop_date', array(
				'header'    => Mage::helper('dwd_abo')->__('End Date'),
				'align'     =>'left',
				'index'     => 'stop_date',
				'width'     => '150px',
				'type' => 'date'
		));

		$this->addColumn('cancelation_period_end', array(
				'header'    => Mage::helper('dwd_abo')->__('Cancelation Periode End'),
				'align'     =>'left',
				'index'     => 'cancelation_period_end',
				'width'     => '150px',
				'type' => 'date'
		));

		$statuses = Mage::getSingleton('dwd_abo/status')->getOptionArray();
		$this->addColumn('status', array(
				'header'    => Mage::helper('dwd_abo')->__('Status'),
				'align'     => 'left',
				'width'     => '80px',
				'index'     => 'status',
				'filter_index' => 'main_table.status',
				'type'      => 'options',
				'options'   => $statuses

		));

		$statuses = Mage::getSingleton('dwd_abo/renewalstatus')->getOptionArray();
		$this->addColumn('renewal_status', array(
				'header'    => Mage::helper('dwd_abo')->__('Renewal Status'),
				'align'     => 'left',
				'width'     => '80px',
				'index'     => 'renewal_status',
				'type'      => 'options',
				'options'   => $statuses

		));

		$this->addColumn('action',
				array(
						'header'    =>  Mage::helper('dwd_abo')->__('Action'),
						'width'     => '100',
						'type'      => 'action',
						'getter'    => 'getId',
						'actions'   => array(
								array(
										'caption'   => Mage::helper('dwd_abo')->__('Edit'),
										'url'       => array('base'=> '*/*/edit'),
										'field'     => 'id'
								),
								 
						),
						'filter'    => false,
						'sortable'  => false,
						'index'     => 'stores',
						'is_system' => true,
				));

		$this->addColumn('action1',
				array(
						'header'    =>  Mage::helper('dwd_abo')->__('Action'),
						'width'     => '100',
						'type'      => 'action',
						'getter'    => 'getIcdId',
						'actions'   => array(

								array(
										'caption'   => Mage::helper('dwd_abo')->__('Change Station'),
										'url'       => array('base'=> 'adminhtml/icd_orderitem/edit','params'=>array('back_url'=>'abo')),
										'field'     => 'id'
								)
						),
						'filter'    => false,
						'sortable'  => false,
						'index'     => 'stores',
						'is_system' => true,
				));

		$this->addExportType('*/*/exportCsv', Mage::helper('dwd_abo')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('dwd_abo')->__('XML'));
		 
		return parent::_prepareColumns();
	}

	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('abo_id');
		$this->getMassactionBlock()->setFormFieldName('dwd_abo');


		$statuses = Mage::getSingleton('dwd_abo/status')->getOptionArray();

		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
				'label'=> Mage::helper('dwd_abo')->__('Change status'),
				'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
				'additional' => array(
						'visibility' => array(
								'name' => 'status',
								'type' => 'select',
								'class' => 'required-entry',
								'label' => Mage::helper('dwd_abo')->__('Status'),
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