<?php
 /**
  *
  * @category   	Dwd Ibewi
  * @package    	Dwd_Ibewi
  * @name       	Dwd_Ibewi_Model_Resource_Report_Attribute
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Dwd_Ibewi_Model_Mysql4_Report_Attribute extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('ibewi/report_attribute', 'id');
    }
}
