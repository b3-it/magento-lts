<?php

class Egovs_Informationservice_Block_Adminhtml_Requesttype_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
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
      
      
      
            $fieldset = $form->addFieldset('requesttype_form', array('legend'=>Mage::helper('informationservice')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('informationservice')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

     $fieldset->addField('direction', 'select', array(
          'label'     => Mage::helper('informationservice')->__('Status'),
          'name'      => 'direction',
          'values'    => Mage::getModel('informationservice/requesttype')->directionToOptionValueArray(),
      ));
      
      if ( Mage::getSingleton('adminhtml/session')->getInformationserviceData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getInformationserviceData());
          Mage::getSingleton('adminhtml/session')->setInformationserviceData(null);
      } elseif ( Mage::registry('requesttype_data') ) {
          $form->setValues(Mage::registry('requesttype_data')->getData());
      }
      
      return parent::_prepareForm();
  }
}