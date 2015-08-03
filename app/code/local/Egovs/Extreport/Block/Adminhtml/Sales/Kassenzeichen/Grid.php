<?php
/**
 * Adminhtml Report: Kassenzeichen Grid
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Block_Adminhtml_Sales_Kassenzeichen_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Initialisiert das Grid
	 *
	 * @return void
	 */
	public function __construct()
	{
		parent::__construct();
		$this->setId('kzeichenGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('desc');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
		$this->setVarNameFilter('customer_filter');
		$this->addExportType('*/*/exportKassenzeichenCsv', 'CSV');
		$this->addExportType('*/*/exportKassenzeichenExcel', 'XML (Excel)');
		$this->_controller = 'adminhtml_customer';

	}
	/**
	 * Liefert den Store zurück
	 *
	 * @return Mage_Core_Model_Store>
	 */
	protected function _getStore()
	{
		$storeId = (int) $this->getRequest()->getParam('store', 0);
		return Mage::app()->getStore($storeId);
	}
	/**
	 * Initialisiert die Collection
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Haushaltsstelle_Grid
	 */
	protected function _prepareCollection()
	{
		$store = $this->_getStore();
		 
		if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
			/* @var $collection Mage_Core_Model_Mysql4_Collection_Abstract */
			$collection = $this->_prepareCollection13();
		} else {
			$collection = Mage::getResourceModel('extreport/sales_kassenzeichen_collection');
			/* @var $collection Mage_Core_Model_Mysql4_Collection_Abstract */
			$collection->getSelect()
				->joinLeft(
						array('billing_address' => $collection->getTable('sales/order_address')),
						'billing_address_id = billing_address.entity_id',
						array(
								'company',
								'billing_firstname' => 'firstname',
								'billing_lastname' => 'lastname'
						)
				)->joinLeft(
						array('shipping_address' => $collection->getTable('sales/order_address')),
						'shipping_address_id = shipping_address.entity_id',
						array(
								'shipping_firstname' => 'firstname',
								'shipping_lastname' => 'lastname'
						)
				)
			;
			
			$collection
				->addExpressionFieldToSelect(
						'billing_name',
						'CONCAT(COALESCE({{firstname}}, ""), " ", COALESCE({{lastname}}, ""))',
						array('firstname' => 'billing_address.firstname', 'lastname' => 'billing_address.lastname')
				)->addExpressionFieldToSelect(
						'shipping_name',
						'CONCAT(COALESCE({{firstname}}, ""), " ", COALESCE({{lastname}}, ""))',
						array('firstname' => 'shipping_address.firstname', 'lastname' => 'shipping_address.lastname')
				)->getSelect()->join(
						array('bkz' => $collection->getTable('sales/order_payment')),
						'main_table.entity_id = bkz.parent_id',
						array('kassenzeichen')
				)->joinLeft(
						array('sti' => $collection->getTable('sales/order_payment')),
						'main_table.entity_id = sti.parent_id',
						array('saferpay_transaction_id') //Ist nur bei Saferpay-Bestellungen vorhanden
				)
				->joinLeft(
						array('sepa' => $collection->getTable('sales/order_payment')),
						'main_table.entity_id = sepa.parent_id',
						array('sepa_mandate_id') 
				)
				->join(
						array('customer' => $collection->getTable('customer/entity')),
						'main_table.customer_id = customer.entity_id',
						array('email')
				)
			;
		}

		$this->setCollection($collection);
		
		//Mage::log(sprintf('sql: %s', $this->getCollection()->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		
		
		parent::_prepareCollection();
		
		return $this;
	}
	
	/**
	 * Initialisiert die Collection für Magento 1.3
	 * 
	 * @return Mage_Core_Model_Mysql4_Collection_Abstract
	 */
	protected function _prepareCollection13 () {
		
		$paymentEntity = Mage::getModel('sales/order_payment')->getCollection()->getEntity();
		$kassenzeichenAttribute = $paymentEntity->getAttribute('kassenzeichen');
		$saferpayAttribute = $paymentEntity->getAttribute('saferpay_transaction_id');
		$entityTable =  $kassenzeichenAttribute->getEntity()->getEntityTable();
		
		$collection = Mage::getResourceModel('sales/order_collection')
			->addAttributeToSelect('*')
			
			->joinAttribute('company', 'order_address/company', 'billing_address_id', null, 'left')
			->joinAttribute('billing_firstname', 'order_address/firstname', 'billing_address_id', null, 'left')
			->joinAttribute('billing_lastname', 'order_address/lastname', 'billing_address_id', null, 'left')
			->joinAttribute('shipping_firstname', 'order_address/firstname', 'shipping_address_id', null, 'left')
			->joinAttribute('shipping_lastname', 'order_address/lastname', 'shipping_address_id', null, 'left')
			->addExpressionAttributeToSelect(
					'billing_name',
					'CONCAT(COALESCE({{billing_firstname}}, ""), " ", COALESCE({{billing_lastname}}, ""))',
					array('billing_firstname', 'billing_lastname')
			)->addExpressionAttributeToSelect(
					'shipping_name',
					'CONCAT(COALESCE({{shipping_firstname}}, ""), " ", COALESCE({{shipping_lastname}}, ""))',
					array('shipping_firstname', 'shipping_lastname')
			)->joinField(
					'payment_id',
					$entityTable,
					'entity_id',
					'parent_id=entity_id',
					'{{table}}.entity_type_id='.$kassenzeichenAttribute->getEntityTypeId(),
					'inner'
			)->joinField(
					'kassenzeichen',
					$kassenzeichenAttribute->getBackendTable(),
					'value',
					'entity_id=payment_id',
					'{{table}}.attribute_id='.$kassenzeichenAttribute->getAttributeId(),
					'inner'
			)->joinField(
					'saferpay_transaction_id',
					$saferpayAttribute->getBackendTable(),
					'value',
					'entity_id=payment_id',
					'{{table}}.attribute_id='.$saferpayAttribute->getAttributeId(),
					'left'
			)
		;
		
		return $collection;
	}

	/**
	 * Initialisiert die Spalten
	 *
	 * @return Egovs_Extreport_Block_Adminhtml_Sales_Kassenzeichen_Grid
	 */
	protected function _prepareColumns()
	{
		/*
		 $this->addColumn('entity_id',
		 		array(
		 				'header'=> Mage::helper('catalog')->__('ID'),
		 				'width' => '50px',
		 				'type'  => 'number',
		 				'index' => 'entity_id',
		 				//'filter_index' => 'so.order_id',
		 				//'total' => 'Total',
		 		));
		*/
		$this->addColumn('order',
				array(
						'header'=> Mage::helper('sales')->__('Order'),
						'width' => '80px',
						'index' => 'increment_id',
						'filter_index'=>'main_table.increment_id',
						
						'link_index' => 'entity_id',
						'link_param' =>'order_id',
						'link_url' => 'adminhtml/sales_order/view',
						'renderer' =>  'egovsbase/adminhtml_widget_grid_column_renderer_link',
				
				));

	
		$this->addColumn('customer',
				array(
						'header'=> Mage::helper('sales')->__('Email'),
						'width' => '80px',
						'index' => 'email',
						'filter_index'=>'customer.email',
		
						'link_index' => 'customer_id',
						'link_param' =>'id',
						'link_url' => 'adminhtml/customer/edit',
						'renderer' =>  'egovsbase/adminhtml_widget_grid_column_renderer_link',
		
				));
		
		
		
		 
		$this->addColumn('company', array(
				'header' => Mage::helper('sales')->__('Company'),
				'width' => '200px',
				'index' => 'company',
				'filter_index' => version_compare(Mage::getVersion(), '1.4.1', '<') ? 'company' : 'billing_address.company',
		));
		 

		$this->addColumn('billing_name', array(
				'header' => Mage::helper('sales')->__('Bill to Name'),
				'index' => 'billing_name',
				'filter_condition_callback' => array($this, '_filterBillingNameCondition'),
		));	 
		 
		$this->addColumn('date', array(
				'header'    => Mage::helper('sales')->__('Order Date'),
				'type'      => 'datetime',
				'align'     => 'center',
				'width' 	=> '80px',
				'index'     => 'created_at',
				'gmtoffset' => true
		));

		$this->addColumn('kassenzeichen',
				array(
						'header'=> Mage::helper('sales')->__('Kassenzeichen'),
						'width' => '80px',
						'index' => 'kassenzeichen',
						'filter_index' => version_compare(Mage::getVersion(), '1.4.1', '<') ? 'kassenzeichen' : 'bkz.kassenzeichen',
				));
		 
		$this->addColumn('saferpayid',
				array(
						'header'=> Mage::helper('sales')->__('Saferpay Id'),
						'width' => '80px',
						'index' => 'saferpay_transaction_id',
						'filter_index' => version_compare(Mage::getVersion(), '1.4.1', '<') ? 'saferpay_transaction_id' : 'sti.saferpay_transaction_id',
				));
		
		$this->addColumn('sepa_mandate_id',
				array(
						'header'=> Mage::helper('sales')->__('SEPA Mandate Id'),
						'width' => '80px',
						'index' => 'sepa_mandate_id',
						'filter_index' => 'sepa.sepa_mandate_id'
				));
		 
		$store = $this->_getStore();
		$this->addColumn('base_grand_total',
				array(
						'header'=> Mage::helper('sales')->__('Total Amount'),
						'type'	=> 'price',
						'currency_code' => $store->getBaseCurrencyCode(),
						'width' => '80px',
						'index' => 'base_grand_total',
				));
		 
		/*
		if (Mage::getSingleton('admin/session')->isAllowed('sales/order/actions/view')) {
			$this->addColumn('action',
					array(
							'header'    => Mage::helper('sales')->__('Action'),
							'width'     => '50px',
							'type'      => 'action',
							'getter'     => 'getEntityId',
							'actions'   => array(
									array(
											'caption' => Mage::helper('sales')->__('View'),
											'url'     => array('base'=>'adminhtml/sales_order/view'),
											'field'   => 'order_id'
									)
							),
							'filter'    => false,
							'sortable'  => false,
							'index'     => 'stores',
							'is_system' => true,
					));
		}
		 */
		//$this->setCountTotals(true);
		return $this;//parent::_prepareColumns();
	}
	
	/**
	 * Eigener Filter für Rechnungsnamen
	 * 
	 * @param Mage_Core_Model_Mysql4_Collection_Abstract $collection Collection
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column    $column     Spalte
	 * 
	 * @return void
	 */
	protected function _filterBillingNameCondition($collection, $column) {
        if (!$value = $column->getFilter()->getValue()) {
            return;
        }

        if (version_compare(Mage::getVersion(), '1.4.1', '<')) {
        	$collection->getSelect()->where(sprintf('billing_name like %s', $value));
        } else {
        	$collection->getSelect()->having(sprintf("billing_name like '%s'", $value));
        }
        
	}
	
	/**
	 * Liefert die Grid-URL
	 *
	 * @return string
	 */
	public function getGridUrl()
	{
		return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>'kassenzeichen'));
	}


}
