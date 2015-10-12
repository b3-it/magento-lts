<?php

class Dwd_Stationen_Block_Adminhtml_Import_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
  	
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/import', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );


     
    $fieldset = $form->addFieldset('import_form', array('legend'=>Mage::helper('stationen')->__('Import Details')));
     
     
    $fieldset->addField('import_file', 'file', array(
          'label'     => Mage::helper('stationen')->__('File'),
          'required'  => false,
          'name'      => 'import_file',
	  ));
      
      $form->setUseContainer(true);
      $this->setForm($form);
     
      return parent::_prepareForm();
  }
  
 
  
  
}