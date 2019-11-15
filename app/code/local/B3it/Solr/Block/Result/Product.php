<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Block_Result_Product
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Result_Product extends Mage_Catalog_Block_Product_Abstract
{
    /** @var Mage_Catalog_Model_Product */
    protected $_entity;

    /**
     * @return Mage_Catalog_Block_Product_Abstract
     */
    public function _prepareLayout()
    {
        return parent::_prepareLayout();
    }

    /**
     * @param int $id
     */
    public function loadEntityById($id)
    {
        $this->_entity = Mage::getModel('catalog/product')->load($id);
    }

    /**
     * @return Mage_Catalog_Model_Product
     */
    public function getProduct()
    {
        return $this->_entity;
    }

    /**
     * @param Mage_Catalog_Model_Product $entity
     * @return $this
     */
    public function setProduct($entity)
    {
        $this->_entity = $entity;
        return $this;
    }

    /**
     * @return bool
     */
    public function checkPrice()
    {
        return ($this->_entity->hasData('price') || $this->_entity->hasProductConfig());
    }
}
