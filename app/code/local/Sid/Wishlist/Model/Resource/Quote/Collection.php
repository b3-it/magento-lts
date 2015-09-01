<?php
/**
 * Quote - Collection Model
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Resource_Quote_Collection extends Mage_Core_Model_Resource_Db_Collection_Abstract
{
	const CUSTOMER_ID = "customer_id";
	
	/**
	 * Konstruktor -
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Model_Resource_Db_Collection_Abstract::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        $this->_init('sidwishlist/quote');
    }
    
    /**
     * Fügt einen Filter für die entsprechende Kunden ID hinzu.
     *
     * Es wird eine Where-Klausel mit der entsprechenden Tupel-Bezeichnung und der ID erzeugt.
     *
     * @param int $customerId Kunden ID
     * 
     * @return void
     */
    public function addFilterByCustomerId($customerId) {
    	$this->getSelect()->where(self::CUSTOMER_ID." = ?", $customerId);
    }
    
    /**
     * Alle Merklisten anhand der Kunden ID laden
     *
     * @param int $customerId Kunden ID
     * 
     * @return Sid_Wishlist_Model_Resource_Quote_Collection
     */
    public function loadByCustomerId($customerId) {
    	$this->addFilterByCustomerId($customerId);
    	$this->load();
    
    	return $this;
    }
}