<?php

class B3it_Modelhistory_Block_Adminhtml_Settings_New_Form extends Mage_Adminhtml_Block_Widget_Form
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

      $form->addField("model", 'text', array(
          'label'     => Mage::helper('core')->__('Model'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'model',));
      
      
      $form->setUseContainer(true);
      $this->setForm($form);
      
      return parent::_prepareForm();
  }
}