<?php
/**
 * Block zum bearbeiten von Buchungslistenparametern
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Localparams_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_controller = 'adminhtml_localparams';
        
        $this->_updateButton('save', 'label', Mage::helper('paymentbase')->__('Save Parameter'));
        $this->_updateButton('delete', 'label', Mage::helper('paymentbase')->__('Delete Parameter'));
		
			
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
    
    /* protected function _prepareLayout() {
    	parent::_prepareLayout();
    	 
    	$localParams = Mage::getModel('paymentbase/localparams');
    	
    	$this->getMessagesBlock()->addNotice($this->__("Parameter IDs bitte entsprechend Mandantenkonfiguration der ePay-BL vornehmen (Übereinstimmung mit Einstellung der Zahlplattform erforderlich)!"));
    	$this->getMessagesBlock()->addNotice($this->__("Parameter ID für 'Kennzeichen Mahnverfahren' lautet: %s", $localParams->getKennzeichenMahnverfahrenCode()));
    	    	 
    	return $this;
    } */

    /**
     * Leifert Text für Header zurück
     * 
     * @return string
     * 
     * @see Mage_Adminhtml_Block_Widget_Container::getHeaderText()
     */
    public function getHeaderText() {
        if ( Mage::registry('localparams_data') && Mage::registry('localparams_data')->getId() ) {
            return Mage::helper('paymentbase')->__("Edit ePayment Parameter '%s'", $this->htmlEscape(Mage::registry('localparams_data')->getTitle()));
        } else {
            return Mage::helper('paymentbase')->__('Add ePayment Parameter');
        }
    }
	
	
}