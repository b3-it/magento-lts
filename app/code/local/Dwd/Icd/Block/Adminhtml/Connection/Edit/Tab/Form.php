<?php
/**
 * Dwd Icd
 * 
 * 
 * @category   	Dwd
 * @package    	Dwd_Icd
 * @name       	Dwd_Icd_Block_Adminhtml_Connection_Edit_Tab_Form
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Icd_Block_Adminhtml_Connection_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('connection_form', array('legend'=>Mage::helper('dwd_icd')->__('Item information')));
     
      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('dwd_icd')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));
      
      $fieldset->addField('url', 'text', array(
      		'label'     => Mage::helper('dwd_icd')->__('Url'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'url',
      		'note'	=> Mage::helper('dwd_icd')->__('Maybe you have to specify the port explicit in the url eg. https://my.service.de:443/.')
      ));
      
      $fieldset->addField('user', 'text', array(
      		'label'     => Mage::helper('dwd_icd')->__('User Name'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'user',
      ));
      
      $fieldset->addField('password', 'text', array(
      		'label'     => Mage::helper('dwd_icd')->__('Password'),
      		'class'     => 'required-entry',
      		'required'  => true,
      		'name'      => 'password',
      ));
      
      $fieldset->addField('is_alive', 'checkbox', array(
      		'label'     => Mage::helper('dwd_icd')->__('Test Connection'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'is_alive',
      		'checked'	=> 'checked'
      ));

		
      /*
      $fieldset->addField('status', 'select', array(
          'label'     => Mage::helper('dwd_icd')->__('Status'),
          'name'      => 'status',
          'values'    => array(
              array(
                  'value'     => 1,
                  'label'     => Mage::helper('dwd_icd')->__('Enabled'),
              ),

              array(
                  'value'     => 2,
                  'label'     => Mage::helper('dwd_icd')->__('Disabled'),
              ),
          ),
      ));
     
   */
     
      if ( Mage::getSingleton('adminhtml/session')->getIcdData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getIcdData());
          Mage::getSingleton('adminhtml/session')->setIcdData(null);
      } elseif ( Mage::registry('connection_data') ) {
          $form->setValues(Mage::registry('connection_data')->getData());
      }
      return parent::_prepareForm();
  }
}