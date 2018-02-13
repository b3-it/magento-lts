<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Master_Edit_Tab_Customergroup
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Master_Edit_Tab_Products extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset('masteragreement_form', array('legend'=>Mage::helper('bkg_license')->__('Products')));


        $collection = Mage::getModel('catalog/product')->getCollection();
        $collection->addAttributeToSelect('name');
        $values = array();
        foreach($collection as $item)
        {
            $values[] = array('value'=> $item->getId(),'label'=> $item->getSku().' '. $item->getName()) ;
        }


        $collection = Mage::getModel('bkg_license/master_products')->getCollection();
        $collection->addMasterIdFilter(Mage::registry('entity_data')->getId());

        $value = array();
        foreach($collection as $item)
        {
            $value[] = $item->getProductId();
        }



        $fieldset->addField('products', 'multiselect', array(
            'label'     => Mage::helper('bkg_license')->__('Products'),
            //'class'     => 'required-entry',
            //'required'  => true,
            'name'      => 'products',
            'values' => $values,
            'value' => $value
        ));




        return parent::_prepareForm();
    }
}
