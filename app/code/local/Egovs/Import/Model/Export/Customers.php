<?php

class Egovs_Import_Model_Export_Customers  extends Varien_Object
{
   
    private $_xml = null;
    
    public function export($fileName)
    {
     	
    	try 
    	{
    		$this->_xml = new DOMDocument('1.0', 'UTF-8');
    		$this->_xml->formatOutput = true;
    		
    		
    		
    		$root = $this->_xml->createElement("customers");
    		$root = $this->_xml->appendChild($root);
    		
    		
    		
    		$customers = Mage::getResourceModel('customer/customer_collection')
            	->addNameToSelect()
            	->addAttributeToSelect('*')
            	;
    		$c = 0;
			$a = 0;
    		foreach($customers as $customer)
    		{
    			$node = $this->_xml->createElement('customer');
    			$node = $root->appendChild($node);
    			$a += $this->writeCustomer($customer, $node);
    			$c++;
    		}
    		
    		file_put_contents($fileName, $this->_xml->saveXML());
    		
    		
			
    	}
    	catch(Exception $ex)
    	{
    		echo "Error: " . $ex->getMessage(); die();
    	}
    	
    	return array('customercount'=>$c, 'addressescount' => $a);
    	
    }
    
    
  	private function writeCustomer(Mage_Customer_Model_Customer $customer, DOMElement $node)
  	{
  		
  		//SELECT concat('$this->writeData($customer,"',attribute_code,'",2);') FROM eav_attribute where entity_type_id = 1
  		//$this->writeData($customer,"base_address",$node);
  		$this->writeData($customer,"company",$node);
  		$this->writeData($customer,"confirmation",$node);
  		$this->writeData($customer,"created_at",$node);
  		$this->writeData($customer,"created_in",$node);
  		//$this->writeData($customer,"default_billing",$node);
  		//$this->writeData($customer,"default_shipping",$node);
  		$this->writeData($customer,"dob",$node);
  		$this->writeData($customer,"email",$node);
  		$this->writeData($customer,"epaybl_customer_id",$node);
  		$this->writeData($customer,"failed_logins",$node);
  		$this->writeData($customer,"firstname",$node);
  		$this->writeData($customer,"gender",$node);
  		$this->writeData($customer,"group_id",$node);
  		$this->writeData($customer,"lastname",$node);
  		$this->writeData($customer,"last_failed_login",$node);
  		$this->writeData($customer,"last_unlock_time",$node);
  		$this->writeData($customer,"middlename",$node);
  		$this->writeData($customer,"osc_customer_id",$node);
  		$this->writeData($customer,"password_hash",$node);
  		$this->writeData($customer,"prefix",$node);
  		$this->writeData($customer,"rp_token",$node);
  		$this->writeData($customer,"rp_token_created_at",$node);
  		$this->writeData($customer,"sepa_additional_data",$node);
  		$this->writeData($customer,"sepa_mandate_id",$node);
  		$this->writeData($customer,"store_id",$node);
  		$this->writeData($customer,"suffix",$node);
  		$this->writeData($customer,"unlock_customer",$node);
  		$this->writeData($customer,"use_group_autoassignment",$node);
  		$this->writeData($customer,"website_id",$node);
  		$this->_appendData('original_id', $customer->getId() , $node);
  		$child = $this->_xml->createElement('addresses');
  		$node->appendChild($child);
  		$a = 0;
  		foreach ($customer->getAddresses() as $address)
  		{
  			$this->writeAddress($address, $customer, $child);
  			$a++;
  		}
  		
  		return $a;
  		
  	}
  	
  	
  	private function writeAddress(Mage_Customer_Model_Address $address, Mage_Customer_Model_Customer $customer,  DOMElement $node)
  	{
  	
  		$child = $this->_xml->createElement('address');
  		$node->appendChild($child);
  		$this->writeData($address,"city",$child);
  		$this->writeData($address,"company",$child);
  		$this->writeData($address,"company2",$child);
  		$this->writeData($address,"company3",$child);
  		$this->writeData($address,"country_id",$child);
  		$this->writeData($address,"email",$child);
  		$this->writeData($address,"fax",$child);
  		$this->writeData($address,"firstname",$child);
  		$this->writeData($address,"lastname",$child);
  		$this->writeData($address,"middlename",$child);
  		$this->writeData($address,"postcode",$child);
  		$this->writeData($address,"prefix",$child);
  		$this->writeData($address,"region",$child);
  		$this->writeData($address,"region_id",$child);
  		$this->writeData($address,"street",$child);
  		$this->writeData($address,"suffix",$child);
  		$this->writeData($address,"tax_id",$child);
  		$this->writeData($address,"telephone",$child);
  		$this->writeData($address,"web",$child);
  		$this->_appendData('original_id', $address->getId() , $child);
  		
  		$this->_appendData('isDefaultBilling', (boolean)( $address->getId() == $customer->getDefaultBilling()), $child);
  		$this->_appendData('isDefaultShipping',(boolean) ( $address->getId() == $customer->getDefaultShipping()), $child);
  		$this->_appendData('isBaseAddress', (boolean) ($address->getId() == $customer->getBaseAddress()), $child);
  		//$this->writeData($customer,"default_billing",$node);
  		//$this->writeData($customer,"default_shipping",$node);
  		
  		
  		
  	
  	}
    
  	private function _appendData($field, $value, DOMElement $parent)
  	{
  		$n = $this->_xml->createElement($field, $value);
  		$parent->appendChild($n);
  		return $n;
  	}
	
  	private function writeData($obj,$field,DOMElement $node)
  	{
  		
  		$val = $obj->getData($field);
  		if($val)
  		{
  			$val = html_entity_decode($val,ENT_COMPAT,'UTF-8');
  			$this->_appendData($field, $val, $node);
  		}
  	}
  	
  	
}