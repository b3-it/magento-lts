<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Toll_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit_Tab_Toll extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('mastertoll_form', array('legend'=>Mage::helper('bkg_license')->__(' Master Toll information')));

        $fieldset->addField('master_id', 'text', array(
            'label'     => Mage::helper('bkg_license')->__(''),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'master_id',
        ));
        $fieldset->addField('fee_code', 'text', array(
            'label'     => Mage::helper('bkg_license')->__('Entgelt'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'fee_code',
        ));
        $fieldset->addField('is_percent', 'text', array(
            'label'     => Mage::helper('bkg_license')->__('In Prozent'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'is_percent',
        ));
        $fieldset->addField('discount', 'text', array(
            'label'     => Mage::helper('bkg_license')->__('Rabatt'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'discount',
        ));



        if ( Mage::getSingleton('adminhtml/session')->getmastertollData() )
        {
            $form->setValues(Mage::getSingleton('adminhtml/session')->getmastertollData());
            Mage::getSingleton('adminhtml/session')->setmastertollData(null);
        } elseif ( Mage::registry('mastertoll_data') ) {
            $form->setValues(Mage::registry('mastertoll_data')->getData());
        }
        return parent::_prepareForm();
    }
}
