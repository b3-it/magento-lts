<?php

class Egovs_Zahlpartnerkonten_Block_Adminhtml_Pool_New_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form(array(
                                      'id' => 'edit_form',
                                      'action' => $this->getUrl('*/*/create'),
                                      'method' => 'post',
        							  'enctype' => 'multipart/form-data'
                                   )
      );
      
      $form->setUseContainer(true);
      $this->setForm($form);
      $fieldset = $form->addFieldset('pool_form', array('legend'=>Mage::helper('zpkonten')->__('Create')));
     
     $fieldset->addField('mandant', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Mandant'),
          'disabled'	=>true,
          'name'      => 'mandant',
     	  'value'	=> Mage::getStoreConfig('payment_services/paymentbase/mandantnr')
      ));
      
      
     $fieldset->addField('bewirtschafter', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Bewirtschafter'),
          'disabled'	=>true,
          'name'      => 'bewirtschafter',
     	'value'	=> Mage::getStoreConfig('payment_services/paymentbase/bewirtschafternr')
      ));
     
     $fieldset->addField('prefix', 'text', array(
     		'label'     => Mage::helper('zpkonten')->__('Präfix'),
     		'disabled'	=>true,
     		'name'      => 'prefix',
     		'value'	=> Mage::getStoreConfig('payment_services/paymentbase/mandanten_kz_prefix')
     ));
     
     $fieldset->addField('checksum', 'select', array(
     		'label'     => Mage::helper('zpkonten')->__('Use checksum'),
     		'disabled'	=>true,
     		'name'      => 'checksum',
     		'value'	=> Mage::getStoreConfigFlag('payment_services/paymentbase/zpkonten_checksum'),
     		'options'	=> array('1' => Mage::helper('adminhtml')->__('Active'), '0' => Mage::helper('adminhtml')->__('Inactive')),
     ));
      
      $fieldset->addField('start', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Start'),
          'class'     => 'validate-digits',
          'required'  => true,
          'name'      => 'start',
      		'value'	=> '1'
      ));
      
      $fieldset->addField('maximum', 'text', array(
          'label'     => Mage::helper('zpkonten')->__('Maximum'),
          'class'     => 'validate-digits',
          'required'  => true,
          'name'      => 'maximum',
      ));
      
      $fieldset->addField('increment', 'text', array(
      		'label'     => Mage::helper('zpkonten')->__('Increment'),
      		'class'     => 'validate-digits',
      		'required'  => true,
      		'name'      => 'increment',
      		'value'	=> '1'
      ));    
    
      return parent::_prepareForm();
  }
  
  private function getCurrency()
  {
  		$curr = Mage::app()->getLocale()->getOptionCurrencies();
  		$res = array();
  		foreach ($curr as $c) {
  			$res[$c['value']] = $c['label'];
  		}
  		
  		return $res;
  }
}