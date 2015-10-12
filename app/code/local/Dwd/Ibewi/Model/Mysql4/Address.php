<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Model_Mysql4_Access
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_Ibewi_Model_Mysql4_Address extends Mage_Core_Model_Mysql4_Abstract
{
    public function _construct()
    {    
        // Note that the ibewi_access_id refers to the key field in your database table.
        $this->_init('sales/order_address', 'entity_id');
    }
}