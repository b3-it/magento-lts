<?php
/**
 *
 * @category   	Bkg
 * @package    	B3it_Subscription
 * @name       	B3it_Subscription_Model_Periodproduct
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Subscription_Model_Periodproduct extends Mage_Core_Model_Resource_Db_Abstract
{	
    public function _construct()
    {
        parent::_construct();
        $this->_init('b3it_subscription/periodproduct');
    }
    
    public function saveDefault($defaultId, $productId, $storeId)
    {
    	$table = $this->getMainTable();
    	$data=array();
    	$data['is_default'] = '0';
    	$this->_getWriteAdapter()->update($table,$data, "product_id= $productId  AND store_id = $storeId ");
    
    
    	$data['is_default'] = '1';
    	if($defaultId){
    		$this->_getWriteAdapter()->update($table, $data, "product_id= $productId  AND store_id = $storeId AND entity_id = $defaultId ");
    	}
    
    	return $this;
    }
}
