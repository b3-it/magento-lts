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
class Egovs_Paymentbase_Block_Adminhtml_Defineparams_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		$this->setId('defineparamsGrid');
		$this->setDefaultSort('defineparams_id');
		$this->setDefaultDir('ASC');
		$this->setSaveParametersInSession(true);
	}

	/**
	 * Colelction anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Defineparams_Grid
	 */
	protected function _prepareCollection() {
		$collection = Mage::getModel('paymentbase/defineparams')->getCollection();
		$this->setCollection($collection);
		return parent::_prepareCollection();
	}

	/**
	 * Layout anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Defineparams_Grid
	 */
	protected function _prepareLayout() {
		parent::_prepareLayout();

		$localParams = Mage::getModel('paymentbase/localparams');

		$this->getMessagesBlock()->addNotice($this->__("Parameter IDs bitte entsprechend Mandantenkonfiguration der ePay-BL vornehmen (Übereinstimmung mit Einstellung der Zahlplattform erforderlich)!"));
		$this->getMessagesBlock()->addNotice($this->__("Parameter ID für 'Kennzeichen Mahnverfahren' lautet: %s", $localParams->getKennzeichenMahnverfahrenCode()));

		return $this;
	}

	/**
	 * Spalten anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Defineparams_Grid
	 */
	protected function _prepareColumns() {
		$this->addColumn('paymentbase_defineparams_id', array(
				'header'    => Mage::helper('paymentbase')->__('ID'),
				'align'     =>'right',
				'width'     => '50px',
				'index'     => 'param_id',
		));

		$this->addColumn('title', array(
				'header'    => Mage::helper('paymentbase')->__('Title'),
				'align'     =>'left',
				'index'     => 'title',
		));

		 
		$this->addColumn('ident', array(
				'header'    => Mage::helper('paymentbase')->__('Parameter ID'),
				'width'     => '150px',
				'index'     => 'ident',
		));
		 


		$this->addExportType('*/*/exportCsv', Mage::helper('paymentbase')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('paymentbase')->__('XML'));
		 
		return parent::_prepareColumns();
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