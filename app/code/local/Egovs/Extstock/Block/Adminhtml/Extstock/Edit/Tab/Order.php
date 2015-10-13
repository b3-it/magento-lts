<?php

class Egovs_Extstock_Block_Adminhtml_Extstock_Edit_Tab_Order extends Mage_Adminhtml_Block_Widget_Form
{
	protected $_attributes = array();
	
	public function __construct($attributes = array()) {
		parent::__construct();
		
		$this->_attributes = $attributes;		
	}
	
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('extstock_form', array('legend'=>Mage::helper('extstock')->__('Stock Order')));
		 
		 $fieldset->addField('mode', 'hidden', array(
	          'name'      => 'mode',
		 ));	
	
		 $fieldset->addField('distributor', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Distributor'),
//	          'class'     => 'required-entry',
	          'required'  => true,
	          'name'      => 'distributor',
		 ));
	
		 $fieldset->addField('quantity_ordered', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Order Quantity'),
//	          'class'     => 'required-entry',
	          'required'  => true,
	          'name'      => 'quantity_ordered',
		 ));
	
		 $fieldset->addField('price', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Cost Price'),
//	          'class'     => 'required-entry',
	          'required'  => true,
	          'name'      => 'price',
		 ));
	
		 $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
		 $fieldset->addField('date_ordered', 'date', array(
	        'label'     => Mage::helper('extstock')->__('Order Date'),
//	        'class'     => 'required-entry',
	        'required'  => true,
	     	'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
	        'name'      => 'date_ordered',
	     	'image'  => $this->getSkinUrl('images/grid-cal.gif'),
	     	'format'       => $dateFormatIso	
		 ));

		 $fieldset->addField('storage', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Storage'),
	          'required'  => false,
	          'name'      => 'storage',
		 ));
	
		 $fieldset->addField('rack', 'text', array(
	          'label'     => Mage::helper('extstock')->__('Rack'),
	          'required'  => false,
	          'name'      => 'rack',
		 ));
		 
		 //Wenn man diesen Teil erst nach setValues() aufruft, sollten die alten Werte als Voreinstellung drin stehen!
		 if (array_key_exists(Egovs_Extstock_Helper_Data::REORDER, $this->_attributes)) {
		 	foreach ($fieldset->getElements() as $element) {
		 		if (!$element)
		 			continue;
		 		$id = $element->getId();
		 		$element->setId(Egovs_Extstock_Helper_Data::REORDER."_".$id);
		 		$element->setData('name',$element->getId());
		 		$element->setData('required', false);
		 		$element->setData('class', '');		 		
		 	}
		 }
		 
		 $data = Mage::registry('extstock_data');
		 if($data->getOrigData('status') == Egovs_Extstock_Helper_Data::DELIVERED
		    && !array_key_exists(Egovs_Extstock_Helper_Data::REORDER, $this->_attributes)) {
		 	foreach ($fieldset->getElements() as $element) {
		 		if (!$element)
		 			continue;
		 		$id = $element->getId();
		 		switch ($id) {
		 			case 'storage':
		 				break;
		 			case 'rack':		 				
		 				break;
		 			default :
		 				$element->addData(array('disabled' => true));
		 		}
		 	}
		 }  
	  	
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