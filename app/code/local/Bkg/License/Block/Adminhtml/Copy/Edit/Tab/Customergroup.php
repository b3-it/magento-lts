<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Customergroup
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Customergroup extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('copyagreement_form', array('legend'=>Mage::helper('bkg_license')->__('Customer Group')));



        $collection = Mage::getModel('bkg_license/copy_customergroup')->getCollection();
        $collection->addCopyIdFilter(Mage::registry('entity_data')->getId());

        $value = array();
       foreach($collection as $item)
       {
           $value[] = $item->getCustomergroupId();
       }

        $values = Mage::getModel('customer/customer_attribute_source_group')->getAllOptions();
        $fieldset->addField('customer_groups', 'multiselect', array(
            'label'     => Mage::helper('bkg_license')->__('Customer Groups'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'customer_groups',
            'values' => $values,
            'value' => $value
        ));


        return parent::_prepareForm();
    }
}
