<?php
/**
 * B3it ConfigCompare
 * 
 * 
 * @category   	B3it
 * @package    	B3it_ConfigCompare
 * @name       	B3it_ConfigCompare_Block_Adminhtml__Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_ConfigCompare_Block_Adminhtml_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * 
     */
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'configcompare';
        $this->_controller = 'adminhtml';
        $this->_mode = 'compare';
    }

    /**
     * 
     * {@inheritDoc}
     * @see Mage_Adminhtml_Block_Widget_Container::getHeaderText()
     */
    public function getHeaderText()
    {
        if( Mage::registry('_data') && Mage::registry('_data')->getId() ) {
            return Mage::helper('configcompare')->__("Compare Item '%s'", $this->escapeHtml(Mage::registry('_data')->getTitle()));
        } else {
            return Mage::helper('configcompare')->__('Add Item');
        }
    }
}