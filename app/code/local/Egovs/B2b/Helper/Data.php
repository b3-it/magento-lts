<?php
/**
 * <Namespace> <Module>
 *
 *
 * @category   	<Namespace>
 * @package    	<Namespace>_<Module>
 * @name       	<Namespace>_<Module>_Helper_Data
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

 /**
  *
  * @category   	Egovs B2b
  * @package    	Egovs_B2b
  * @name       	Egovs_B2b_Helper_Data
  * @author 		Holger Kögel <h.koegel@b3-it.de>
  * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
  * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
  */
class Egovs_B2b_Helper_Data extends Mage_Core_Helper_Abstract
{

    public function hidePrice($customer = null)
    {
        $hideGroups = explode(',',Mage::getStoreConfig('catalog/price/customergroups_hide_price'));
        if(array_search((string)Egovs_B2b_Model_System_Config_Source_Customergroup::HIDE_NOTHING, $hideGroups ) !== false){
            return false;
        }
        if($customer == null) {
            $customer = Mage::getSingleton('customer/session')->getCustomer();
        }

        $groupId = 0;

        if(Mage::getSingleton('customer/session')->isLoggedIn()) {
            $groupId = $customer->getGroupId();
        }
        if(array_search($groupId, $hideGroups ) !== false){
            return true;
        }
        return false;
    }
}
