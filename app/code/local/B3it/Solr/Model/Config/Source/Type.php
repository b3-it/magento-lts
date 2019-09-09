<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Model_Config_Source_Type
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Config_Source_Type
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        /** @var Mage_Catalog_Model_Product_Type $model */
        $model = Mage::getModel('catalog/product_type');

        $options = [];
        foreach ($model->getOptionArray() as $key => $value) {
            $options[] = array('value' => $key, 'label' => $value);
        }

        return $options;
    }
}
