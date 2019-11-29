<?php

/**
 * @category    B3it
 * @package     B3it_Solr
 * @copyright   Copyright (c) 2019 B3 It Systeme GmbH - http://www.b3-it.de
 * @license     http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Solr_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Container
{
    /**
     * B3it_Solr_Block_Adminhtml_Edit constructor.
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml';
        $this->_headerText = Mage::helper('b3it_solr')->__('Solr Search');

        parent::__construct();
    }
}
