<?php
/**
 * Block Grid Buchungslistenparameter
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Localparams_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setId('localparamsGrid');
		$this->setDefaultSort('localparams_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	/**
	 * Layout anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Localparams_Grid
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Grid::_prepareLayout()
	 */
	protected function _prepareLayout() {
		parent::_prepareLayout();
		 
		$localParams = Mage::getModel('paymentbase/localparams');
		 
		return $this;
	}

	/**
	 * Collection anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Localparams_Grid
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Grid::_prepareCollection()
	 */
	protected function _prepareCollection() {
		$collection = Mage::getModel('paymentbase/localparams')->getCollection();
		$collection->addParams();
		$this->setCollection($collection);
		// die($collection->getSelect()->__toString());
		return parent::_prepareCollection();
	}

	/**
	 * Spalten anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Localparams_Grid
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Grid::_prepareColumns()
	 */
	protected function _prepareColumns() {
		$this->addColumn('paymentbase_localparams_id', array(
				'header'    => Mage::helper('paymentbase')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'paymentbase_localparams_id',
		));

		$this->addColumn('title', array(
				'header'    => Mage::helper('paymentbase')->__('Title'),
				'align'     =>'left',
				'index'     => 'title',
				'filter_index' => 'main_table.title'
		));

		$params = Mage::getModel('paymentbase/defineparams');
		$this->addColumn('ident', array(
				'header'    => Mage::helper('paymentbase')->__('Parameter Name'),
				//'align'     =>'right',
				'width'     => '100px',
				'index'     => 'param_id',
				'type'      => 'options',
				'options'   => $params->toOptions(),
				'filter_index' => 'main_table.param_id'
		));

		$this->addColumn('value', array(
				'header'    => Mage::helper('paymentbase')->__('Value'),
				//'align'     =>'right',
				'width'     => '100px',
				'index'     => 'value',
		));

		/*
		 $this->addColumn('priority', array(
		 		'header'    => Mage::helper('paymentbase')->__('Priority'),
		 		//'align'     =>'right',
		 		'width'     => '100px',
		 		'index'     => 'priority',
		 ));
		*/
		$groups = Mage::getModel('customer/group')->getCollection()->toOptionHash();
		$groups['-1'] = Mage::helper('paymentbase')->__('All Customer Groups');
        // Sort by Group Label
        asort($groups);
		$this->addColumn('customer_group_id', array(
				'header'    => Mage::helper('paymentbase')->__('Customer Group'),
				//'align'     =>'right',
				'width'     => '100px',
				'index'     => 'customer_group_id',
				'type'      => 'options',
				'options'   => $groups
		));

		$payment = Mage::getModel('adminhtml/system_config_source_payment_allowedmethods');
		$phash = Mage::helper('paymentbase')->getActivePaymentMethods();
		//Leerer Eintrag wird von Magento erzeugt
		$phash['all'] = Mage::helper('paymentbase')->__('All Payment Methods');

		$this->addColumn('payment_method', array(
				'header'    => Mage::helper('paymentbase')->__('Payment Method'),
				//'align'     =>'right',
				'width'     => '150px',
				'index'     => 'payment_method',
				'type'      => 'options',
				'options'   => $phash
		));

		$this->addColumn('lower', array(
				'header'    => Mage::helper('paymentbase')->__('Lower Range [Euro]'),
				//'align'     =>'right',
				'width'     => '100px',
				'index'     => 'lower',
		));

		$this->addColumn('upper', array(
				'header'    => Mage::helper('paymentbase')->__('Upper Range [Euro]'),
				//'align'     =>'right',
				'width'     => '100px',
				'index'     => 'upper',
		));

		$this->addColumn('status', array(
				'header'    => Mage::helper('paymentbase')->__('Status'),
				//'align'     =>'right',
				'width'     => '50px',
				'index'     => 'status',
				'type'      => 'options',
				'options'   => array(
						1 => Mage::helper('paymentbase')->__('Enabled'),
						2 => Mage::helper('paymentbase')->__('Disabled'),
				),
		));

		$this->addExportType('*/*/exportCsv', Mage::helper('paymentbase')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('paymentbase')->__('XML'));
		 

		return parent::_prepareColumns();
	}

	/**
	 * Massen-Aktionen anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Localparams_Grid
	 * 
	 */
	protected function _prepareMassaction() {
		$this->setMassactionIdField('paymentbase_localparams_id');
		$this->getMassactionBlock()->setFormFieldName('localparams');

		$this->getMassactionBlock()->addItem('delete', array(
				'label'    => Mage::helper('paymentbase')->__('Delete'),
				'url'      => $this->getUrl('*/*/massDelete'),
				'confirm'  => Mage::helper('paymentbase')->__('Are you sure?')
		));

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

	/**
	 * Anpassungen für Filter
	 *
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Spalte
	 *
	 * @return Egovs_Paymentbase_Block_Adminhtml_Sales_Overview_Grid
	 *
	 * @see Mage_Adminhtml_Block_Widget_Grid::_addColumnFilterToCollection()
	 */
	protected function _addColumnFilterToCollection($column) {
		if ($this->getCollection()) {
			if ($column->getId() == 'customer_group_id') {
				$filter = $column->getFilter()->getValue();
				if ($filter == '-1') {
					$this->getCollection()->getSelect()->where('customer_group_id = -1');
					return;
				}
			}
			 
			if ($column->getId() == 'payment_method') {
				$filter = $column->getFilter()->getValue();
				if ($filter == '-1') {
					$this->getCollection()->getSelect()->where("payment_method = 'all'");
					return;
				}
			}
		}
		return parent::_addColumnFilterToCollection($column);
	}

}
