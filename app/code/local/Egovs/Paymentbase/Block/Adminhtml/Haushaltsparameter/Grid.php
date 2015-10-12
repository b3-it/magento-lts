<?php
/**
 * Block Grid Haushaltsparameter
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Haushaltsparameter_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setId('haushaltsparameterGrid');
		$this->setDefaultSort('haushaltsparameter_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	/**
	 * Collection anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Haushaltsparameter_Grid
	 */
	protected function _prepareCollection() {
		$collection = Mage::getModel('paymentbase/haushaltsparameter')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	/**
	 * Spalten anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Haushaltsparameter_Grid
	 */
	protected function _prepareColumns() {
		$this->addColumn('paymentbase_haushaltsparameter_id', array(
				'header'    => Mage::helper('paymentbase')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'paymentbase_haushaltsparameter_id',
		));

		$this->addColumn('title', array(
				'header'    => Mage::helper('paymentbase')->__('Title'),
				'align'     =>'left',
				'index'     => 'title',
		));

		$this->addColumn('value', array(
				'header'    => Mage::helper('paymentbase')->__('Value'),
				'align'     =>'left',
				'index'     => 'value',
				'width'     => '150px',
		));


		$types = Mage::getModel('paymentbase/haushaltsparameter_type');
		$this->addColumn('type', array(
				'header'    => Mage::helper('paymentbase')->__('Type'),
				'align'     => 'left',
				'width'     => '150px',
				'index'     => 'type',
				'type'      => 'options',
				'options'   => $types->getOptionArray()
		)
		);

		$this->addColumn('action',
				array(
						'header'    =>  Mage::helper('paymentbase')->__('Action'),
						'width'     => '100',
						'type'      => 'action',
						'getter'    => 'getId',
						'actions'   => array(
								array(
										'caption'   => Mage::helper('paymentbase')->__('Edit'),
										'url'       => array('base'=> '*/*/edit'),
										'field'     => 'id'
								)
						),
						'filter'    => false,
						'sortable'  => false,
						'index'     => 'stores',
						'is_system' => true,
				));

		$this->addExportType('*/*/exportCsv', Mage::helper('paymentbase')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('paymentbase')->__('XML'));
		 
		return parent::_prepareColumns();
	}

	/**
	 * Massenaktion anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Haushaltsparameter_Grid
	 */
	protected function _prepareMassaction()
	{
		$this->setMassactionIdField('haushaltsparameter_id');
		$this->getMassactionBlock()->setFormFieldName('haushaltsparameter');

		$this->getMassactionBlock()->addItem('delete', array(
				'label'    => Mage::helper('paymentbase')->__('Delete'),
				'url'      => $this->getUrl('*/*/massDelete'),
				'confirm'  => Mage::helper('paymentbase')->__('Are you sure?')
		));
		/*
		 $statuses = Mage::getSingleton('paymentbase/haushaltsparameter_type')->getOptionArray();

		array_unshift($statuses, array('label'=>'', 'value'=>''));
		$this->getMassactionBlock()->addItem('status', array(
				'label'=> Mage::helper('paymentbase')->__('Change status'),
				'url'  => $this->getUrl('././massStatus', array('_current'=>true)),
				'additional' => array(
						'visibility' => array(
								'name' => 'status',
								'type' => 'select',
								'class' => 'required-entry',
								'label' => Mage::helper('paymentbase')->__('Status'),
								'values' => $statuses
						)
				)
		));
		*/
		return $this;
	}

	/**
	 * Liefert die URL für eine Klick-Aktion auf einer Zeile
	 *
	 * @param Varien_Object $row Zeile
	 *
	 * @return string
	 */
	public function getRowUrl($row) {
		return $this->getUrl('*/*/edit', array('id' => $row->getId()));
	}

}