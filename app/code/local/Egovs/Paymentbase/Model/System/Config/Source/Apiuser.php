<?php

class Egovs_Paymentbase_Model_System_Config_Source_Apiuser
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	
    	$collection = Mage::getModel('api/user')->getCollection();
    	$collection->getSelect()
    		->join(array('role'=>'api_role'),"role.user_id=main_table.user_id AND role.role_type='U'")
    		->join(array('rule'=>'api_rule'),"rule.role_id=role.parent_id")
    		->where("resource_id='payplacepaypage_callback/notify'")
    		->where("api_permission='allow'")
    		->where('main_table.is_active=1');
    	
    	
    	//die($collection->getSelect()->__toString());
    	
    	$res = array();
    	
    	foreach ($collection->getItems() as $item)
    	{
    		$res[] =  array('value' => $item->getUserId(), 'label'=>$item->getUsername());
    	}
    	
        return $res;
    }

}
