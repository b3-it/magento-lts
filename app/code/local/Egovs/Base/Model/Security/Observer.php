<?php

/**
 * Observer für von Model-Operationen ausgelösten Events
 *
 * <p>
 * <strong>Alle implementierten Traces müssen mit "_on" beginnen.<br>
 * Der zentrale Einsprungpunkt ist die Methode __call(...)<br></strong>
 * </p>
 * <strong>Beispiel</strong>
 * <p>
 * Methode in XML Konfiguration <strong>onModelSaverAfter</strong>
 * Methode in Observer <strong>_onModelSaverAfter</strong>
 * </p>
 * 
 * @category   	Egovs
 * @package    	Egovs_Base
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2011-2015 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 * @see 		Egovs_Base_Model_Security_Observer::__call()
 *
 */
class Egovs_Base_Model_Security_Observer extends Varien_Object
{
	/**
	 * Ist das Tracing aktiviert?
	 * 
	 * @var boolean
	 */
	protected $_isEnabled = true;
	
	/**
	 * Flag um zu prüfen ob es sich um Backend-Operationen handelt.
	 * 
	 * @var boolean
	 */
	protected $_isBackendOperation = false;
	
	/**
	 * Enthält gecachte Einträge
	 * 
	 * Wird benötigt um z. B. Änderungen an Adressen zu registrieren
	 * Der Aufbau lauetet wie folgt:<br>
	 * <pre>
	 * 	array(
	 * 		Type => array(ID => DATA)
	 * 	)
	 * </pre>
	 * 
	 * @var array
	 */
	protected $_cached = array();
	
	/**
	 * Enthält bereits verarbeitete ID von ConfigData Objekten
	 * 
	 * @var array
	 */
	protected $_processedConfigData = array();
	
	/**
	 * Aktuelle Quelle
	 * 
	 * @var Object
	 */
	protected $_source = null;
	
	/**
	 * Prüft ob die Aktion im Backend stattfindet.
	 * 
	 * @return void
	 * 
	 * @see Varien_Object::_construct()
	 */
	protected function _construct() {
		$session = Mage::getSingleton("admin/session");
		if ($session && !$session->isLoggedIn()) {
			return;
		}
		$this->_isBackendOperation = true;
	}
	/**
	 * Liefert die Apache Request Headers zurück
	 * 
	 * @return Varien_Object
	 */
	protected function _getHeaders() {
		if (function_exists('apache_request_headers')) {
			$headers = new Varien_Object(apache_request_headers());
		} else {
			$headers = new Varien_Object();
		}
		
		return $headers;
	}
	
	/**
	 * Liefert einige ausgewählte Informationen zur Backend-Session
	 * 
	 * <ul>
	 * 	<li>Username</li>
	 * 	<li>Remote IP</li>
	 * 	<li>VIA-HEADER</li>
	 * 	<li>FORM-KEY</li>
	 * </ul>
	 * 
	 * @return Varien_Object
	 */
	protected function _getSessionInformation() {
		$sessionInformation = new Varien_Object();
		
		/* @var $adminSession Mage_Admin_Model_Session */
		$adminSession = Mage::getSingleton('admin/session');
		
		$remoteAddr = "empty";
		$validatorData = new Varien_Object($adminSession->getValidatorData());
		if ($validatorData->getRemoteAddr() != '') {
			$remoteAddr = $validatorData->getRemoteAddr();
		}
		$sessionInformation->setRemoteAddr($remoteAddr);
		
		$userName = "unknown";
		if ($adminSession->getUser()) {
			$userName = $adminSession->getUser()->getUsername();
		}
		$sessionInformation->setUserName($userName);
		$sessionInformation->setViaHeader($this->_getHeaders()->getVia());
		$sessionInformation->setSecretKey(Mage::getSingleton('adminhtml/url')->getSecretKey());
		
		return $sessionInformation;		
	}
	
	/**
	 * Hier müssen die Ausnahmen für bestimmte Models definiert werden
	 * 
	 * @param Mage_Core_Model_Abstract $source Das zu Prüfende Model
	 * 
	 * @return boolean
	 */
	public function isTraceableObject($source) {
		if (get_class($source) == 'Mage_CatalogIndex_Model_Catalog_Index_Flag') {
			return false;
		}
		
		if ($source instanceof Mage_Sales_Model_Abstract
			|| $source instanceof Mage_Sales_Model_Order_Item
			|| $source instanceof Mage_Sales_Model_Quote
			|| $source instanceof Mage_Sales_Model_Quote_Item_Abstract
			|| $source instanceof Mage_Sales_Model_Order_Invoice_Item
			|| $source instanceof Mage_Sales_Model_Order_Shipment_Item
			|| $source instanceof Mage_Payment_Model_Info
			|| $source instanceof Mage_Downloadable_Model_Link_Purchased_Item
			|| $source instanceof Mage_CatalogInventory_Model_Stock_Item
		) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * Ist dieses Funktion Verfügbar
	 * 
	 * @return boolean
	 */
	public function isAvailable() {
		if (!$this->_isBackendOperation) {
			return false;
		}
		
		return $this->_isEnabled;
	}
	
	/**
	 * Erweitert die ursprüngliche Funktion um Methoden die mit 'on' beginnen!
	 * 
	 * Alle implementierten Tracing-Event-Methoden müssen mit '_on' beginnen!
	 * 
	 * @param string $method Name
	 * @param array  $args   Parameter
	 * 
	 * @return mixed
	 * 
	 * @see Varien_Object::__call()
	 */
	public function __call($method, $args) {
		switch (substr($method, 0, 2)) {
			case 'on' :
				if (!$this->isAvailable()) {
					return;
				}
				
				//Varien_Profiler::start('GETTER: '.get_class($this).'::'.$method);
				$method = '_'.$method;
				if (method_exists($this, $method) && isset($args[0])) {
					$this->$method($args[0]);
				} else {
					Mage::log(sprintf("Function '%s' doesn't exist or no data given, tracing not available!", $method), Zend_Log::ERR, Egovs_Helper::BACKEND_TRACE_LOG);
				}
				//Varien_Profiler::stop('GETTER: '.get_class($this).'::'.$method);
				return;
		}
			
		return parent::__call($method, $args);	
	}
	
	/**
	 * Nötig da {@link Mage_Core_Model_App::__callObserverMethod} method_exists verwendet
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function doTrace($observer) {
		if (!($observer instanceof Varien_Event_Observer) || !$observer->hasEvent()) {
			return;
		}
		
		$this->__call(sprintf('on%s', $this->_camelize($observer->getEvent()->getName())), array($observer));
	}
	
	/**
	 * Loggt das Löschen von Objekten
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	protected function _onModelDeleteAfter($observer) {		
		/* @var $source Mage_Core_Model_Abstract */
		$source = $observer->getObject();
		
		$id = $source->getId();
		if (!$source || !isset($id) || $source->isEmpty()) {
			return;
		}
		
		//TODO : Es müssen noch einige Ausnahmen definiert werden
		if (!$this->isTraceableObject($source)) {
			return;
		}
		
		$sessionInformation = $this->_getSessionInformation();
		
		if ($source instanceof Mage_Core_Model_Config_Data) {
			$diff = array();
			$diff['path'] = $source->getPath();
			$diff['group_id'] = $source->getGroupId();
			$diff['store_code'] = $source->getStoreCode();
			$diff['website_code'] = $source->getWebsiteCode();
			$diff['scope'] = $source->getScope();
			$diff['value'] = $source->getValue();
			$diff['value OLD'] = $source->getOldValue();
			
			try {
				$diff = @var_export($diff, true);
			} catch (Exception $e) {
				$diff = $e;
			}
			Mage::log(
				sprintf("OBJECT_DELETE::Config data with ID: %d changed :\nBy user \"%s\"\nIP: %s\nVIA-HEADER: %s\nSecret-KEY: %s\nData-Deleted: %s",
					$source->getId(),
					$sessionInformation->getUserName(),
					$sessionInformation->getRemoteAddr(),
					$sessionInformation->getViaHeader(),
					$sessionInformation->getSecretKey(),
					$diff
				),
				Zend_Log::NOTICE,
				Egovs_Helper::BACKEND_TRACE_LOG,
				true
			);
			return;
		}
		
		Mage::log(
				sprintf("OBJECT_DELETE::Object of type \"%s\" with ID: %d was deleted :\nBy user \"%s\"\nIP: %s\nVIA-HEADER: %s\nSecret-KEY: %s",
						get_class($source),
						$source->getId(),
						$sessionInformation->getUserName(),
						$sessionInformation->getRemoteAddr(),
						$sessionInformation->getViaHeader(),
						$sessionInformation->getSecretKey()
				),
				Zend_Log::NOTICE,
				Egovs_Helper::BACKEND_TRACE_LOG,
				true
		);
	}
	
	/**
	 * Verfolgt Änderungen an der Konfiguration
	 * 
	 * @param Mage_Core_Model_Config_Data $data Daten
	 * 
	 * @return void
	 */
	protected function _traceConfigData(Mage_Core_Model_Config_Data $data) {
		if (!$data || !$data->isValueChanged()) {
			return;
		}
		
		if (preg_match('/\r\n|\n/', $data->getValue()) == true) {
			$old = str_replace("\r\n", "\n", $data->getOldValue());
			$new = str_replace("\r\n", "\n", $data->getValue());
			if ($old == $new) {
				return;
			}
		}
		
		if ($data instanceof Mage_Adminhtml_Model_System_Config_Backend_Encrypted) {
			$value = Mage::helper('core')->decrypt($data->getValue());
			
			if ($value == $data->getOldValue()) {
				return;
			}			
		}
		$diff = array();
		$diff['path'] = $data->getPath();
		$diff['group_id'] = $data->getGroupId();
		$diff['store_code'] = $data->getStoreCode();
		$diff['website_code'] = $data->getWebsiteCode();
		$diff['scope'] = $data->getScope();
		$diff['value'] = $data->getValue();
		$diff['value OLD'] = $data->getOldValue();
		
		try {
			$diff = var_export($diff, true);
		} catch (Exception $e) {
			$diff = $e;
		}
		
		$sessionInformation = $this->_getSessionInformation();
		
		Mage::log(
				sprintf("CONFIG_CHANGED::Config data with ID: %d changed :\nBy user \"%s\"\nIP: %s\nVIA-HEADER: %s\nSecret-KEY: %s\nArray-Diff: %s",
						$data->getId(),
						$sessionInformation->getUserName(),
						$sessionInformation->getRemoteAddr(),
						$sessionInformation->getViaHeader(),
						$sessionInformation->getSecretKey(),
						$diff
				),
				Zend_Log::NOTICE,
				Egovs_Helper::BACKEND_TRACE_LOG,
				true
		);
	}
	
	/**
	 * Loggt die Veränderung an Config-Objekten
	 *
	 * Die Veränderungen werden in einem Diff ausgegeben
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return void
	 */
	protected function _onCoreConfigDataSaveCommitAfter($observer) {
		/* @var $source Mage_Core_Model_Abstract */
		$source = $observer->getConfigData();
		$eventName = $observer->getEvent()->getName();
		
		if ($source instanceof Mage_Core_Model_Config_Data && !isset($this->_processedConfigData[$source->getId()])) {
			$this->_traceConfigData($source);
			$this->_processedConfigData[$source->getId()] = true;
			return;
		}
	}
	
	/**
	 * Loggt die Veränderung an Objekten
	 * 
	 * Die Veränderungen werden in einem Diff ausgegeben
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	protected function _onModelSaveAfter($observer) {	
		/* @var $source Mage_Core_Model_Abstract */
		$source = $observer->getObject();
		$this->_source = $source;
		
		$eventName = $observer->getEvent()->getName();
		
		if (strpos($eventName, 'core_config_data_') === 0) {
			// wird in _onCoreConfigDataSaveCommitAfter geloggt
			return;
		}
		
		if ($source instanceof Mage_Core_Model_Config_Data && !isset($this->_processedConfigData[$source->getId()])) {
			$this->_traceConfigData($source);
			if ($source->getId() > 0) {
				$this->_processedConfigData[$source->getId()] = true;
			}
			return;
		}
		
		$id = $source->getId();
		$origData = $source->getOrigData();
		$className = get_class($source);
		if ($source instanceof Mage_Customer_Model_Address && !empty($id) && !empty($origData)) {
			if (isset($this->_cached[$className])) {
				//Type bereits vorhanden
				$this->_cached[$className][$source->getId()] = $source->getData();
			} else {
				//Type noch nicht vorhanden -> anlegen
				$this->_cached[$className] = array($source->getId() => $source->getData());
			}
		} elseif ($source instanceof Mage_Customer_Model_Address && !empty($id) && empty($origData)) {
			if (isset($this->_cached[$className]) && isset($this->_cached[$className][$source->getId()])) {
				$origData = $this->_cached[$className][$source->getId()];
				//Objekt mit alten Daten füttern
				$tmpData = $source->getData();
				$source->setData($origData);
				//setzt $_origdata = $_data
				$source->setOrigData(null);
				//Original zurück speichern
				$source->setData($tmpData);
				//Eintrag wird nicht mehr benötigt
				unset($this->_cached[$className][$source->getId()]);
			}
		}
		
		if (!$source || !isset($id) || $source->isEmpty() || empty($origData)) {
			return;
		}
	
		//TODO : Es müssen noch einige Ausnahmen definiert werden
		if (!$this->isTraceableObject($source)) {
			return;
		}
		
		$diff = array();
		if ($source->dataHasChangedFor('')) {
			try {
				//$diff = array_diff_assoc($source->getData(), $source->getOrigData());
				$diff = $this->_arrayDiff($source->getOrigData(), $source->getData());
			} catch (Exception $e) {
				Mage::log(sprintf("Error: %s, tracing stopped!", $e->getMessage()), Zend_Log::ERR, Egovs_Helper::BACKEND_TRACE_LOG);
			}
		}
		if (empty($diff)) {
			return;
		}

		if (empty($diff) || (count($diff) == 1 && isset($diff['updated_at']))) {
			return;
		}
		
		ksort($diff);
		
		try {
			$diff = var_export($diff, true);
			if (isset($this->_cached[$className][$source->getId()])) {
				unset($this->_cached[$className][$source->getId()]);
			}
		} catch (Exception $e) {
			$diff = $e;
		}
	
		$sessionInformation = $this->_getSessionInformation();
	
		Mage::log(
				sprintf("OBJECT_SAVE::Object of type \"%s\" with ID: %d was saved :\nBy user \"%s\"\nIP: %s\nVIA-HEADER: %s\nSecret-KEY: %s\nArray-Diff: %s",
						get_class($source),
						$source->getId(),
						$sessionInformation->getUserName(),
						$sessionInformation->getRemoteAddr(),
						$sessionInformation->getViaHeader(),
						$sessionInformation->getSecretKey(),
						$diff
				),
				Zend_Log::NOTICE,
				Egovs_Helper::BACKEND_TRACE_LOG,
				true
		);
	}
	
	/**
	 * Liefert einen Diff zwischen zwei Arrays
	 * 
	 * @param array   $old   Altes Array
	 * @param array   $new   Neues Array
	 * @param integer $level Array-level
	 * 
	 * @return array
	 */	
	protected function _arrayDiff($old, $new, $level = 0) {
		
		if ($level > 2) {
			return '';
		}
		
		if ($old instanceof Varien_Object) {
			$old = $old->getData();
		}
		if ($new instanceof Varien_Object) {
			$new = $new->getData();
		}
		
		if (!is_array($old)) {
			$old = array();
		}
		$keysOld = array_keys($old);
		if (!is_array($new)) {
			$new = array();
		}
		$keysNew = array_keys($new);
		$keys = array_merge($keysNew, $keysOld);
		
		$res = array();
		foreach ($keys as $key) {
			if ($key != '_cache_editable_attributes') {
				$origValue = '';
				$newValue = '';
				if (isset($old[$key])) {
					$origValue  = $old[$key];
				}
				if (isset($new[$key])) {
					$newValue = $new[$key];
				}
				
				if ($origValue !== $newValue) {
					if ((is_array($origValue) or is_object($origValue)) || (is_array($newValue) or is_object($newValue))) {
						$res[$key] = $this->_arrayDiff($origValue, $newValue, $level+1);
						if (empty($res[$key])) {
							unset($res[$key]);
						}
					} else {
						$origValue = trim($origValue);
						$newValue = trim($newValue);
						
						//Ausnahmen
						if ($this->_conditionalExcludeKey($key, $origValue, $newValue, $level)) {
							continue;
						}
						
						$this->_conditionalProcessKeyValue($key, $origValue, $newValue, $level);
						
						if (strpos($key, 'discount_quota') === 0) {
							//Preis wieder in float umwandeln
							$origValue = Mage::app()->getLocale()->getNumber($origValue);
							//Auf 2 Nachkommastellen setzen
							$origValue = Mage::app()->getStore()->roundPrice($origValue);
						}
						
						//String truncation
						if (is_string($origValue)) {
							$origValue = $this->_truncate($origValue);
						}
						if (is_string($newValue)) {
							$newValue = $this->_truncate($newValue);
						}
						
						if ($origValue != $newValue) {
							$res[$key] = sprintf("OLD: %s|NEW: %s;", $origValue, $newValue); 
						}
					}
				}	
			}
		}
		
		return $res;
	}
	
	protected function _conditionalExcludeKey($key, $origValue, $newValue, $level = 0) {
		if ((empty($newValue) && $newValue != 0 && empty($origValue) && $origValue != 0) //empty außer 0
			|| (strpos($key, '_is_formated') !== false && $newValue == true && empty($origValue))
			|| (strpos($key, 'use_config_') !== false && $newValue == true && empty($origValue))
			|| ($key == 'parent_id' && $newValue == 0 && empty($origValue))
			|| $key == 'post_index' //Gilt für Änderung an Adressen
			|| ($key == 'created_at' && !empty($origValue) && empty($newValue))
			|| ($key == 'is_active' && $origValue == true && empty($newValue))
			|| ($key == 'attribute_set_id' && $origValue == 0 && empty ($newValue))
			|| $key == 'is_customer_save_transaction'
			|| $key == 'is_saved'
			|| ($key == 'customer_id' && $level == 0 && empty($origValue) && !empty($newValue) && $this->_source instanceof Mage_Customer_Model_Address)
			|| ($key == 'store_id' && $level == 0 && empty($origValue) && !empty($newValue) && $this->_source instanceof Mage_Customer_Model_Address)
			|| $key == 'new_password'
			|| $key == 'password_confirmation'
			|| $key == 'form_key'
		) {
			return true;
		}
		
		return false;
	}
	
	protected function _conditionalProcessKeyValue($key, &$origValue, &$newValue, $level = 0) {
		if ($origValue == $newValue) {
			return;
		}
		switch ($key) {
			case 'password':
			case 'new_password':
			case 'password_confirmation':
				$origValue = '*********';
				$newValue = $origValue.'**';
		}
	}
	
	protected function _truncate($origValue) {
		if (!is_string($origValue)) {
			return $origValue;
		}
		
		$len = strlen($origValue);
		$tmp = substr($origValue, 0, min($len, 350));
		if ($len > 250) {
			$tmp .= '...';
		}
		return $tmp;
	}
}