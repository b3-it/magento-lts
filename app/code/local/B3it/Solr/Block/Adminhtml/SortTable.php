<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Block_Adminhtml_SortTable
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Adminhtml_SortTable extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * B3it_Solr_Block_Adminhtml_SortTable constructor.
     */
    public function __construct()
    {
        $this->addColumn('attribute', array(
            'label' => $this->__('Attribute Name'),
            'renderer' => $this->_getSearchAttributeRenderer(),
        ));

        /*$this->addColumn('sortDirection', array(
            'label' => $this->__('Sort Direction'),
            'renderer' => $this->_getSortDirectionRenderer(),
        ));

        $this->addColumn('title', array(
            'label' => $this->__('Frontend Label'),
            'class' => '',
        ));*/

        $this->_addAfter = false;
        parent::__construct();
    }

    /**
     * @return B3it_Solr_Block_Adminhtml_HtmlBlocks_SearchAttributesSelect|Mage_Core_Block_Abstract
     */
    protected function _getSearchAttributeRenderer()
    {
        return Mage::app()->getLayout()->createBlock('b3it_solr/adminhtml_htmlBlocks_searchAttributesSelect', '', array('is_render_to_js_template' => true));
    }

    /**
     * @return B3it_Solr_Block_Adminhtml_HtmlBlocks_SortDirectionSelect|Mage_Core_Block_Abstract
     */
    protected function _getSortDirectionRenderer()
    {
        return Mage::app()->getLayout()->createBlock('b3it_solr/adminhtml_htmlBlocks_sortDirectionSelect', '', array('is_render_to_js_template' => true));
    }

    /**
     * @param Varien_Object $row
     * @return $this|void
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
        foreach ($row->getData() as $key => $value) {
            if (!isset($this->_columns[$key]) || empty($this->_columns[$key]['renderer'])) {
                continue;
            }
            $row->setData(
                'option_extra_attr_' . $this->_columns[$key]['renderer']
                    ->calcOptionHash($row->getData($key)),
                'selected="selected"'
            );
        }
        return $this;
    }
}
