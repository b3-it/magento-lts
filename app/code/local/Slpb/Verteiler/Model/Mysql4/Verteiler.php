<?php

class Slpb_Verteiler_Model_Mysql4_Verteiler extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the verteiler_verteiler_id refers to the key field in your database table.
        $this->_init('verteiler/verteiler', 'verteiler_id');
    }
    
    
   public function updateCustomerRelation($id, $selected,$deleted)
    {
    	if(count($deleted)>0)
    	{
    		$deleted = implode(',', $deleted);
     		$this->_getWriteAdapter()->delete('verteiler_customer','verteiler_id=' . $id .' AND customer_id in ('.$deleted.')' );
    	}
     	$data=array();
     	if(is_array($selected) && (count($selected) >0 ))
     	{
	     	foreach ($selected as $item)
	     	{	
	     		if($item != 'on')
	     		{
	     			//$data[] = array('verteiler_id'=>$id,'customer_id'=>$item);
	     			$sql = "INSERT INTO verteiler_customer (`verteiler_id`,`customer_id`) VALUES (" . $id . "," . $item .");";
	     			$this->_getWriteAdapter()->query($sql);
	     		}
	     	}
	     	
     	}
     	return $this;
    } 
    
    
}