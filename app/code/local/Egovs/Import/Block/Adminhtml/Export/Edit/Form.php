<?php

class Egovs_Import_Block_Adminhtml_Export_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/export', array('id' => $this->getRequest()->getParam('id'))),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );

      /*
     $fieldset = $form->addFieldset('import_form1', array('legend'=>Mage::helper('import')->__('Verzeichnisse')));
     
     $dir = Mage::getBaseDir('var').'/import';   
     
     $fieldset->addField('l1', 'label', array(
     	'label' => "Verzeichnis für Bilder",
     	'value'     => Mage::helper('import')->__($dir),
     ));
     
     $fieldset->addField('l2', 'label', array(
     	'label' => "Verzeichnis für Downloads",
     	'value'     => Mage::helper('import')->__($dir."\\download\\"),
     ));
     */
     /*
    $fieldset = $form->addFieldset('import_form', array('legend'=>Mage::helper('import')->__('Database Connection')));
     
     
     $fieldset->addField('host', 'text', array(
          'label'     => Mage::helper('import')->__('Host'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'host',
          'value' => 'localhost'
      ));
      
      $fieldset->addField('dbname', 'text', array(
          'label'     => Mage::helper('import')->__('Database'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'dbname',
      	  'value' => 'dimdi'
      ));
      
      $fieldset->addField('username', 'text', array(
          'label'     => Mage::helper('import')->__('User'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'username',
      	  'value' => 'root'
      ));
      
      $fieldset->addField('password', 'text', array(
          'label'     => Mage::helper('import')->__('Password'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'password',
      ));
      
      $fieldset->addField('sourcetype', 'select', array(
      		'label'     => Mage::helper('import')->__('Source Type'),
      		'name'      => 'sourcetype',
      		'options' => Egovs_Import_Model_Sourcetype::getOptionArray()
      ));
      */
      
      $fieldset = $form->addFieldset('export_form', array('legend'=>Mage::helper('import')->__('File')));
       
       
      $fieldset->addField('filename', 'text', array(
      		'label'     => Mage::helper('import')->__('File'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'filename',
      		//'value' => 'D:\develweb\magento1.3.x\var\export\customer.xml'
      ));
      
      
      
      $form->setUseContainer(true);
      $this->setForm($form);
     
      return parent::_prepareForm();
  }
  
   protected function _afterToHtml($html)
   {
   		return $html .'<div id="message"></div>';
   }
  
}