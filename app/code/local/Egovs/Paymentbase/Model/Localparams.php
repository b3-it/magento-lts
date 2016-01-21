<?php
/**
 * Klasse um Buchungslistenparameter zur ePayBL-Kommunikation zu ermitteln
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 EDV Beratung Hempel
 * @copyright	Copyright (c) 2012 TRW-NET
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Model_Localparams extends Mage_Core_Model_Abstract
{
	/**
	 * Konstruktor
	 * 
	 * @return void
	 * 
	 * @see Varien_Object::_construct()
	 */
    protected function _construct() {
        parent::_construct();
        $this->_init('paymentbase/localparams');
    }
    
    /**
     * Liefert eine Parameterliste für ePayBL
     * 
     * @param int    $customerGroupID Kundengruppen ID
     * @param string $paymentMethod   Bezahlmethode
     * @param float  $amount          Betrag
     * 
     * @return array
     */
    public function getParamList($customerGroupID, $paymentMethod, $amount) {
    	$res = array();
    	
    	$collection = $this->getCollection();
    	$collection->addParams();
    	//Oberste Priorität Kundengruppe + Bezahlmodul
    	$collection->getSelect()
    		->where('customer_group_id =?',$customerGroupID)
    		->where("payment_method = ?", $paymentMethod)
    		->where('lower <= ?', $amount)
    		->where('upper > ?', $amount)
    		->where('`status` = 1')
    	;
    	foreach ($collection->getItems() as $item) {
    		$res[$item->getIdent()] = $item->getValue();
    	}
    	
    	//Nächste Priorität nur Kundengruppe und alle Bezahlmodule
    	$collection->clear()
    		->getSelect()->reset(Zend_Db_Select::WHERE)
	    	->where('customer_group_id ='.$customerGroupID)
	    	->where("payment_method = 'all'")
	    	->where('lower <= ?', $amount)
	    	->where('upper > ?', $amount)
	    	->where('`status` = 1')
    	;
    	foreach ($collection->getItems() as $item) {
    		if (array_key_exists($item->getIdent(), $res)) {
    			continue;
    		}
    		
    		$res[$item->getIdent()] = $item->getValue();
    	}
    	//Nächste Priorität nur Bezahlmodul und alle Kundengruppen
    	$collection->clear()
    		->getSelect()->reset(Zend_Db_Select::WHERE)
    		->where('customer_group_id = -1')
    		->where("payment_method = '".$paymentMethod."'")
	    	->where('lower <= ?', $amount)
	    	->where('upper > ?', $amount)
	    	->where('`status` = 1')
    	;
    	foreach ($collection->getItems() as $item) {
    		if (array_key_exists($item->getIdent(), $res)) {
    			continue;
    		}
    	
    		$res[$item->getIdent()] = $item->getValue();
    	}
    	//Defaults, alle Kundengruppen und Bezahlmodule
    	//Nächste Priorität Defaults
    	$collection->clear()
    		->getSelect()->reset(Zend_Db_Select::WHERE)
    		->where('customer_group_id = -1')
    		->where("payment_method = 'all'")
	    	->where('lower <= ?', $amount)
	    	->where('upper > ?', $amount)
	    	->where('`status` = 1')
    	;
    	foreach ($collection->getItems() as $item) {
    		if (array_key_exists($item->getIdent(), $res)) {
    			continue;
    		}
    	
    		$res[$item->getIdent()] = $item->getValue();
    	}
    	    	
    	return $res;
    }
    
    /**
     * Gibt den Ident-Code für das Kennzeichen - Mahnverfahren zurück
     * 
     * DEFAULT: kennz_mahn
     * Der Code kann in der 'config.xml unter payment/attributes/mapping/kennz_mahn konfiguriert werden.
     * 
     * @return string
     */
    public function getKennzeichenMahnverfahrenCode() {
    	$node = Mage::getConfig()->getNode('global/payment/attributes/mapping/kennz_mahn');
    	if (empty($node)) {
    		$node = 'kennz_mahn';
    	}
    	return (string)$node;
    }
    
  
    
    /**
     * Auf Duplikate prüfen
     * 
     * als Joker gilt payment = all; customer_group_id = -1
     * 
     * @return bool
     */
    public function testDublicates() {
    	$collection = $this->getCollection();   	
    	$collection->getSelect()
    		->where('customer_group_id ='.$this->getCustomerGroupId())
    		->where("payment_method = '".$this->getPaymentMethod()."'")
    		->where("param_id = ".$this->getParamId())
    		->where('paymentbase_localparams_id <> '.$this->getId())
    	;

    	foreach ($collection->getItems() as $item) {
    		//Fall 1. item liegt in this:
    		if(($item->getLower() >= $this->getLower() ) && ($item->getUpper() < $this->getUpper())) return false;
    		//Fall 2. this liegt in item:
    		if(($item->getLower() <= $this->getLower() ) && ($item->getUpper() > $this->getUpper())) return false;
    		//Fall 3. this liegt unten teilweise in item:
    		if(($item->getLower() <= $this->getLower() ) && ($item->getUpper() > $this->getLower())) return false;
    		//Fall 4. this liegt oben teilweise in item:
    		if(($item->getLower() < $this->getUpper() ) && ($item->getUpper() > $this->getUpper())) return false;  		
    	}
    	return true;
    }
    
    
}