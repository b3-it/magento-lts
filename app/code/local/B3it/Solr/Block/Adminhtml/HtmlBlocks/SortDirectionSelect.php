<?php

/**
 * @category   B3it
 * @package    B3it_Solr
 * @copyright  Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license    http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Adminhtml_HtmlBlocks_SortDirectionSelect extends Mage_Core_Block_Html_Select
{
    /**
     * @return string
     */
    public function _toHtml()
    {
        $this->addOption('asc', Mage::helper('adminhtml')->__('ASC'));
        $this->addOption('desc', Mage::helper('adminhtml')->__('DESC'));
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
