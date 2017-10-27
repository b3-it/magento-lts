<?php
/**
 *
 * @category   	Gka Virtualpayid
 * @package    	Gka_VirtualPayId
 * @name       	Gka_VirtualPayId_Block_Adminhtml_Epaybl_Client_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_VirtualPayId_Block_Adminhtml_Epaybl_Client_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'virtualpayid';
        $this->_controller = 'adminhtml_epaybl_client';

        $this->_updateButton('save', 'label', Mage::helper('virtualpayid')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('virtualpayid')->__('Delete Item'));


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
        if( Mage::registry('epayblclient_data') && Mage::registry('epayblclient_data')->getId() ) {
            return Mage::helper('virtualpayid')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('epayblclient_data')->getId()));
        } else {
            return Mage::helper('virtualpayid')->__('Add Item');
        }
    }


}
