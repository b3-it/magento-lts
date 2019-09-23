<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Block_Adminhtml_HtmlBlocks_AndOrSelect
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Adminhtml_HtmlBlocks_AndOrSelect extends Mage_Core_Block_Html_Select
{
    /**
     * @return string
     */
    public function _toHtml()
    {
        $this->addOption('2', Mage::helper('adminhtml')->__('None'));
        $this->addOption('0', Mage::helper('adminhtml')->__('Single Select'));
        $this->addOption('1', Mage::helper('adminhtml')->__('Multiple Select'));
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
