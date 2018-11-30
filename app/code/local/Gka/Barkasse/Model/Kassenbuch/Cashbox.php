<?php
/**
 *
 * @category   	Gka Barkasse
 * @package    	Gka_Barkasse
 * @name       	Gka_Barkasse_Model_Kassenbuch_Cashbox
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Gka_Barkasse_Model_Kassenbuch_Cashbox extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('gka_barkasse/kassenbuch_cashbox');
    }
    
    /**
     * Ermitteln der Barkasse des aktuellen Kunden
     * @param Mage_Customer_Model_Customer $customerId
     * @return NULL | Gka_Barkasse_Block_Kassenbuch_Journal
     */
    public function getCashbox($customerId = null)
    {
    	if($customerId == null){
    		$customerId = $this->_getCustomer()->getId();
    	}
    
    	$collection = $this->getCollection();
    	$collection->getSelect()
    	->where('customer_id = '.$customerId);
    
    	if(count($collection->getItems()) == 0) return null;
    
    	return $collection->getFirstItem();
    }
}
