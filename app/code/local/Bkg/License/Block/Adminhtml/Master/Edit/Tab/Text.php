<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Tab_Text
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit_Tab_Text extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('mastertext_form', array('legend'=>Mage::helper('bkg_license')->__(' Master Text information')));


        $fieldset->addField('identifier', 'text', array(
            'label'     => Mage::helper('bkg_license')->__('Bezeichner'),
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



        if ( Mage::getSingleton('adminhtml/session')->getmastertextData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getmastertextData());
            Mage::getSingleton('adminhtml/session')->setmastertextData(null);
        } elseif ( Mage::registry('mastertext_data') ) {
            $form->setValues(Mage::registry('mastertext_data')->getData());
        }
        return parent::_prepareForm();
    }
}
