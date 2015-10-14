<?php
/**
 * Klasse für gemeinsam genutzte Methoden zur ePayment-Kommunikation über cURL.
 *
 * @category	Egovs
 * @package		Egovs_Informationservice
 * @author		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright	Copyright (c) 2011 - 2012 EDV Beratung Hempel
 * @copyright	Copyright (c) 2011 - 2012 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Informationservice_Block_Adminhtml_Request_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	private $_customermode = false;
	protected $_customerId = null;

	public function __construct() {
		parent::__construct();
		$this->setId('requestGrid');
		$this->setDefaultSort('request_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
		
		$this->addExportType('*/*/exportCsv', $this->__('CSV'));
		$this->addExportType('*/*/exportXml', $this->__('XML (Excel)'));
	}

	/**
	 * Collection vorbereiten
	 *
	 * @return Egovs_Informationservice_Block_Adminhtml_Request_Grid
	 */
	protected function _prepareCollection() {
		$collection = Mage::getModel('informationservice/request')->getCollection();

		//falls von der Kundenverwaltung
		//$customer_id = $this->getRequest()->getParam('customer_id');
		if ($this->_customerId != null) {
			$customerId = intval($this->_customerId);
			$collection->getSelect()->where('customer_id='.$customerId);
			$this->_customermode = true;
		} else {
			$eav = Mage::getResourceModel('eav/entity_attribute');
			$collection->getSelect()
			//->join(array('customer'=>$collection->getTable('customer/customer')),'customer.entity_id=main_table.customer_id',array())
			->joinleft(array('customer_company'=>'customer_entity_varchar'), 'customer_company.entity_id=main_table.customer_id AND customer_company.attribute_id='.$eav->getIdByCode('customer', 'company'), array('company'=>'value'))
			->joinleft(array('customer_firstname'=>'customer_entity_varchar'), 'customer_firstname.entity_id=main_table.customer_id AND customer_firstname.attribute_id='.$eav->getIdByCode('customer', 'firstname'), array('firstname'=>'value'))
			->joinleft(array('customer_lastname'=>'customer_entity_varchar'), 'customer_lastname.entity_id=main_table.customer_id AND customer_lastname.attribute_id='.$eav->getIdByCode('customer', 'lastname'), array('lastname'=>'value'))
			//->joinleft(array('customer_street'=>'customer_address_entity_varchar'),'customer_street.entity_id=main_table.customer_id AND customer_street.attribute_id='.$eav->getIdByCode('customer_address','street'),array('street'=>'value'))
			//->joinleft(array('customer_city'=>'customer_address_entity_varchar'),'customer_city.entity_id=main_table.customer_id AND customer_city.attribute_id='.$eav->getIdByCode('customer_address','city'),array('city'=>'value'))
			//->joinleft(array('customer_postcode'=>'customer_address_entity_varchar'),'customer_postcode.entity_id=main_table.customer_id AND customer_postcode.attribute_id='.$eav->getIdByCode('customer_address','postcode'),array('postcode'=>'value'))
			->joinLeft(array('customers'=>'customer_entity'), '`customers`.`entity_id` = `main_table`.`customer_id`', array('customer_group' => 'group_id'))
			// 				->joinLeft(array('customer_groups'=>'customer_group'), '`customer_groups`.`customer_group_id` = `customers`.`group_id`')
			->columns(array('customer'=>"concat(IFNULL(customer_company.value,''),' ', IFNULL(customer_firstname.value,''),' ',IFNULL(customer_lastname.value,''))"))
			;
		}

		//die($collection->getSelect()->__toString());

		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	/**
	 * Spalten vorbereiten
	 *
	 * @return Egovs_Informationservice_Block_Adminhtml_Request_Grid
	 */
	protected function _prepareColumns() {
		$this->addColumn('request_id', array(
				'header'    => Mage::helper('informationservice')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'request_id',
		));

		//falls von der Kundenverwaltung
		$customerId = $this->getRequest()->getParam('customer_id');
		if ($customerId == null) {
			$this->addColumn('customer_id', array(
					'header'    => Mage::helper('informationservice')->__('Customer#'),
					'align'     =>'left',
					'width'     => '50px',
					'index'     => 'customer_id',
			));
	   
			$this->addColumn('customer', array(
					'header'    => Mage::helper('informationservice')->__('Customer Name'),
					'align'     =>'left',
					'width'	=> '140',
					'index'     => 'customer',
			));

			$this->addColumn('customer_group', array(
					'header'    => Mage::helper('informationservice')->__('Customer Groups'),
					'align'     =>'left',
					'width'	=> '140',
					'type' 	=> 'options',
					'index'     => 'customer_group',
					'filter_index'     => 'group_id',
					//'options' => Mage::getModel('adminhtml/system_config_source_customer_group')->toOptionArray()
					'options' => Mage::getResourceModel('customer/group_collection')
					->setRealGroupsFilter()
					->loadData()->toOptionHash(),
			));
		}
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		$this->addColumn('created_time', array(
				'header'    => Mage::helper('informationservice')->__('Datum'),
				'align'     =>'left',
				'type'	=> 'date',
				'format' => $dateFormatIso,
				'width'     => '50px',
				'index'     => 'created_time',
		));



		$this->addColumn('title', array(
				'header'    => Mage::helper('informationservice')->__('Title'),
				'align'     =>'left',
				'index'     => 'title',
		));

		$this->addColumn('category', array(
				'header'    => Mage::helper('informationservice')->__('Category'),
				'align'     =>'left',
				'width'	=> '140',
				'type' 	=> 'options',
				'options'  => Mage::helper('informationservice')->getCategoriesAsOptionValueArray(),
				'filter' => 'informationservice/adminhtml_widget_grid_column_filter_selectlevels',
				'index'     => 'category_id',
		));

		$this->addColumn('owner_id', array(
				'header'    => Mage::helper('informationservice')->__('Owner'),
				'align'     =>'left',
				'width'     => '100px',
				'type'	=> 'options',
				'options' => Mage::helper('informationservice')->getUsernamesAsOptionValues(),
				'index'     => 'owner_id',
		));

		$this->addColumn('deadline_time', array(
				'header'    => Mage::helper('informationservice')->__('Deadline'),
				'align'     =>'left',
				'type'	=> 'Date',
				'format' => $dateFormatIso,
				'width'     => '50px',
				'index'     => 'deadline_time',
		));

		$this->addColumn('status', array(
				'header'    => Mage::helper('informationservice')->__('Status'),
				'align'     =>'left',
				'width'     => '50px',
				'type'	=> 'options',
				'options' => Mage::getModel('informationservice/status')->getOptionArray(),
				'index'     => 'status',
		));

		$this->addColumn('action',
				array(
						'header'    =>  Mage::helper('informationservice')->__('Action'),
						'width'     => '100',
						'type'      => 'action',
						'getter'    => 'getId',
						'actions'   => array(
								array(
										'caption'   => Mage::helper('informationservice')->__('Edit'),
										'url'       => array('base'=> 'adminhtml/informationservice_request/edit'),
										'field'     => 'id'
								)
						),
						'filter'    => false,
						'sortable'  => false,
						'index'     => 'stores',
						'is_system' => true,
				));

		//$this->addExportType('*/*/exportCsv', Mage::helper('informationservice')->__('CSV'));
		//$this->addExportType('*/*/exportXml', Mage::helper('informationservice')->__('XML'));
		 
		return parent::_prepareColumns();
	}

	/**
	 * Fügt einen Filter hinzu
	 *
	 * Die Spalte 'column' wird speziell als Expression gefiltert.
	 *
	 * @param Mage_Adminhtml_Block_Widget_Grid_Column $column Column
	 *
	 * @return Egovs_Informationservice_Block_Adminhtml_Request_Grid
	 *
	 * (non-PHPdoc)
	 * @see Mage_Adminhtml_Block_Widget_Grid::_addColumnFilterToCollection()
	 */
	protected function _addColumnFilterToCollection($column) {
		if ($this->getCollection()) {
			if ($column->getId() == 'customer') {
				$filter = $column->getFilter()->getValue();
				$select = $this->getCollection()->getSelect();
				$select->where("concat(IFNULL(customer_company.value,''),' ', IFNULL(customer_firstname.value,''),' ',IFNULL(customer_lastname.value,''))
						like '%".$filter."%'");

				return $this;
			}
		}
		 
		return Mage_Adminhtml_Block_Widget_Grid::_addColumnFilterToCollection($column);
	}

	/**
	 * Liefert URL für Zeilenaktion
	 *
	 * @param Varien_Object $row Zeile
	 *
	 * @return string
	 */
	public function getRowUrl($row) {
		return $this->getUrl('adminhtml/informationservice_request/edit', array('id' => $row->getId()));
	}

}