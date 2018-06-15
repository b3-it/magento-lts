<?php
/**
 *
 * @category   	B3it
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Period_entity
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 *  @method int getId()
 *  @method setId(int $value)
 *  @method int getPos()
 *  @method setPos(int $value)
 *  @method int getPeriodLength()
 *  @method setPeriodLength(int $value)
 *  @method int getRenewalOffset()
 *  @method setRenewalOffset(int $value)
 *  @method string getPeriodUnit()
 *  @method setPeriodUnit(string $value)
 *  @method int getInitialPeriodLength()
 *  @method setInitialPeriodLength(int $value)
 *  @method string getInitialPeriodUnit()
 *  @method setInitialPeriodUnit(string $value)
 */
class B3it_Subscription_Model_Period extends Mage_Core_Model_Abstract
{
	//alias der Tabelle für die Verbindung zum Produkt
	protected $_productRelationTable = 'b3it_subscription/period_product';
	

	
	
	public function _construct()
	{
		parent::_construct();
		$this->_init('b3it_subscription/period');
	}
	
	/* folgendes ist nur sinnvoll falls die Perioden im FE angezeigt werden sollen
	 * 
	 * 	
	protected $_storeid = 0;
	
	public function setStoreId($id)
	{
		$this->_storeid = $id;
		return $this;
	}
	
	public function getStoreId()
	{
		return $this->_storeid;
	}
	public function save()
	{
		if($this->getStoreId() == 0){
			parent::save();
		}else{
			$this->_afterSave();
		}
	}
	
	protected function _afterSave()
	{
		$obj = new Varien_Object();
		$this->getResource()->loadLabels($obj, $this->getId(), $this->getStoreId());
	
		$obj->setShortname($this->getShortname());
		$obj->setName($this->getName());
		$obj->setDescription($this->getDescription());
	
		$obj->setStoreId($this->getStoreId());
		$obj->setEntityId($this->getId());
	
		$this->getResource()->saveLabel($obj);
	
		parent::_afterSave();
	
		return $this;
	
	}
	
	protected function _afterLoad()
	{
		$obj = new Varien_Object();
		$labels = $this->getResource()->loadLabels($obj, intval($this->getId()), $this->getStoreId());
	
		$this->setShortname($obj->getShortname());
		$this->setName($obj->getName());
		$this->setDescription($obj->getDescription());
	
		parent::_afterLoad();
	
		return $this;
	}
	*/
	
	public function getCollectionAsOptions($productId,$storeId = 0)
	{
		$res = array();
		$collection = $this->getCollection();
		$collection->setStoreId($storeId);
		foreach($collection->getItems() as $item)
		{
			$res[] = array('label'=>$item->getName(),'value' => $item->getId());
		}
	
		return $res;
	}
	
	public function getOptions4Product($productId,$storeId=0)
	{
		$productId = intval($productId);
		$storeId = intval($storeId);
		$collection = $this->getCollection();
		$collection->setStoreId($storeId);
		$collection->getSelect()
		->join(array('product'=>$collection->getTable($this->_productRelationTable)),"product.entity_id = main_table.id AND product_id={$productId} AND ((product.store_id= 0) OR (product.store_id={$storeId}))",array('is_default','component_product_relation_id'=>'id'));
	
		return $collection;
	}
}
