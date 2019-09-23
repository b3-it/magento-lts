<?php

/**
 * @category    B3it Solr
 * @package     B3it_Solr
 * @name        B3it_Solr_Block_Adminhtml_PriceRangeTable
 * @author      Hana Anastasia Matthes <h.matthes@b3-it.de>
 * @copyright   Copyright (c) 2018 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Adminhtml_PriceRangeTable extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    /**
     * B3it_Solr_Block_Adminhtml_PriceRangeTable constructor.
     */
    public function __construct()
    {
        $this->addColumn('price_min', array(
            'style' => 'width:150px',
            'label' => $this->__('Min'),
            'class' => 'validate-zero-or-greater'
        ));
        $this->addColumn('price_max', array(
            'style' => 'width:150px',
            'label' => $this->__('Max'),
            'class' => 'validate-zero-or-greater'
        ));

        $this->_addAfter = false;
        parent::__construct();
    }
}
