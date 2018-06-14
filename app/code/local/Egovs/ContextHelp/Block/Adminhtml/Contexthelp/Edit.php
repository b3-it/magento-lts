<?php
/**
 *
 * @category   	Egovs ContextHelp
 * @package    	Egovs_ContextHelp
 * @name       	Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Block_Adminhtml_Contexthelp_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'contexthelp';
        $this->_controller = 'adminhtml_contexthelp';

        $this->_updateButton('save', 'label', Mage::helper('contexthelp')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('contexthelp')->__('Delete Item'));


        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    public function getHeaderText()
    {
        if( Mage::registry('contexthelp_data') && Mage::registry('contexthelp_data')->getId() ) {
            $_id    = Mage::registry('contexthelp_data')->getId();
            $_title = Mage::registry('contexthelp_data')->getTitle();
            
            return Mage::helper('contexthelp')->__( "Edit Item '%s'", $this->escapeHtml('(' . $_id . ') ' . $_title) );
        } else {
            return Mage::helper('contexthelp')->__('Add Item');
        }
    }


}
