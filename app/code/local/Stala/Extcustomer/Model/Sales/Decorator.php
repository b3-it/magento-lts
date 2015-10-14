<?php
/**
 * Model zur Unterstützung von Freiexemplaren mit Nebenkundenbeziehungen in Quote-/Orderitems
 *
 * @category   	Stala
 * @package    	Stala_Extcustomer
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 *
 */
class Stala_Extcustomer_Model_Sales_Decorator {
	/**
	* Quote or Order item model object
	*
	* @var Mage_Sales_Model_Quote_Item|Mage_Sales_Model_Order_Item
	*/
	protected $_item = null;
	
	/**
	 * Constructor
	 *
	 * Is looking for first argument as Mage_Sales_Model_Quote_Item or Mage_Sales_Model_Order_Item.
	 *
	 */
	public function __construct()
	{
		$args = func_get_args();
		if (empty($args[0])) {
			$args[0] = array();
		}
		
		if (!($args[0] instanceof Mage_Sales_Model_Quote_Item) &&
			!($args[0] instanceof Mage_Sales_Model_Order_Item)) {
			Mage::throwException('Argument have to be type of Mage_Sales_Model_Quote_Item or Mage_Sales_Model_Order_Item');
		}
		
		$this->_item = $args[0];
	}
	
	/**
	 * Ruft die Methoden des dekorierten Objekts auf.
	 * 
	 * @param string $method Methodenname
	 * @param array $args Parameter
	 * @return mixed
	 */
	public function __call($method, $args) {
		if (empty($args)) {
			return call_user_func(array($this->_item, $method));
		}
		if (count($args) == 1) {
			return call_user_func(array($this->_item, $method), $args[0]);
		}
		if (count($args) == 2) {
			return call_user_func(array($this->_item, $method), $args[0], $args[1]);
		}
		return call_user_func(array($this->_item, $method), $args);
	}
	
	/**
	 * Gibt die verwendeten Freiexemplare mit Customer zurück
	 * 
	 * array (customer => freecopies)
	 * 
	 * @return array
	 */
	public function getStalaFreecopies() {
		$value = $this->_item->getData('stala_freecopies');
		
		if (empty($value)) {
			return array();
		}
		
		if (is_numeric($value)) {
			if ($this->_item instanceof Mage_Sales_Model_Quote_Item) {
				$customer = $this->_item->getQuote()->getCustomer()->getId();
			} elseif ($this->_item instanceof Mage_Sales_Model_Order_Item) {
				$customer = $this->_item->getOrder()->getCustomerId();
			} else {
				Mage::throwException("Parser error: Can't parse freecopies");
			}
			
			$value = array($customer => $value);
			
			return $value;
		}
		
		if (is_string($value)) {
			$value = unserialize($value);
			
			if (is_array($value)) {
				return $value;
			}
		}
		
		Mage::throwException("Parser error: Can't parse freecopies");
	}
	
	/**
	 * Gibt die Summe aller verwendeten Freiexemplare zurück.
	 * 
	 * @return int
	 */
	public function getFlatStalaFreecopies() {
		$flatFreecopies = 0;
		
		foreach ($this->getStalaFreecopies() as $customer => $freecopies) {
			$flatFreecopies += $freecopies;
		}
		
		return $flatFreecopies;
	}
	
	public function setStalaFreecopies($freecopies) {
		if (is_numeric($freecopies)) {
			if ($this->_item instanceof Mage_Sales_Model_Quote_Item) {
				$customer = $this->_item->getQuote()->getCustomer()->getId();
			} elseif ($this->_item instanceof Mage_Sales_Model_Order_Item) {
				$customer = $this->_item->getOrder()->getCustomerId();
			} else {
				Mage::throwException("Serialization error: Can't serialize freecopies");
			}
			
			$freecopies = array($customer => $freecopies);
			$freecopies = serialize($freecopies);
			
			$this->_item->setData('stala_freecopies', $freecopies);
			
			return $this;
		}
		
		if (is_array($freecopies)) {
			$freecopies = serialize($freecopies);
			
			$this->_item->setData('stala_freecopies', $freecopies);
				
			return $this;
		}
		
		Mage::throwException("Serialization error: Can't serialize freecopies");
	}
	
}