<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Block_Adminhtml_Kassenbuch_Cashbox_Edit_Tab_Form
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Block_Adminhtml_Kassenbuch_Cashbox_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('kassenbuchcashbox_form', array('legend'=>Mage::helper('gka_barkasse')->__(' Kassenbuch Cashbox information')));

      $fieldset->addField('title', 'text', array(
          'label'     => Mage::helper('gka_barkasse')->__('Title'),
          'class'     => 'required-entry',
          'required'  => true,
          'name'      => 'title',
      ));

      $fieldset->addField('customer_id', 'select', array(
      		'label'     => Mage::helper('gka_barkasse')->__('User ID'),
      		'class'     => 'required-entry',
	      	'required'  => true,
	      	'name'      => 'customer_id',
	      	'values'    => $this->__getCustomerList()
      ));
      
      
      
      $fieldset->addField('customer', 'text', array(
          'label'     => Mage::helper('gka_barkasse')->__('User Name'),
          //'class'     => 'required-entry',
          //'required'  => true,
          'disabled'	=> true,
          'name'      => 'customer',
      ));
      
      $field =$fieldset->addField('store_id', 'select', array(
      		'name'      => 'store_id',
      		'label'     => Mage::helper('gka_barkasse')->__('Store View'),
      		'title'     => Mage::helper('gka_barkasse')->__('Store View'),
      		'required'  => true,
      		'values'    => Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(false, false),
      ));
      
     


      if ( Mage::getSingleton('adminhtml/session')->getkassenbuchcashboxData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getkassenbuchcashboxData());
          Mage::getSingleton('adminhtml/session')->setkassenbuchcashboxData(null);
      } elseif ( Mage::registry('kassenbuchcashbox_data') ) {
          $form->setValues(Mage::registry('kassenbuchcashbox_data')->getData());
      }
      return parent::_prepareForm();
  }
  
  private function __getCustomerList()
  {
  		$collection = Mage::getResourceModel('customer/customer_collection')
  		->addAttributeToSelect('company')
  		->addAttributeToSelect('store_id')
  		->addAttributeToSelect('email')
  		//->joinField('store_name', 'core/store', 'name', 'store_id=store_id', null, 'left')
  		;

      $res = array();
      $res[0] = Mage::helper('gka_barkasse')->__('-- Please Select --');

      if(Mage::helper('core')->isModuleEnabled('Egovs_Isolation')){

          $storeIds = Mage::helper('isolation')->getUserStoreViews();
          $admin =  Mage::helper('isolation')->getUserIsAdmin();

          foreach($collection->getItems() as $item)
          {
              if(in_array($item->getStoreId(),$storeIds) || $admin) {
                  $res[$item->getEntityId()] = $item->getCompany();
              }
          }
      }
      else{

          foreach($collection->getItems() as $item)
          {
              $res[$item->getEntityId()] = $item->getCompany();
          }

        }


  		;

  		
  		return $res;
  }
}
