<?php
/**
 * Block Grid zum bearbeiten Haushaltsparameter
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Haushaltsparameter_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
    public function __construct() {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'paymentbase';
        $this->_controller = 'adminhtml_haushaltsparameter';
        
        $this->_updateButton('save', 'label', Mage::helper('paymentbase')->__('Save'));
        $this->_updateButton('delete', 'label', Mage::helper('paymentbase')->__('Delete'));
		
			
        $this->_addButton('saveandcontinue', array(
            'label'     => Mage::helper('adminhtml')->__('Save And Continue Edit'),
            'onclick'   => 'saveAndContinueEdit()',
            'class'     => 'save',
        ), -100);

        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('haushaltsparameter_content') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'haushaltsparameter_content');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'haushaltsparameter_content');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
        ";
    }

    /**
     * Liefert den Header text zurück
     * 
     * @return string
     * 
     * @see Mage_Adminhtml_Block_Widget_Container::getHeaderText()
     */
    public function getHeaderText()
    {
        if ( Mage::registry('haushaltsparameter_data') && Mage::registry('haushaltsparameter_data')->getId() ) {
            return Mage::helper('paymentbase')->__("Edit Parameter '%s'", $this->htmlEscape(Mage::registry('haushaltsparameter_data')->getTitle()));
        } else {
            return Mage::helper('paymentbase')->__('Add Haushaltsparameter');
        }
    }
	
	
}