<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Model_Config_Source_Facet
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Model_Config_Source_Facet
{
    /**
     * @return array
     */
    public function toOptionArray()
    {
        /** @var B3it_Solr_Model_Index_Product $model */
        $model = new B3it_Solr_Model_Index_Product();

        $options = [];
        foreach ($model->getSearchableAttributes() as $attribute) {
            $options[Mage::helper('b3it_solr')->__($attribute->getData()['frontend_label'])] = array('value' => $attribute->getData()['attribute_code'], 'label' => Mage::helper('b3it_solr')->__($attribute->getData()['frontend_label']));
        }

        ksort($options);
        return $options;
    }
}
