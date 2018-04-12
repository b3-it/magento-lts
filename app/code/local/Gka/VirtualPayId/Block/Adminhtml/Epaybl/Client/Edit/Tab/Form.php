<?php
/**
 *
 * @category   	Gka Virtualpayid
 * @package    	Gka_VirtualPayId
 * @name       	Gka_VirtualPayId_Block_Adminhtml_Epaybl_Client_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_VirtualPayId_Block_Adminhtml_Epaybl_Client_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('epayblclient_form', array('legend'=>Mage::helper('virtualpayid')->__(' Epaybl Client information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('virtualpayid')->__('Title'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'title',
      ));
      $fieldset->addField('client', 'text', array(
          'label'     => Mage::helper('virtualpayid')->__('Client'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'name'      => 'client',
      ));
      
      $fieldset->addField('pay_operator', 'text', array(
      		'label'     => Mage::helper('virtualpayid')->__('Pay Operator'),
      		//'class'     => 'required-entry',
      		//'required'  => true,
      		'name'      => 'pay_operator',
      ));

      
      if ( Mage::getSingleton('adminhtml/session')->getepayblclientData() )
      {
      	$form->setValues(Mage::getSingleton('adminhtml/session')->getepayblclientData());
      	Mage::getSingleton('adminhtml/session')->setepayblclientData(null);
      } elseif ( Mage::registry('epayblclient_data') ) {
      	$form->setValues(Mage::registry('epayblclient_data')->getData());
      }
      $storeGroups = array();
      foreach(Mage::getModel('adminhtml/system_store')->getGroupCollection()  as $storegroup)
      {
      	$storeGroups[] = array('label' => $storegroup->getName(), 'value' =>$storegroup->getId());
      }
      
      $fieldset->addField('stores', 'multiselect', array(
      		'label'     => Mage::helper('virtualpayid')->__('Stores'),
      		//                'required'  => true,
      		'name'      => 'store_groups[]',
      		'values'    => $storeGroups,
      		'value' 	=> Mage::registry('epayblclient_data')->getStores()
      ));
      


     
      return parent::_prepareForm();
  }
}
