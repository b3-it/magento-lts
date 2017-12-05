<?php
/**
 * Basis-Funktionen für Models
 *
 * @author r.muetterlein
 *
 */
abstract class Bkg_VirtualGeo_Model_Components_Abstract extends Mage_Core_Model_Abstract
{
    /**
     * Store-ID
     * @var integer
     */
    protected $_storeid = 0;

    public function _construct()
    {
        parent::_construct();
        $this->_init($this->_component_type);
    }

	/**
	 * setzen der StoreID
	 *
	 * @param integer $id
	 * @return Bkg_VirtualGeo_Model_Components_Abstract
	 */
	public function setStoreId($id)
	{
		$this->_storeid = $id;
		return $this;
	}

	/**
	 * SoreID
	 *
	 * @return integer
	 */
	public function getStoreId()
	{
		return $this->_storeid;
	}

	/**
	 * Speichern
	 *
	 * {@inheritDoc}
	 * @see Mage_Core_Model_Abstract::_afterSave()
	 */
    protected function _afterSave()
    {
    	$obj = new Varien_Object();
    	$labels = $this->getResource()->loadLabels($obj, intval($this->getId()), $this->getStoreId());

    	$obj->setShortname($this->getShortname());
    	$obj->setName($this->getName());
    	$obj->setDescription($this->getDescription());

    	$obj->setStoreId($this->getStoreId());
    	$obj->setParentId($this->getId());

    	$this->getResource()->saveLabel($obj);

		return $this;
    }

    /**
     * nach laden
     */
    protected function _afterLoad()
    {
    	$obj = new Varien_Object();
    	$labels = $this->getResource()->loadLabels($obj, intval($this->getId()), $this->getStoreId());

    	$this->setShortname($obj->getShortname());
    	$this->setName($obj->getName());
    	$this->setDescription($obj->getDescription());

    	return $this;
    }

    /**
     *
     * @param integer $productId
     * @param integer $storeId
     * @return Bkg_VirtualGeo_Model_Components_Abstract
     */
    public function getCollectionAsOptions($productId, $storeId = 0)
    {
    	$res = array();
    	$collection = $this->getCollection();
    	$collection->setStoreId($storeId);
    	foreach($collection->getItems() as $item)
    	{
    		$res[] = array('label' => $item->getName(), 'value' => $item->getId());
    	}

    	return $res;
    }

    /**
     *
     * @param integer $productId
     * @param integer $storeId
     * @return Bkg_VirtualGeo_Model_Components_Abstract
     */
	public function getOptions4Product($productId, $storeId=0)
	{
		$collection = $this->getCollection();
		$collection->getSelect()
		           ->join(array('product' => $collection->getTable($this->_component_table)),
                          'product.' . $this->_component_colid . ' = main_table.id AND product_id=' .
                          $productId . ' AND ((product.store_id= 0) OR (product.store_id=' . $storeId . '))',
                          array('is_default'));

		return $collection;
	}
}
