<?php

class Bkg_Orgunit_Block_Customer_Address_Edit extends Egovs_Base_Block_Customer_Address_Edit {
    public function getNameBlockHtml()
    {
        /**
         * @var Mage_Customer_Block_Widget_Name $nameBlock
         */
        $nameBlock = $this->getLayout()
        ->createBlock('egovsbase/customer_widget_name')
        ->setObject($this->getAddress());
        
        if ($this->getAddress()->getData('org_address_id') !== null) {
            $nameBlock->setFieldParams('disabled="disabled" readonly="readonly"');
        }
        
        return $nameBlock->toHtml();
    }

    public function getCountryHtmlSelect($defValue=null, $name='country_id', $id='country', $title='Country') {
        Varien_Profiler::start('TEST: '.__METHOD__);
        if (is_null($defValue)) {
            $defValue = $this->getCountryId();
        }
        $cacheKey = 'DIRECTORY_COUNTRY_SELECT_STORE_'.Mage::app()->getStore()->getCode();
        if (Mage::app()->useCache('config') && $cache = Mage::app()->loadCache($cacheKey)) {
            $options = unserialize($cache);
        } else {
            $options = $this->getCountryCollection()->toOptionArray();
            if (Mage::app()->useCache('config')) {
                Mage::app()->saveCache(serialize($options), $cacheKey, array('config'));
            }
        }
        // no validate if it is a org address, because it can't be changed there
        $class = '';
        if ($this->getAddress()->getData('org_address_id') !== null) {
            $class .= 'validate-select';
            if ($this->isFieldRequired('country_id')) {
                $class .= ' required-entry';
            }
        }
        /**
         * @var Mage_Core_Block_Html_Select $block
         */
        $block = $this->getLayout()->createBlock('core/html_select');
        $block
        ->setName($name)
        ->setId($id)
        ->setTitle(Mage::helper('directory')->__($title))
        ->setClass($class)
        ->setValue($defValue)
        ->setOptions($options);

        // disable this select on Orgunit
        if ($this->getAddress()->getData('org_address_id') !== null) {
            $block->setExtraParams('disabled="disabled" readonly="readonly"');
        }
        $html = $block
        ->getHtml();
        
        Varien_Profiler::stop('TEST: '.__METHOD__);
        return $html;
    }
}