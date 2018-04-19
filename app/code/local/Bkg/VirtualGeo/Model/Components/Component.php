<?php
/**
 *
 *  Basisklasse für die Componenten
 *  @category Egovs
 *  @package  Bkg_VirtualGeo_Model_Components_Component
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2018 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualGeo_Model_Components_Component extends Mage_Core_Model_Abstract
{

    protected $_storeid = 0;

    //alias der Tabelle für die Verbindung zum Produkt
    protected $_productRelationTable = 'virtualgeo/xxx';

    protected $_eventPrefix = 'virtualgeo_components';

    /**
     * Parameter name in event
     *
     * In observe method you can use $observer->getEvent()->getObject() in this case
     *
     * @var string
     */
    protected $_eventObject = 'geo_component';

    public function setStoreId($id)
    {
        $this->_storeid = $id;
        return $this;
    }

    public function getStoreId()
    {
        return $this->_storeid;
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
