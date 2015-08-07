<?php
/**
 * Block Grid für invalide Kassenzeichen
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Invalid_Kassenzeichen_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Konstruktor
	 * 
	 * @param array $attributes Attribute
	 * 
	 * @return void
	 */
	public function __construct($attributes=array()) {
		parent::__construct($attributes);
		$this->setId('invalidKassenzeichenGrid');
		$this->setDefaultSort('created_at');
		$this->setDefaultDir('DESC');
		$this->setUseAjax(true);
		$this->setSaveParametersInSession(true);
	}

	/**
	 * Collection anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Invalid_Kassenzeichen_Grid
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Grid::_prepareCollection()
	 */
	protected function _prepareCollection() {

		$collection = Mage::getResourceModel('paymentbase/transaction_collection');
		$this->setCollection($collection);

		return parent::_prepareCollection();		
	}
	
	/**
	 * Spalten anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Invalid_Kassenzeichen_Grid
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Grid::_prepareColumns()
	 */
	protected function _prepareColumns() {
		$store = Mage::app()->getStore();

		$this->addColumn('bkz', array(
				'header'  => Mage::helper('paymentbase')->__('Kassenzeichen'),
				'align'   => 'right',
				'width'   => '30px',
		  		'type'	  => 'text',
				'index'   => 'bkz',

		));
		
		$this->addColumn('created_at', array(
          	'header'    => Mage::helper('paymentbase')->__('Created at'),
          	'align'     =>'left',
      	  	'width'     => '20px',
			'type'		=> 'datetime',	
          	'index'     => 'created_at',
			'gmtoffset' => true
		));

		$this->addColumn('updated_at', array(
          	'header'    => Mage::helper('paymentbase')->__('Updated at'),
          	'align'     =>'left',
      	  	'width'     => '20px',
			'type'		=> 'date',	
			'index'     => 'updated_at',
			'type'		=> 'datetime',
			'gmtoffset' => true
		));
		
		$this->addColumn('payment_method', array(
			'header'    => Mage::helper('sales')->__('Payment Method'),
			'index'     => 'payment_method',
			'type'      => 'options',
			'width'     => '130px',
			'options'   => Mage::helper('egovsbase')->getActivPaymentMethods(),
		));

		/* $this->addColumn('action',
		array(
                'header'    =>  Mage::helper('paymentbase')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array($actions),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
		)); */


		$this->addExportType('*/*/exportKassenzeichenCsv', Mage::helper('paymentbase')->__('CSV'));
		$this->addExportType('*/*/exportKassenzeichenXml', Mage::helper('paymentbase')->__('XML (Excel)'));

		return parent::_prepareColumns();
	}

	/**
	 * Keine Massenaktionen zulassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Invalid_Kassenzeichen_Grid
	 * 
	 * @see Mage_Adminhtml_Block_Widget_Grid::_prepareMassaction()
	 */
	protected function _prepareMassaction() {
		return $this;
	}

	/**
	 * Liefert die URL zu einer Aktion dieses Grids
	 * 
	 * @param string $action Aktion
	 * 
	 * @return string
	 */
	public function getThisUrl($action) {
		return '*/paymentbase_invalid_kassenzeichen/'.$action;
	}
	
	/**
	 * Liefert die URL für Grid-Aktionen
	 * 
	 * Wichtig für Ajax
	 * 
	 * @return string
	 */ 
	public function getGridUrl() {
        return $this->getUrl('*/paymentbase_invalid_kassenzeichen/grid', array('_current'=>true));
    }

    /**
     * Liefert URL für Zeile
     * 
     * @param Varien_Object $row Zeile
     * 
     * @return string
     */
	public function getRowUrl($row) {
		
		//return "popWin('".$this->getUrl($this->getThisUrl('edit'),array('id' =>$row->getId()))."', 'windth=800,height=700,resizable=1,scrollbars=1');return false;";
		return $this->getUrl($this->getThisUrl('edit'), array('id' =>$row->getId()));
	}
}