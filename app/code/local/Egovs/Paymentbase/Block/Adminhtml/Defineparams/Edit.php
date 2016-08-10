<?php
/**
 * Block Grid zum bearbeiten von Basis-Buchunslistenparametern
 * 
 * Dienen als Grundauswahl
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Defineparams_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
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
        $this->_controller = 'adminhtml_defineparams';
        
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
        
        /**
         * 
         * @var Egovs_Paymentbase_Model_Mysql4_Defineparams_Collection $collection
         */
        $collection = Mage::getModel('paymentbase/localparams')->getCollection();
        $data = Mage::registry('defineparams_data')->getData();
        if (($data) && (isset($data['param_id']))) {
        	$collection->addFieldToFilter('param_id', $data['param_id']);
        	if($collection->count() > 0){
        		$this->_removeButton('delete');
        	}
        }
       
    }

    /**
     * Liefert den Header text zurück
     *
     * @return string
     *
     * @see Mage_Adminhtml_Block_Widget_Container::getHeaderText()
     */
    public function getHeaderText() {
        if ( Mage::registry('defineparams_data') && Mage::registry('defineparams_data')->getId() ) {
            return Mage::helper('paymentbase')->__("Edit ePayment Parameter '%s'", $this->htmlEscape(Mage::registry('defineparams_data')->getTitle()));
        } else {
            return Mage::helper('paymentbase')->__('Add ePayment Parameter');
        }
    }
    
    /**
     * Layout anpassen
     * 
     * @return Egovs_Paymentbase_Block_Adminhtml_Defineparams_Edit
     * 
     * @see Mage_Adminhtml_Block_Widget_Form_Container::_prepareLayout()
     */
    protected function _prepareLayout() {
    	parent::_prepareLayout();
    
    	$localParams = Mage::getModel('paymentbase/localparams');
    	 
    	$this->getMessagesBlock()->addNotice($this->__("Parameter IDs bitte entsprechend Mandantenkonfiguration der ePay-BL vornehmen (Übereinstimmung mit Einstellung der Zahlplattform erforderlich)!"));
    	$this->getMessagesBlock()->addNotice($this->__("Parameter ID für 'Kennzeichen Mahnverfahren' lautet: %s", $localParams->getKennzeichenMahnverfahrenCode()));
    	 
    	return $this;
    }	
	
}