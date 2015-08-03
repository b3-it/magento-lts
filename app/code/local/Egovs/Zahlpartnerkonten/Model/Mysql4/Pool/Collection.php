<?php

class Egovs_Zahlpartnerkonten_Model_Mysql4_Pool_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	private static $_counter = 0;

	public function _construct()
    {
        parent::_construct();
        $this->_init('zpkonten/pool');
    }
    
    public function nextKassenzeichen($customer,$data)
    {
    	//mt_srand(self::$_counter * microtime());
    	//self::$_counter++;
		//$randval = mt_rand();
    	  	
    	//um Kollisionen zu vermeiden:
    	$sql = "UPDATE zahlpartnerkonten_pool SET ";
    	if($customer->getId())
    	{
    	$sql .= " customer_id=".$customer->getId().",";
    	}
    	$sql .= " email='".$customer->getEmail()."',";
    	$sql .= " status=".Egovs_Zahlpartnerkonten_Model_Status::STATUS_ZPKONTO;
    	$sql .= " ,last_payment='" . $data ['paymentmethod']."'";
    	//$sql .= " ,mandant=".$randval;
		$sql .= " WHERE mandant = '".$data['mandant']."'";
		$sql .= " AND bewirtschafter='".$data['bewirtschafter']."'";
		$sql .= " AND currency='".$data['currency']."' ";
		$sql .= " AND status=".Egovs_Zahlpartnerkonten_Model_Status::STATUS_NEW;
		$sql .= " ORDER BY zpkonten_pool_id";
		$sql .= " LIMIT 1";
   	
    	$this->getConnection()
                ->query($sql);
                
    	
       return $this->loadKassenzeichen($customer,$data);
    }
    
    
    public function loadKassenzeichen($customer,$data)
    {
    	$kz = null;
    	$this->getSelect()
    		->where('status = '.Egovs_Zahlpartnerkonten_Model_Status::STATUS_ZPKONTO)
    		->where('email = ?',$customer->getEmail())
    		->where('mandant = ?',$data['mandant'])
    		->where('bewirtschafter = ?',$data['bewirtschafter'])
    		->where('currency = ?',$data['currency'])
    		//->where('last_payment = ?',$data ['paymentmethod'])
    		;

    	$items = $this->getItems();
    	
    	if(count($items)> 1 )
    	{
    		Mage::throwException("Something get wrong");
    	}
    	
    	foreach ($items as $value) {
    		$kz = $value;
    	}
    	
    	return $kz;
    }
    
 	public function countFreeKassenzeichen($data)
    {
    	$sql = "SELECT * FROM zahlpartnerkonten_pool ";
		$sql .= " WHERE mandant = '".$data['mandant']."'";
		$sql .= " AND bewirtschafter='".$data['bewirtschafter']."'";
		$sql .= " AND currency='".$data['currency']."' ";
		$sql .= " AND status=".Egovs_Zahlpartnerkonten_Model_Status::STATUS_NEW;			

    	$rows = $this->getConnection()->fetchAll($sql);
       	return count($rows);
    }
    
}