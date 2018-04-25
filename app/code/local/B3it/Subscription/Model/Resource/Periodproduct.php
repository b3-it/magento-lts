<?php
 /**
  *
  * @category   	Bkg
  * @package    	B3it_Subscription
  * @name       	B3it_Subscription_Model_Resource_Periodentity
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class B3it_Subscription_Model_Resource_Periodproduct extends Mage_Core_Model_Resource_Db_Abstract
{
    public function _construct()
    {
        // Note that the id refers to the key field in your database table.
        $this->_init('b3it_subscription/period_product', 'id');
    }
}
