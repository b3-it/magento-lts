<?php

class Egovs_Extnewsletter_Block_Adminhtml_Issue_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      $form->setUseContainer(true);
      $this->setForm($form);
      
      $fieldset = $form->addFieldset('issue_form', array('legend'=>Mage::helper('extnewsletter')->__('Issue information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('extnewsletter')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      
     $fieldset->addField('remarks', 'text', array(
          'label'     => Mage::helper('extnewsletter')->__('Remarks'),
          'name'      => 'remarks',
      ));
     
     $fieldset->addField('remove_subscriber_after_send', 'select', array(
     		'label'     => Mage::helper('extnewsletter')->__('Remove subscriber after send'),
     		'name'      => 'remove_subscriber_after_send',
     		'values'	=> Mage::getSingleton('adminhtml/system_config_source_yesno')->toOptionArray()
     ));

	$readonly = $this->getRequest()->getParam('id')!=null;
      
     $value = Mage::getModel('core/store')->getCollection()->toOptionArray();
	 $value[] = array('value'=>0,'label'=>Mage::helper('extnewsletter')->__('All'));
	 $stores = new Varien_Object(array('values' => $value));
	
	 Mage::dispatchEvent('egovs_adminhtlm_block_stores_load', array('stores' => $stores));
	 $value = $stores->getValues();
     $fieldset->addField('store_id', 'select', array(
          'label'     => Mage::helper('extnewsletter')->__('Store'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'readonly' => $readonly,
     	  'disabled' => $readonly,	
          'name'      => 'store_id',
     	  'values'	 => $value,	
      ));

   
     $form->setValues(Mage::registry('issue_data')->getData());
     
      
      
      
      return parent::_prepareForm();
  }
}