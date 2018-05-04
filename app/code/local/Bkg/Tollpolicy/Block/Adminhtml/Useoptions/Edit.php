<?php
/**
 *
 * @category   	Bkg Tollpolicy
 * @package    	Bkg_Tollpolicy
 * @name       	Bkg_Tollpolicy_Block_Adminhtml_Useoptionsentity_Edit
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_Tollpolicy_Block_Adminhtml_Useoptions_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'bkg_tollpolicy';
        $this->_controller = 'adminhtml_useoptions';

        $this->_updateButton('save', 'label', Mage::helper('bkg_tollpolicy')->__('Save Item'));
        $this->_updateButton('delete', 'label', Mage::helper('bkg_tollpolicy')->__('Delete Item'));


    }

    public function getBackUrl()
    {
        return $this->getUrl('*/tollpolicy_usetype/edit',array('id' => intval($this->getRequest()->getParam('useid'))));
    }

    public function getHeaderText()
    {
        if( Mage::registry('use_options_entity_data') && Mage::registry('use_options_entity_data')->getId() ) {
            return Mage::helper('bkg_tollpolicy')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('use_options_entity_data')->getId()));
        } else {
            return Mage::helper('bkg_tollpolicy')->__('Add Item');
        }
    }


}
