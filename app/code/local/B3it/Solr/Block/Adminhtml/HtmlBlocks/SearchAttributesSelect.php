<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Adminhtml_HtmlBlocks_SearchAttributesSelect extends Mage_Core_Block_Html_Select
{
    /**
     * @return string
     */
    public function _toHtml()
    {
        /** @var B3it_Solr_Model_Index_Product $model */
        $model = Mage::getModel('b3it_solr/index_product');

        foreach ($model->getSearchableAttributes() as $attr) {
            $sortArray[Mage::helper('adminhtml')->__($attr->getData('frontend_label'))] = $attr->getData('attribute_code');
        }

        /* Sort based on label */
        unset($attributes);
        ksort($sortArray);

        foreach ($sortArray as $label => $value) {
            $this->addOption($value, $label);
        }

        unset($sortArray);
        return parent::_toHtml();
    }

    /**
     * Needed for AdminConfig list
     *
     * @param $name
     * @return mixed
     */
    public function setInputName($name)
    {
        return $this->setData('name', $name);
    }
}
