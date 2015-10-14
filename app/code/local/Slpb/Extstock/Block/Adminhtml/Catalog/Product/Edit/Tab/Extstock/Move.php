<?php

class Slpb_Extstock_Block_Adminhtml_Catalog_Product_Edit_Tab_Extstock_Move extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);
		$fieldset = $form->addFieldset('extstock_form', array('legend'=>Mage::helper('extstock')->__('New Stock Movement')));
		 
	 $fieldset->addField('mode', 'hidden', array(
          'name'      => 'mode',
	 ));


	 //Damit das Element wirklich required ist muss:
	 //'class'     => 'required-entry'
	 //'required'  => true
	 //hinzugefügt werden!!

	 $stock = Mage::getSingleton('Slpb_Extstock_Model_Stock');
	 
	 $fieldset->addField('exts_move_source', 'select', array(
          'label'     => Mage::helper('extstock')->__('Source'),
          'name'      => 'exts_move_source',
	 	  'options'	  => $stock->getSourceStockAsOptionsArray(),
	 ));
	 
	$fieldset->addField('exts_move_destination', 'select', array(
          'label'     => Mage::helper('extstock')->__('Destination'),
          'name'      => 'exts_move_destination',
	 	  'options'	  => $stock->getDestinationStockAsOptionsArray(),
	 ));

	 $fieldset->addField('exts_move_qty', 'text', array(
          'label'     => Mage::helper('extstock')->__('Order Quantity'),
          'name'      => 'exts_move_qty',
	 ));


	 $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
	 $fieldset->addField('exts_move_date_ordered', 'date', array(
          'label'     => Mage::helper('extstock')->__('Order Date'),
     	  'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
          'name'      => 'exts_move_date_ordered',
     	  'image'  => $this->getSkinUrl('images/grid-cal.gif'),
     	  'format'       => $dateFormatIso,	
	 ));
	 
	 $fieldset->addField('exts_move_date_desired', 'date', array(
	 		'label'     => Mage::helper('extstock')->__('Desired Date'),
	 		'input_format' => Varien_Date::DATETIME_INTERNAL_FORMAT,
	 		'name'      => 'exts_move_date_desired',
	 		'image'  => $this->getSkinUrl('images/grid-cal.gif'),
	 		'format'       => $dateFormatIso,
	 ));

	$fieldset->addField('exts_move_status', 'select', array(
          'label'     => Mage::helper('extstock')->__('Status'),
          'name'      => 'exts_move_status',
	 	  'options'	  => Slpb_Extstock_Model_Journal::getStatusOptionsArray(),
	 ));
	 
	 
	$fieldset->addField('exts_move_note', 'text', array(
          'label'     => Mage::helper('extstock')->__('Note'),
          'name'      => 'exts_move_note',
	 )); 
	 
	/*
	  
	 if ( Mage::getSingleton('adminhtml/session')->getExtstockData() )
	 {
	 	$form->setValues(Mage::getSingleton('adminhtml/session')->getExtstockData());
	 	Mage::getSingleton('adminhtml/session')->setExtstockData(null);
	 } elseif ( Mage::registry('extstock_data') ) {
	 	$form->setValues(Mage::registry('extstock_data')->getData());
	 }
	 */
	 return parent::_prepareForm();
	}
}