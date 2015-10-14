<?php

class Dimdi_Import_Model_Customer 
{
    
    
    public function run($conn)
    {
     	
    	try 
    	{
    		$this->customer($conn);
    	}
    	catch(Exception $ex)
    	{
    		echo "Error: " . $ex->getMessage(); die();
    	}
    	//$this->showLinks($from);
    }
    
    
  
    
	private function customer($conn)
    {
    	$STORE = 1;
    	$WEBSITE = 1;
    	$CREATE_IN = 'Deutsch';
    	$KGRUPPE_FIRMA = 11;
    	$KGRUPPE_PRIVAT = 1;
    	
    	//auf duplikate prüfen
		$res = $conn->fetchAll("SELECT customers_email_address FROM customers WHERE customers_flagmigration = 1 group by customers_email_address having count(customers_email_address) > 1 ");
		if(count($res) > 0)
		{
			$txt = "doppelte Logins (Email Adressen):<br>";
			foreach($res as $email)
			{
				$txt .= $email['customers_email_address']." <br>";
			}
			die($txt);
		}
		
		
		
		
		$res = $conn->fetchAll("SELECT * FROM customers WHERE customers_flagmigration = 1");
		$i = 0;
		//osc spalten:
    	//customers_id, customers_gender, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_default_address_id, 
    	//customers_telephone, customers_fax, customers_password, customers_newsletter, customers_flagmigration	
		foreach($res as $row)
		{
			$i++;
			$customer = Mage::getModel('customer/customer');
			$customer->setData('osc_customer_id',$row['customers_id']);
			$customer->setData('created_in',$CREATE_IN);
			$customer->setData('use_zpkonto',1);
			$email = $row['customers_email_address'];
			if(strlen($email) < 3)
			{
				$email = $row['customers_id'] . '@dummy.dimdi.org';
			}
			$customer->setData('email',$email);
			
			$customer->setData('firstname',$row['customers_firstname']);
			
			$customer->setData('group_id',$KGRUPPE_PRIVAT);
			$customer->setData('lastname',$row['customers_lastname']);
			$pass = $row['customers_password'];
			if(strlen($pass) > 1)
			{
				$customer->setData('password_hash',$pass);
			}
			//$customer->setData('prefix',trim($row['PERSON_TITLE'].' '.$row['ACADEMIC_TITLE']));
			$customer->setData('store_id',$STORE);
			$customer->setData('website_id',$WEBSITE);
    		if($row['customers_gender'] == 'f')
    		{
    			$customer->setPrefix('Frau');
    		}
    		else
    		{
    			$customer->setPrefix('Herr');
    		}
			
			$customer->save();
    		
    		
			//Adressen holen
    		//osc spalten:
    		//address_book_id, customers_id, entry_gender, entry_company, entry_firstname, entry_lastname, 
    		//entry_street_address, entry_street_address_2, entry_suburb, entry_postcode, entry_city, entry_state, entry_country_id, entry_zone_id, address_book_flagmigration
    		$addresses = $conn->fetchAll("SELECT address_book.*, countries.countries_iso_code_2 as country_id FROM address_book
											left join countries on address_book.entry_country_id = countries_id
											WHERE address_book_flagmigration = 1 AND address_book.customers_id = ".$row['customers_id']);
			foreach($addresses as $adr)
			{
				$address = Mage::getModel('customer/address');
    			$address->setCustomerId($customer->getId());
    			$address->setData('osc_address_id',$adr['address_book_id']);
    			$address->setData('city',$adr['entry_city']);
    			$address->setData('company',$adr['entry_street_address_2']);
				//$adr->setData('company2',$rowAdr['ADDRESS2']);
				//$adr->setData('company3',$rowAdr['ADDRESS3']);
				$address->setData('country_id',$adr['country_id']);
				//$adr->setData('prefix',trim($row['PERSON_TITLE'].' '.$row['ACADEMIC_TITLE']));
				$address->setData('firstname',$adr['entry_firstname']);
				$address->setData('lastname',$adr['entry_lastname']);
				$address->setData('postcode',$adr['entry_postcode']);
				$street = $adr['entry_street_address'];
				/*
				if(strlen($adr['entry_street_address_2']) > 0)
				{
					$street .= "\n" . $adr['entry_street_address_2'];
				}
				*/
				$address->setData('street',$street);
				
				if(strlen($row['customers_email_address'])>0){
					$address->setData('email','*'.$row['customers_email_address']);
				}
				
				if(strlen($row['customers_fax'])>0){
					$address->setData('fax','*'.$row['customers_fax']);
				}
				if(strlen($row['customers_telephone'])>0){
					$address->setData('telephone','*'.$row['customers_telephone']);
				}
				if($adr['entry_gender'] == 'f')
	    		{
	    			$address->setPrefix('Frau');
	    		}
	    		else
	    		{
	    			$address->setPrefix('Herr');
	    		}
				$address->save();
				if($adr['address_book_id'] == $row['customers_default_address_id'])
				{
					$customer->setDefaultShipping($address->getId());
    				$customer->setDefaultBilling($address->getId());
    				if(strlen($adr['entry_street_address_2'])> 1)
    				{
    					$customer->setData('group_id',$KGRUPPE_FIRMA);
						$customer->setData('company',$adr['entry_street_address_2']);
    				}
    				$customer->save();
				}
    		}
    		
		}
		echo $i . " Kunden importiert!";
    }
}