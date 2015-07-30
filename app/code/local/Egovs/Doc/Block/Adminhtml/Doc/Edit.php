<?php
/**
 * Verwalten von Dokumenten im Webshop.
 *
 * @category	Egovs
 * @package		Egovs_Doc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Doc_Block_Adminhtml_Doc_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'egovs_doc';
        $this->_controller = 'adminhtml_doc';
        
        $this->_updateButton('save', 'label', Mage::helper('egovs_doc')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('egovs_doc')->__('Delete Item'));
		
       
    }

    public function getHeaderText()
    {
        if( Mage::registry('doc_data') && Mage::registry('doc_data')->getId() ) {
            return Mage::helper('egovs_doc')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('doc_data')->getTitle()));
        } else {
            return Mage::helper('egovs_doc')->__('Add Item');
        }
    }
}