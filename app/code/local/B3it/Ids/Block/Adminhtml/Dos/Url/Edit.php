<?php
/**
 *
 * @category   	B3it Ids
 * @package    	B3it_Ids
 * @name       	B3it_Ids_Block_Adminhtml_Dos_Url_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Ids_Block_Adminhtml_Dos_Url_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'b3it_ids';
        $this->_controller = 'adminhtml_dos_url';

        $this->_updateButton('save', 'label', Mage::helper('b3it_ids')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('b3it_ids')->__('Delete Item'));
/*

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
*/
    }

    public function getHeaderText()
    {
        if( Mage::registry('dosurl_data') && Mage::registry('dosurl_data')->getId() ) {
            return Mage::helper('b3it_ids')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('dosurl_data')->getId()));
        } else {
            return Mage::helper('b3it_ids')->__('Add Item');
        }
    }


}
