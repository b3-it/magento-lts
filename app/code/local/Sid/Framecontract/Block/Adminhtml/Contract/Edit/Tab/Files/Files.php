<?php

class Sid_Framecontract_Block_Adminhtml_Contract_Edit_Tab_Files_Files extends Mage_Adminhtml_Block_Widget_Form
{
	protected function _prepareForm()
	{
		$form = new Varien_Data_Form();
		$this->setForm($form);

		$fieldset = $form->addFieldset('content_form', array('legend'=>Mage::helper('framecontract')->__('Add New Files')));
		 
		$fieldset->addField('filename1', 'file', array(
          'label'     => Mage::helper('framecontract')->__('Configuration File'),
          'required'  => false,
          'name'      => 'filename1',
		));
		
		$fieldset->addField('filename2', 'file', array(
          'label'     => Mage::helper('framecontract')->__('Information File'),
          'required'  => false,
          'name'      => 'filename2',
		));

		/*
		if ( Mage::getSingleton('adminhtml/session')->getFramecontractData() )
		{
			$form->setValues(Mage::getSingleton('adminhtml/session')->getFramecontractData());
			Mage::getSingleton('adminhtml/session')->setFramecontractData(null);
		} elseif ( Mage::registry('contract_data') ) {
			$form->setValues(Mage::registry('contract_data')->getData());
		}
		*/
		return parent::_prepareForm();
	}
}