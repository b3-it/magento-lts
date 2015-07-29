<?php

class Egovs_Import_Block_Adminhtml_Import_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/importCustomer', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      
      $fieldset = $form->addFieldset('import_form', array('legend'=>Mage::helper('import')->__('Kundenimport')));
       
       
      $fieldset->addField('filename', 'file', array(
      		'label'     => Mage::helper('import')->__('File'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'filename',
      		'value'     => 'D:\develweb\magento1.3.x\var\export\customer.xml'
      ));
      
      
      $websites = Mage::getModel('core/website')->getCollection()->toOptionArray();
      $fieldset->addField('website_id', 'select', array(
      		'name'      => 'website_id',
      		'label'     => Mage::helper('core')->__('Website'),    		
      		'values'    => $websites,

      ));
      
      $stores = Mage::getModel('core/store')->getCollection()->toOptionArray();
      $fieldset->addField('default_store_id', 'select', array(
      		'name'      => 'default_store_id',
      		'label'     => Mage::helper('core')->__('Default Store View'),
      		'values'    => $stores,
      		
      ));
      
      $stores = Mage::getModel('customer/group')->getCollection()->toOptionArray();
      $fieldset->addField('default_group_id', 'select', array(
      		'name'      => 'default_group_id',
      		'label'     => Mage::helper('core')->__('Customer Group'),
      		'values'    => $stores,
      
      ));
      
      $fieldset->addField('submit', 'note',array(
                                'text' => $this->getLayout()->createBlock('adminhtml/widget_button')
                                            ->setData(array(
                                                'label'     => 'Import Kunden',
                                                'onclick'   => 'this.form.submit();',
                                                 'class' => 'form-button'
                                            ))
                                            ->toHtml(),
                            ));
      
      $form->setUseContainer(true);
      $this->setForm($form);
     
      return parent::_prepareForm();
  }
  
   protected function x_afterToHtml($html)
   {
   		return $html .'<div id="message"></div>';
   }
  
}