<?php

class Egovs_Import_Model_Adapter_Magento13_Customer  extends Egovs_Import_Model_Adapter_Customer
{
   
	public function readData($conn)
	{
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
		}
	}
    
   
   
}