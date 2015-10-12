<?php

/**
 * Block Grid für Buchungslistenparameter
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Customer_Edit_Tab_Sepahistory_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	
	protected $_customer;
	
	
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setId('sepaHistoryGrid');
		$this->setDefaultSort('entity_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		$this->setUseAjax(true);
	}

	/**
	 * Colelction anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Defineparams_Grid
	 */
	protected function _prepareCollection() {
		$collection = Mage::getModel('paymentbase/sepa_mandate_history')->getCollection();
		$collection
			->getSelect()
			->reset(Zend_Db_Select::COLUMNS)
			->columns('sepa_mandate_id')
			->columns('created_at')
			->where('main_table.customer_id = ' .$this->getCustomer()->getId())			
			->joinLeft(array('payment'=>'sales_flat_order_payment'), '`payment`.`sepa_mandate_id` = `main_table`.`sepa_mandate_id`', array())
			->joinLeft(array('order'=>'sales_flat_order'),'payment.parent_id=order.entity_id',array('order_increment_id'=>'increment_id','order_date'=>'created_at'))
			
					
		;
		
		//die($collection->getSelect()->__toString());
				
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	
	public function getCustomer()
	{
		if (!$this->_customer) {
			$this->_customer = Mage::registry('current_customer');
		}
		return $this->_customer;
	}

	/**
	 * Spalten anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Defineparams_Grid
	 */
	protected function _prepareColumns() {
		$this->addColumn('created_at', array(
				'header'    => Mage::helper('paymentbase')->__('Created At'),
				'align'     =>'right',
				'width'     => '80px',
				'index'     => 'created_at',
				'type'		=> 'date'
		));

		$this->addColumn('sepa_mandate_id', array(
				'header'    => Mage::helper('paymentbase')->__('SEPA Mandate ID'),
				'align'     =>'left',
				'index'     => 'sepa_mandate_id',
				'filter_index' => 'main_table.sepa_mandate_id',
		));
		
		$this->addColumn('order_increment_id', array(
				'header'    => Mage::helper('paymentbase')->__('Order ID'),
				'align'     =>'left',
				'index'     => 'order_increment_id',
				'filter_index' => 'order.increment_id'
		));

		$this->addColumn('order_date', array(
				'header'    => Mage::helper('paymentbase')->__('Order Date'),
				'align'     =>'right',
				'width'     => '80px',
				'index'     => 'order_date',
				'type'		=> 'date',
				'filter_index' => 'order.created_at'
		));
	
		/*
		 * 
		 *    	$hash = sha1($customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_SEPA_MANDATE_ID).$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID));
    	$hash .= '.pdf';
		 * 
		 */
		 
		return parent::_prepareColumns();
	}
	
	
	
	public function getRowUrl($row)
	{
		return $this->getUrl('*/paymentbase_customer_sepahistory/pdf', array(
				'customer_id'=>$this->getCustomer()->getId(),
				'sepa_mandate_id'=>$row->getSepaMandateId())
		);
	}
	
	

	/**
	 * Liefert die URL für eine Grid-Aktion auf einer Zeile
	 *
	 * @param Varien_Object $row Zeile
	 *
	 * @return string
	 */
	public function getGridUrl() {
		$url =  $this->getUrl('*/paymentbase_customer_sepahistory/grid',array('customer_id'=>$this->getCustomer()->getId()));
		return $url;
	}
	
	
	
	

}