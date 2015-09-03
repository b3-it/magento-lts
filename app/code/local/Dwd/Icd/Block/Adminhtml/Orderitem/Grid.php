<?php
/**
 * Dwd Icd
 *
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Orderitem_Grid
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2013 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Orderitem_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct()
	{
		parent::__construct();
		$this->setId('orderitemGrid');
		$this->setDefaultSort('orderitem_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection()
	{
		$collection = Mage::getModel('dwd_icd/orderitem')->getCollection();
		$collection
		->getSelect()
		->joinleft(array('stationen'=>'stationen_entity'),'stationen.entity_id=station_id','stationskennung')
		->joinleft(array('account'=>'icd_account'),'account.id=account_id',array('login'=>'login','account_sync_status'=>'sync_status','customer_id'=>'customer_id'))
		->joinleft(array('customer'=>'customer_entity'),'customer.entity_id=customer_id',array('email'=>'email'))
		->joinleft(array('oitem'=>'sales_flat_order_item'),'oitem.item_id=order_item_id','sku')
		->join(array('order'=>'sales_flat_order'),'order.entity_id=main_table.order_id',
				array('order_increment_id'=>'increment_id','order_date'=>'created_at','bestellstatus'=>'status'));
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	protected function _prepareColumns()
	{
		$this->addColumn('id', array(
				'header'    => Mage::helper('dwd_icd')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'id',
				'filter_index' =>'main_table.id'
		));

		$this->addColumn('customer_id', array(
				'header'    => Mage::helper('dwd_icd')->__('Customer Id'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'customer_id',
				'filter_index' =>'account.customer_id'
		));




		$this->addColumn('order_increment_id', array(
				'header'    => Mage::helper('dwd_icd')->__('Order'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'order_increment_id',
				'filter_index' =>'order.increment_id',
				
				'link_index' => 'order_id',
      			'link_param' =>'order_id',
      			'link_url' 	=> 'adminhtml/sales_order/view',
      			'renderer' 	=>  'egovsbase/adminhtml_widget_grid_column_renderer_link',
				
				
		));

		$this->addColumn('order_date', array(
				'header'    => Mage::helper('dwd_icd')->__('Order Date'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'order_date',
				'type'		=> 'datetime',
      			'gmtoffset' => true,
				'filter_index' =>'order.created_at'
		));


		$this->addColumn('bestellstatus',
				array(
						'header'=> Mage::helper('catalog')->__('Order Status'),
						'width' => '80px',
						'index' => 'bestellstatus',
						'type'  => 'options',
						//'renderer' => 'adminhtml/widget_grid_column_renderer_text',
						'options' => Mage::getSingleton('sales/order_config')->getStatuses(),
						'filter_index' => 'order.status'
				));

		$this->addColumn('sku', array(
				'header'    => Mage::helper('dwd_icd')->__('Sku'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'sku',
		));

		//$stationen = Mage::getModel('stationen/stationen')->getCollection()->getOptionArray();
		$this->addColumn('stationskennung', array(
				'header'    => Mage::helper('dwd_icd')->__('Station'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'stationskennung',
				//'type'		=> 'options',
				//'options'   => $stationen
		));

		$app = (Mage::getSingleton('dwd_icd/source_attribute_applications')->getOptionArray());
		$this->addColumn('application', array(
				'header'    => Mage::helper('dwd_icd')->__('Application'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'application',
				'type'		=> 'options',
				'options'	=> $app
		));

		$this->addColumn('application_url', array(
				'header'    => Mage::helper('dwd_icd')->__('Application URL'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'application_url',
		));

		$this->addColumn('email', array(
				'header'    => Mage::helper('dwd_icd')->__('E-Mail'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'email',
		));

		$this->addColumn('login', array(
				'header'    => Mage::helper('dwd_icd')->__('Login Name'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'login',
		));

		$dateFormatIso = Mage::app()->getLocale()->getDateTimeFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
		$this->addColumn('start_time', array(
				'header'    => Mage::helper('dwd_icd')->__('Start Time'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'start_time',
				'type'		=> 'datetime',
				'gmtoffset' => true,
				'format'	=> $dateFormatIso
		));

		$this->addColumn('end_time', array(
				'header'    => Mage::helper('dwd_icd')->__('End Time'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'end_time',
				'type'		=> 'datetime',
				'gmtoffset' => true,
				'format'	=> $dateFormatIso
		));

		$this->addColumn('status', array(
				'header'    => Mage::helper('dwd_icd')->__('Status'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'status',
				'type'		=> 'options',
				'options' => Dwd_Icd_Model_OrderStatus::getOptionArray(),
				'filter_index' => 'main_table.status'
		));

		$this->addColumn('sync_status', array(
				'header'    => Mage::helper('dwd_icd')->__('Synchronization'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'sync_status',
				'type'	=> 'options',
				'options' => Dwd_Icd_Model_Syncstatus::getOptionArray(),
				'filter_index' => 'main_table.sync_status'
		));
		
		$this->addColumn('account_sync_status', array(
				'header'    => Mage::helper('dwd_icd')->__('Account Synchronization'),
				'align'     =>'left',
				'width'     => '50px',
				'index'     => 'account_sync_status',
				'type'	=> 'options',
				'options' => Dwd_Icd_Model_Syncstatus::getOptionArray(),
				'filter_index' => 'account.sync_status'
		));


		$this->addColumn('created_time', array(
				'header'    => Mage::helper('dwd_icd')->__('Created'),
				'align'     =>'left',
				'type'		=> 'datetime',
      			'gmtoffset' => true,
				'width'     => '80px',
				'index'     => 'created_time',
		));
		 
		$this->addColumn('update_time', array(
				'header'    => Mage::helper('dwd_icd')->__('Updated'),
				'align'     =>'left',
				'type'		=> 'datetime',
      			'gmtoffset' => true,
				'width'     => '80px',
				'index'     => 'update_time',
		));
		 
		$this->addColumn('error', array(
				'header'    => Mage::helper('dwd_icd')->__('Message'),
				'align'     =>'left',
				'index'     => 'error',
		));

		$this->addColumn('action',
				array(
						'header'    =>  Mage::helper('dwd_icd')->__('Action'),
						'width'     => '140',
						'type'      => 'action',
						'getter'    => 'getId',
						'actions'   => array(
								array(
										'caption'   => Mage::helper('sales')->__('Synchronization'),
										'url'       => array('base'=> 'dwd_icd/adminhtml_orderitem/sync'),
										'field'     => 'id'
								)
						),
						'filter'    => false,
						'sortable'  => false,
						'index'     => 'stores',
						'is_system' => true,
				));

		$this->addExportType('*/*/exportCsv', Mage::helper('dwd_icd')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('dwd_icd')->__('XML'));
		 
		return parent::_prepareColumns();
	}

	/**
	 * Gibt URL für Row zurück
	 * 
	 * @param string $row Zeile
	 * 
	 * @return string
	 */
	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}

}