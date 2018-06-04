<?php

class Bfr_EventManager_Block_Adminhtml_ToCms_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
	/**
	 * Form anpasen
	 * 
	 * @return Egovs_Paymentbase_Block_Adminhtml_Localparams_New_Form
	 * 
	 */
	protected function _prepareForm() {
		$form = new Varien_Data_Form(array(
				'id' => 'edit_form',
				'action' => $this->getUrl('*/*/create'),
				'method' => 'post',
				'enctype' => 'multipart/form-data'
		)
		);

		$form->setUseContainer(true);
		$this->setForm($form);
		$fieldset = $form->addFieldset('localparams_form', array('legend'=>Mage::helper('eventmanager')->__('Copy To CMS')));

		$options = Mage::getModel('core/store')->getCollection()->toOptionArray();
		$fieldset->addField('event_id', 'hidden', array(
				'name'      => 'event_id',
				'value'	=> $this->getRequest()->getParam('id'),
		
		));
		$fieldset->addField('store_id', 'select', array(
				'label'     => Mage::helper('eventmanager')->__('Store'),
				//'class'     => 'required-entry',
				//'required'  => true,
		
				'name'      => 'store_id',
				'values'	=> $options,
				
		));
        
		return parent::_prepareForm();
	}

    
}