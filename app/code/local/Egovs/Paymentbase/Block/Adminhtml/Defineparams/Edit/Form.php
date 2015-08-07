<?php
/**
 * Form-Block für neue Basis-Buchungslistenparameter
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Defineparams_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Form anpasen
	 *
	 * @return Egovs_Paymentbase_Block_Adminhtml_Defineparams_Edit_Form
	 */
	protected function _prepareForm() {
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
				'method' => 'post',
				'enctype' => 'multipart/form-data'
			)
		);

		$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldset('localparams_form', array('legend'=>Mage::helper('paymentbase')->__('ePayment Parameter')));
		 
		$fieldset->addField('title', 'text', array(
				'label'     => Mage::helper('paymentbase')->__('Name'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'title',
		));

		 

		$fieldset->addField('ident', 'text', array(
				'label'     => Mage::helper('paymentbase')->__('Parameter ID'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'ident',
		));



		 
		if ( Mage::getSingleton('adminhtml/session')->getPaymentbaseData() ) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getPaymentbaseData());
			Mage::getSingleton('adminhtml/session')->setPaymentbaseData(null);
		} elseif ( Mage::registry('defineparams_data') ) {
			$form->setValues(Mage::registry('defineparams_data')->getData());
		}

		return parent::_prepareForm();
	}
}