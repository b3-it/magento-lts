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

class Stala_Abo_Block_Adminhtml_Contract_Abstract extends Mage_Adminhtml_Block_Widget_Form
{
	protected $_customer = null;
	protected $_addresses = null;
 

    
    
    
	  protected function AddressesToHashArray()
	  {
	  	$res = array();
	  	foreach ($this->getCustomerAddresses() as $adr)
	  	{
	  		$street = implode(" ",  $adr->getStreet()) ;
	  		$s = trim($adr->getCompany(). " " .$adr->getCompany2(). " " . $adr->getCompany3(). " " .$adr->getFirstname() . " " . $adr->getLastname(). " " .$street. " ". $adr->getCity());
	  		$res[] = array('value'=>$adr->getId(), 'label' => $s);
	  		
	  	}
	  	return $res;
	  }
    
    
    protected function getAddressById($id)
    {
    	foreach ($this->getCustomerAddresses() as $adr)
	  	{
	  		if($adr->getId() == $id)
	  		{
		  		$street = implode(" ",  $adr->getStreet()) ;
		  		$s = trim($adr->getCompany(). " " . $adr->getCompany2(). " " .$adr->getCompany3(). " " .$adr->getFirstname() . " " . $adr->getLastname(). " " .$street. " ". $adr->getCity());
		  		return  $s;
	  		}
	  	}
	  	return '';
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

    public function getCustomer()
    {
    	return $this->_getCustomer();
    }
    
    public function getCustomerTitle()
    {
    	$s = $this->_getCustomer()->getCompany()." " . $this->_getCustomer()->getFirstname() . " " . $this->_getCustomer()->getLastname();
    	return trim($s);
    }
    
    
    public function getCustomerAddresses()
    {
    	if($this->_addresses == null)
    	{
			$this->_addresses = Mage::getModel('customer/address')
				->getCollection()
				->setCustomerFilter($this->_getCustomer())
				->addAttributeToSelect('Company')
				->addAttributeToSelect('Company2')
				->addAttributeToSelect('Company3')
				->addAttributeToSelect('firstname')
				->addAttributeToSelect('lastname')
				->addAttributeToSelect('street')
				->addAttributeToSelect('city')
				->getItems();
				
    	}
    	
    	return $this->_addresses;
    }
  	
}
