<?php
/**
 * Form-Block zum bearbeiten von Buchungslistenparameter
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Block_Adminhtml_Localparams_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Form anpassen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Localparams_Edit_Form
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
				'label'     => Mage::helper('paymentbase')->__('Title'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'title',
		));

		 
		$params= Mage::getModel('paymentbase/defineparams');
		$fieldset->addField('param_id', 'select', array(
				'label'     => Mage::helper('paymentbase')->__('Parameter Name'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'param_id',
				'values'	  => $params->toOptionArray(),
		));


		$fieldset->addField('value', 'text', array(
				'label'     => Mage::helper('paymentbase')->__('Value'),
				'class'     => 'required-entry',
				'required'  => true,
				'name'      => 'value',
		));

		$groups = Mage::getModel('customer/group')->getCollection();
        // Sort by Group Label
        $groups->addOrder('customer_group_code', 'ASC');
		$fieldset->addField('customer_group_id', 'select', array(
				'label'     => Mage::helper('paymentbase')->__('Customer Group'),
				//           'class'     => 'required-entry',
		//           'required'  => true,
				'name'      => 'customer_group_id',
				'values'	  => array_merge(array(array('label' => Mage::helper('paymentbase')->__('All Customer Groups'),'value'=>'-1')), $groups->toOptionArray()),
				//'note'   => $this->__('Leave empty for default'),

		));


		$payment = Mage::getModel('adminhtml/system_config_source_payment_allowedmethods')->toOptionArray();
		array_shift($payment);
		$payment = array_merge(array(array('label' => Mage::helper('paymentbase')->__('All Payment Methods'),'value'=>'all')), $payment);
		$fieldset->addField('payment_method', 'select', array(
				'label'     => Mage::helper('paymentbase')->__('Payment Method'),
				//           'class'     => 'required-entry',
		//           'required'  => true,
				'name'      => 'payment_method',
				'values'	  => $payment,
				//'note'   => $this->__('Leave empty for default'),
		));

		$fieldset->addField('lower', 'text', array(
				'label'     => Mage::helper('paymentbase')->__('Lower Range [Euro] &ge;'),
				'class'     => 'required-entry validate-zero-or-greater',
				'required'  => true,
				'name'      => 'lower',
		));

		$fieldset->addField('upper', 'text', array(
				'label'     => Mage::helper('paymentbase')->__('Upper Range [Euro] &lt;'),
				'class'     => 'validate-zero-or-greater',
				//           'required'  => true,
				'name'      => 'upper',
				'note'   => $this->__('Leave empty for no limit!'),
		));

		/*
		 $fieldset->addField('priority', 'text', array(
		 		'label'     => Mage::helper('paymentbase')->__('Priority'),
		 		'class'     => 'required-entry',
		 		'required'  => true,
		 		'name'      => 'priority',
		 		'value'     => '0'
		 ));
		*/

		$fieldset->addField('status', 'select', array(
				'label'     => Mage::helper('paymentbase')->__('Status'),
				'name'      => 'status',
				'values'    => array(
						array(
								'value'     => 1,
								'label'     => Mage::helper('paymentbase')->__('Enabled'),
						),

						array(
								'value'     => 2,
								'label'     => Mage::helper('paymentbase')->__('Disabled'),
						),
				),
		));
		 
		if ( Mage::getSingleton('adminhtml/session')->getPaymentbaseData() ) {
			$form->setValues(Mage::getSingleton('adminhtml/session')->getPaymentbaseData());
			Mage::getSingleton('adminhtml/session')->setPaymentbaseData(null);
		} elseif ( Mage::registry('localparams_data') ) {
			$form->setValues(Mage::registry('localparams_data')->getData());
		}

		return parent::_prepareForm();
	}
}
