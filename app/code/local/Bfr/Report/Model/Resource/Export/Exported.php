<?php
 /**
  *
  * @category   	Bfr Report
  * @package    	Bfr_Report
  * @name       	Bfr_Report_Model_Resource_Export_Exported
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Bfr_Report_Model_Resource_Export_Exported extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('bfr_report/export_exported', 'id');
    }
    
    //alle gleichzeitig einfügen
    public function saveHistory($orderIds, $user)
    {
    	 
    	foreach ($orderIds as $order)
    	{
    		$data[] = array('exported_by'=>$user,'order_id'=>$order);
    	}
    	$this->_getWriteAdapter()->delete($this->getTable('bfr_report/export_exported'),array('order_id'=>$orderIds));
    	$this->_getWriteAdapter()->insertMultiple($this->getTable('bfr_report/export_exported'), $data);
    }
}
