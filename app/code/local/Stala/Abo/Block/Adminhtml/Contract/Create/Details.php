<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Adminhtml sales order create sidebar
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */

class Stala_Abo_Block_Adminhtml_Contract_Create_Details extends Stala_Abo_Block_Adminhtml_Contract_Abstract
{
	protected $_customer = null;
	protected $_addresses = null;
 

    
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('abo_contract_form', array('legend'=>Mage::helper('stalaabo')->__('Contract Details')));
     
      $dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_SHORT);
      
      $fieldset->addField('customer_id', 'hidden', array(
          'name'      => 'create_contract[customer_id]',
          'value'    => $this->_getCustomer()->getId(),
      	));
      
      
      $fieldset->addField('from_date', 'date', array(
            'name'   => 'create_contract[from_date]',
            'label'  => Mage::helper('stalaabo')->__('From Date'),
            'title'  => Mage::helper('stalaabo')->__('From Date'),
            'image'  => $this->getSkinUrl('images/grid-cal.gif'),
            'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
            'format'       => $dateFormatIso,
      		'required' => true,
      		//'class' => 'required',
        ));

  
	  
      $fieldset->addField('billing_adr', 'select', array(
          'label'     => Mage::helper('stalaabo')->__('Billing Address'),
          'name'      => 'create_contract[billing_adr]',
          'values'    => $this->AddressesToHashArray(),
      	  'value'	=> $this->_getBillingAdr()
      	));
      	
      $fieldset->addField('shipping_adr', 'select', array(
          'label'     => Mage::helper('stalaabo')->__('Shipping Address'),
          'name'      => 'create_contract[shipping_adr]',
          'values'    => $this->AddressesToHashArray(),
      	  'value'	=> $this->_getShippingAdr()	
      	));
     
  
      return parent::_prepareForm();
  }
    
    
    
  	private function _getStartDate()
  	{
  		return  '';
  	}
    
  	private function _getBillingAdr()
  	{
  		$contr = Mage::getSingleton('adminhtml/session')->getData('abo_contract_create');
  		return  $contr->getBillingAddressId();
  	}
    
  	private function _getShippingAdr()
  	{
  		$contr = Mage::getSingleton('adminhtml/session')->getData('abo_contract_create');
  		return  $contr->getShippingAddressId();
  	}
    
    
    
    private function _getCustomer()
    {
    	if($this->_customer == null)
    	{
    		$contract = Mage::getSingleton('adminhtml/session')->getData('abo_contract_create');
    		$this->_customer = Mage::getModel('customer/customer')->load($contract->getCustomerId());
    	}
    	return $this->_customer;
    }

  
  	
}
