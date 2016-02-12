<?php
/**
 * 
 *  Kunden mit Adressen importieren
 *  @category Egovs
 *  @package  Egovs_Import_
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Import_Model_Customers  extends Egovs_Import_Model_Abstract
{
    private $_xml = null;
    
    public function import($config)
    {
     		$content = file_get_contents($config['filename']);
    		
    		$this->_xml = new SimpleXMLElement($content);
    		//$this->_xml = objectsIntoArray($this->_xml);
    		$ver = $this->_verify();
    		if(count($ver) > 0)
    		{
    			throw new Exception((implode('<br>', $ver)));
    		}
    		
    		$i = 0;
    		foreach($this->_xml->customer as $customer )
    		{
    			if($customer)
    			{
    				$this->_importCustomer($customer, $config);
    				$i++;
    			}
    		}
    		
    		return $i;
    	
    }
    
    
  	private function _verify()
  	{
  		$newData = array();
  		
  		foreach($this->_xml->customer as $customer )
  		{
  			if($customer)
  			{
  				$newData[] = (string)$customer->email ;
  			}
  		}
  		
  		
  		$existingData[] = array();
  		$collection = Mage::getResourceModel('customer/customer_collection'); 	
		foreach($collection->getItems() as $item)
		{
			$existingData[] = $item->getEmail();
		}
  		
		$res = array_intersect($newData, $existingData);
  		
		$result = array();
		
		foreach($res as $r)
		{
			$result[] = sprintf("Kunde %s existiert bereits!",$r);
		}
		
		
  		return $result;
  	}
    
	private function _importCustomer($customerData,$config)
    {

    	$customer = Mage::getModel('customer/customer');
    	$customer->setData('email',(string)$customerData->email);
    	$customer->setData('website_id',$config['website_id']);
    	$customer->setData('created_in',$config['default_store_id']);
    	$customer->setData('store_id',$config['default_store_id']);
    	$customer->setData('group_id',$config['default_group_id']);
    	$customer->setPasswordHash($customer->hashPassword($customer->generatePassword(8)));
    	
    	$keys = array('company','confirmation','created_at','dob','email','epaybl_customer_id','firstname','gender','lastname','middlename','prefix','sepa_additional_data','sepa_mandate_id','suffix');
    	foreach($keys as $key)
    	{
    		$customer->setData($key,(string)$customerData->$key);
    	}
    	$customer->save();
    	
    	$hash = (string)$customerData->password_hash;
    	if(strlen($hash) > 1)
    	{
    		$customer->setData('password_hash', $hash);
    		$customer->getResource()->saveAttribute($customer, 'password_hash');
    	}
    	
    	foreach ($customerData->addresses as $adr)
    	{
    		$address = $this->_importAddresses($adr->address, $customer);
    		if($address->getData('isDefaultBilling') == '1'){
    			$customer->setDefaultBilling($address->getId());
    			$customer->getResource()->saveAttribute($customer, 'default_billing');
    		}
    		
    		if($address->getData('isDefaultShipping') == '1'){
    			$customer->setDefaultShipping($address->getId());
    			$customer->getResource()->saveAttribute($customer, 'default_shipping');
    		}
    		
    		if($address->getData('isBaseAddress') == '1'){
    			$customer->setBaseAddress($address->getId());
    			$customer->getResource()->saveAttribute($customer, 'base_address');
    		}   		
    	}  
    }
    
    private function _importAddresses($addressData, $customer)
    {
    	$address = Mage::getModel('customer/address');
    	$address->setCustomerId($customer->getId());
    	
    	$keys = array('isDefaultBilling','isDefaultShipping','isBaseAddress','city','company','company2','company3','country_id','email','fax','firstname','lastname','middlename','postcode','prefix','region','region_id','street','suffix','tax_id','telephone','web');
    	
    	foreach($keys as $key)
    	{
    		$address->setData($key,(string)$addressData->$key);
    	}
    	
    	
    	
    	$address->save();
    	return $address;
    	
    }
}