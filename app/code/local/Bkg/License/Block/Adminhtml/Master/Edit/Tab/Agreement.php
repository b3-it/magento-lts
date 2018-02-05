<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Tab_Agreement
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit_Tab_Agreement extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('masteragreement_form', array('legend'=>Mage::helper('bkg_license')->__(' Master Agreement information')));


        $fieldset->addField('identifier', 'text', array(
            'label'     => Mage::helper('bkg_license')->__('Bestellbedingungen'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'identifier',
        ));
        $fieldset->addField('pos', 'text', array(
            'label'     => Mage::helper('bkg_license')->__('Position'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'pos',
        ));



        if ( Mage::getSingleton('adminhtml/session')->getmasteragreementData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getmasteragreementData());
            Mage::getSingleton('adminhtml/session')->setmasteragreementData(null);
        } elseif ( Mage::registry('masteragreement_data') ) {
            $form->setValues(Mage::registry('masteragreement_data')->getData());
        }
        return parent::_prepareForm();
    }
}
