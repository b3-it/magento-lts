<?php

class Egovs_Extstock_Block_Adminhtml_Catalog_Product_Edit_Tab_Extstock_Order extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('extstock_form', array('legend'=>Mage::helper('extstock')->__('New Stock Order')));
		 
	 $fieldset->addField('mode', 'hidden', array(
          'name'      => 'mode',
	 ));


	 //Damit das Element wirklich required ist muss:
	 //'class'     => 'required-entry'
	 //'required'  => true
	 //hinzugefügt werden!!

	 $fieldset->addField(Egovs_Extstock_Helper_Data::DISTRIBUTOR_EDIT_ID, 'text', array(
          'label'     => Mage::helper('extstock')->__('Distributor'),
          'name'      => Egovs_Extstock_Helper_Data::DISTRIBUTOR_EDIT_ID,
	 ));

	 $fieldset->addField(Egovs_Extstock_Helper_Data::QTY_ORDERED_EDIT_ID, 'text', array(
          'label'     => Mage::helper('extstock')->__('Quantity Ordered'),
          'name'      => Egovs_Extstock_Helper_Data::QTY_ORDERED_EDIT_ID,
	 ));

	 $fieldset->addField(Egovs_Extstock_Helper_Data::COST_EDIT_ID, 'text', array(
          'label'     => Mage::helper('extstock')->__('Cost Price'),
          'name'      => Egovs_Extstock_Helper_Data::COST_EDIT_ID,
	 ));

	 $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
	 $fieldset->addField(Egovs_Extstock_Helper_Data::DATE_ORDERED_EDIT_ID, 'date', array(
          'label'     => Mage::helper('extstock')->__('Order Date'),
     	  'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
          'name'      => Egovs_Extstock_Helper_Data::DATE_ORDERED_EDIT_ID,
     	  'image'  => $this->getSkinUrl('images/grid-cal.gif'),
     	  'format'       => $dateFormatIso,	
	 ));

/*

	 $fieldset->addField(Egovs_Extstock_Helper_Data::STORAGE_EDIT_ID, 'text', array(
          'label'     => Mage::helper('extstock')->__('Storage'),
          'required'  => false,
          'name'      => Egovs_Extstock_Helper_Data::STORAGE_EDIT_ID,
	 ));

	 $fieldset->addField(Egovs_Extstock_Helper_Data::RACK_EDIT_ID, 'text', array(
          'label'     => Mage::helper('extstock')->__('Rack'),
          'required'  => false,
          'name'      => Egovs_Extstock_Helper_Data::RACK_EDIT_ID,
	 ));
	*/  
	  
	 if ( Mage::getSingleton('adminhtml/session')->getExtstockData() )
	 {
	 	$form->setValues(Mage::getSingleton('adminhtml/session')->getExtstockData());
	 	Mage::getSingleton('adminhtml/session')->setExtstockData(null);
	 } elseif ( Mage::registry('extstock_data') ) {
	 	$form->setValues(Mage::registry('extstock_data')->getData());
	 }
	 return parent::_prepareForm();
	}
}