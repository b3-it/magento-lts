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
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_Product extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('copyagreement_form', array('legend'=>Mage::helper('bkg_license')->__('Product')));


        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToSelect('name');
        $values = array();
        foreach($collection as $item)
        {
            $values[] = array('value'=> $item->getId(),'label'=> $item->getSku().' '. $item->getName()) ;
        }


        $collection = Mage::getModel('bkg_license/copy_product')->getCollection();
        $collection->addCopyIdFilter(Mage::registry('entity_data')->getId());

        $value = array();
        foreach($collection as $item)
        {
            $value[] = $item->getProductId();
        }



        $fieldset->addField('product', 'multiselect', array(
            'label'     => Mage::helper('bkg_license')->__('Product'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'product',
            'values' => $values,
            'value' => $value
        ));




        return parent::_prepareForm();
    }
}
