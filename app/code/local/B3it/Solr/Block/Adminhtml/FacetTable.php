<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Block_Adminhtml_FacetTable
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Adminhtml_FacetTable extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * B3it_Solr_Block_Adminhtml_FacetTable constructor.
     */
    public function __construct()
    {
        $this->addColumn('attribute', array(
            'label' => $this->__('Attribute Name'),
            'renderer' => $this->_getSearchAttributeRenderer(),
        ));
        $this->addColumn('priority', array(
            'style' => 'width:150px',
            'label' => $this->__('Search Priority'),
            'class' => 'validate-zero-or-greater',
        ));
        $this->addColumn('filter', array(
            'label' => $this->__('Filter'),
            'renderer' => $this->_getAndOrRenderer(),
        ));
        $this->addColumn('extended', array(
            'label' => $this->__('Extended'),
            'renderer' => $this->_getDefaultorRangeRenderer(),
        ));

        $this->_addAfter = false;
        parent::__construct();
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _getAndOrRenderer()
    {
        return Mage::app()->getLayout()->createBlock('b3it_solr/adminhtml_htmlBlocks_andOrSelect', '', array('is_render_to_js_template' => true));
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _getSearchAttributeRenderer()
    {
        return Mage::app()->getLayout()->createBlock('b3it_solr/adminhtml_htmlBlocks_searchAttributesSelect', '', array('is_render_to_js_template' => true));
    }

    /**
     * @return Mage_Core_Block_Abstract
     */
    protected function _getDefaultorRangeRenderer()
    {
        return Mage::app()->getLayout()->createBlock('b3it_solr/adminhtml_htmlBlocks_defaultOrRange', '', array('is_render_to_js_template' => true));
    }

    /**
     * @param Varien_Object $row
     * @return $this|void
     */
    protected function _prepareArrayRow(Varien_Object $row)
    {
        foreach ($row->getData() as $key => $value) {
            $renderer = ($this->_columns[$key]['renderer']) ?? false;

            if ($renderer instanceof Mage_Core_Block_Html_Select) {
                $row->setData('option_extra_attr_' . $renderer->calcOptionHash($row->getData($key)), 'selected="selected"');
            }
        }
        return $this;
    }
}
