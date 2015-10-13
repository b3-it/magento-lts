<?php

class Egovs_Zahlpartnerkonten_Block_Adminhtml_Pool_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	public function __construct() {
		parent::__construct();
		$this->setId('poolGrid');
		$this->setDefaultSort('pool_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	protected function _prepareCollection() {
		$collection = Mage::getModel('zpkonten/pool')->getCollection();
		$eav = Mage::getResourceModel('eav/entity_attribute');
		$collection
			->getSelect()
			->joinleft(array('customer_company'=>'customer_entity_varchar'), 'customer_company.entity_id=main_table.customer_id AND customer_company.attribute_id='.$eav->getIdByCode('customer', 'company'), array('company'=>'value'))
			->joinleft(array('customer_firstname'=>'customer_entity_varchar'), 'customer_firstname.entity_id=main_table.customer_id AND customer_firstname.attribute_id='.$eav->getIdByCode('customer', 'firstname'), array('firstname'=>'value'))
			->joinleft(array('customer_lastname'=>'customer_entity_varchar'), 'customer_lastname.entity_id=main_table.customer_id AND customer_lastname.attribute_id='.$eav->getIdByCode('customer', 'lastname'), array('lastname'=>'value'))
			//->joinLeft(array('customers'=>'customer_entity'), '`customers`.`entity_id` = `main_table`.`customer_id`', array('customer_group' => 'group_id'))
			->columns(array('customer'=>"concat(IFNULL(customer_company.value,''),' ', IFNULL(customer_firstname.value,''),' ',IFNULL(customer_lastname.value,''))"))
		;
			 
		//die($collection->getSelect()->__toString());
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	/**
	 * Spalten für Anzeige vorbereiten
	 * 
	 * @return Egovs_Zahlpartnerkonten_Block_Adminhtml_Pool_Grid
	 */
	protected function _prepareColumns() {
		$this->addColumn('zpkonten_pool_id', array(
				'header'    => Mage::helper('zpkonten')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'zpkonten_pool_id',
		));

		$this->addColumn('kassenzeichen', array(
				'header'    => Mage::helper('zpkonten')->__('Kassenzeichen'),
				'align'     =>'left',
				'width'	  => 100,
				'index'     => 'kassenzeichen',
		));

		$this->addColumn('mandant', array(
				'header'    => Mage::helper('zpkonten')->__('Mandant'),
				'align'     =>'left',
				'width'	  => 90,
				'index'     => 'mandant',
		));

		$this->addColumn('bewirtschafter', array(
				'header'    => Mage::helper('zpkonten')->__('Bewirtschafter'),
				'align'     =>'left',
				'width'	  => 90,
				'index'     => 'bewirtschafter',
		));

		$this->addColumn('currency', array(
				'header'    => Mage::helper('zpkonten')->__('Currency'),
				'align'     =>'left',
				'width'	  => 50,
				'index'     => 'currency',
				'type'	  => 'options',
				'options'   => $this->__getCurrency()
		));

		$st = Egovs_Zahlpartnerkonten_Model_Status::getOptionArray();
		$this->addColumn('status', array(
				'header'    => Mage::helper('zpkonten')->__('Status'),
				'align'     =>'left',
				'index'     => 'status',
				'type'	=>'options',
				'width'	  => 100,
				'options'		=> $st
		));

		$this->addColumn('customer', array(
				'header'    => Mage::helper('zpkonten')->__('Customer'),
				'align'     =>'left',
				'index'     => 'customer_name',
		));
		
		$this->addColumn('last_payment', array(
				'header'    => Mage::helper('zpkonten')->__('Last Payment Method'),
				'align'     =>'left',
				'index'     => 'last_payment',
				'width'		=> 100,
				'type'		=>'options',
				'options'	=> Mage::helper('paymentbase')->getActivePaymentMethods()
		));
		
		$this->addColumn('comment', array(
				'header'    => Mage::helper('zpkonten')->__('Comment'),
				'align'     =>'left',
				'index'     => 'comment',
		));
		
		$this->addColumn('action',
				array(
						'header'    =>  Mage::helper('adminhtml')->__('Action'),
						'width'     => '100',
						'type'      => 'action',
						'getter'    => 'getId',
						'actions'   => array(
								array(
										'caption'   => Mage::helper('adminhtml')->__('Show'),
										'url'       => array('base'=> '*/*/edit'),
										'field'     => 'id'
								)
						),
						'filter'    => false,
						'sortable'  => false,
						'is_system' => true,
				));



		$this->addExportType('*/*/exportCsv', Mage::helper('zpkonten')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('zpkonten')->__('XML'));
		 
		return parent::_prepareColumns();
	}

	 

	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}

	private function __getCurrency() {
		$curr = Mage::app()->getLocale()->getOptionCurrencies();
		$res = array();
		foreach ($curr as $c) {
			$res[$c['value']] = $c['label'];
		}

		return $res;
	}

	protected function _prepareMassaction() {
		$this->setMassactionIdField('zpkonten_pool_id');
		$this->getMassactionBlock()->setFormFieldName('zpkonten_pool_id');



		$statuses = Mage::getSingleton('zpkonten/status')->getOptionArray();

		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
				'label'=> Mage::helper('zpkonten')->__('Change status'),
				'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
				'additional' => array(
						'visibility' => array(
								'name' => 'status',
								'type' => 'select',
								'class' => 'required-entry',
								'label' => Mage::helper('zpkonten')->__('Status'),
								'values' => $statuses
						)
				)
		));
		return $this;
	}

}