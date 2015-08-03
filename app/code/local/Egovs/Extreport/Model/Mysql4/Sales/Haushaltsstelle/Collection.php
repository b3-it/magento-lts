<?php

/**
 * ResourceModel Collection für Haushaltsstellen
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Sales_Haushaltsstelle_Collection extends Egovs_Extreport_Model_Mysql4_Sales_Quantity_Collection
{
	protected  $_haushaltsstellefilter = null;
	protected  $_categorynames = null;

	/**
	 * Fügt Informationen für Haushaltsstellen hinzu
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Haushaltsstelle_Collection
	 */
	protected function _addHaushaltsstelle()
	{	/*
		 * Bei ConfigurableProducts (CPs) wird auch immmer mit das entsprechende SimpleProduct (SP) in der
		 * Tabelle abgelegt, diese enthalten aber bis auf den eigentlichen Produktnamen keine brauchbaren Informationen!
		 */
		/* @var $haushaltsstelle Mage_Eav_Model_Entity_Attribute */
		$haushaltsstelle = Mage::getModel('eav/entity_attribute')->loadByCode('catalog_product', 'haushaltsstelle');
		if (!$haushaltsstelle) {
			return $this;
		}
		
		$this->getSelect()
				/*
				 * inner join catalog_product_entity_varchar as t2 on simple.product_id = t2.entity_id
				 * inner join eav_attribute as att on t2.attribute_id =att.attribute_id and att.attribute_code='haushaltsstelle'
				 * inner join eav_entity_type as eavtype on att.entity_type_id=eavtype.entity_type_id and eavtype.entity_type_code='catalog_product'
				 */
			->join(
					array(
						'cpev'=>$haushaltsstelle->getBackendTable()
					),
					'main_table.product_id = cpev.entity_id',
					array('haushaltsstelle'=>'value')
			)->join(
					array(
						'att'=> $this->getTable('eav/attribute')),
						'cpev.'.$haushaltsstelle->getIdFieldName().' = att.'.$haushaltsstelle->getIdFieldName().' and att.attribute_code=\''.$haushaltsstelle->getAttributeCode().'\' and att.entity_type_id = \''.$haushaltsstelle->getEntityTypeId().'\'',
						array()
			)/* ->join(
					array(
						'eavtype'=>'eav_entity_type'
					),
					'att.entity_type_id=eavtype.entity_type_id and eavtype.entity_type_code=\'catalog_product\'',
					array()
			) */
		;

		//Filtern
		if ($this->_haushaltsstellefilter != null) {
			$this->getSelect()->where("cpev.value='".$this->_haushaltsstellefilter."'");
		}

		return $this;
	}
	
	/**
	 * Setzt die Datumsspanne der Collection
	 *
	 * @param string $from Von Datum
	 * @param string $to   Bis Datum
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Haushaltsstelle_Collection
	 */
	public function setDateRange($from, $to) {
		$this->_reset() //Wichtig für Datefilter; Reset ruft initSelect() auf!!
			->_addSalesQuantity($from, $to)
			->_addHaushaltsstelle()
			->_createSubSelect()
			->setOrder('name', self::SORT_ORDER_ASC)
		;
		 
		return $this;
	}

	/**
	 * Setzt den HaushaltstellenFilter der Collection
	 *
	 * @param array $filter Filter
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Haushaltsstelle_Collection
	 */
	public function setHaushaltsstelleFilter($filter)
	{
		$this->_haushaltsstellefilter = $filter;
	}

	/**
	 * Wird vor dem Laden aufgerufen
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Haushaltsstelle_Collection
	 */
	protected function _beforeLoad()
	{
		if ($this->_haushaltsstellefilter != null) {
			//$this->getSelect()->where("`cat`.`value`='".$this->_categoryfilter."'");
			$this->getSelect()->where("haushaltsstelle=".$this->_haushaltsstellefilter);
// 			unset($this->_haushaltsstellefilter);
		}

// 		die($this->getSelect()->__toString());
		return parent::_beforeLoad();
	}
}