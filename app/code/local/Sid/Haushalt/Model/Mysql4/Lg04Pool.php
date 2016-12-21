<?php
/**
 * Sid Haushalt
 *
 *
 * @category   	Sid
 * @package    	Sid_Haushalt
 * @name       	Sid_Haushalt_Model_Resource_Lg04Pool
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Haushalt_Model_Mysql4_Lg04Pool extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the haushalt_lg04pool_id refers to the key field in your database table.
        $this->_init('sidhaushalt/lg04pool', 'haushalt_lg04pool_id');
    }
    
    
    public function getLast()
    {
    	$read = $this->_getReadAdapter();
    	$sql = "SELECT max(lg_04_increment_id) as `lg_04_increment_id` FROM ".$this->getMainTable().";";
    	$data = $read->fetchOne($sql);
    		
    	if ($data)
    	{
    		return $data;
    	}
    	
    	return null;
    }
 
}
