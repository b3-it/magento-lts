<?php
/**
 * Merzettel - Manager
 * 
 * Wird beim Anlegen neuer Merkzettel verwendet.<br/>
 * Validiert unter anderem die Eingabedaten *
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Model_Manager extends Varien_Object
{
	/**
     * Übersetzungroutine
     *
     * @return string
     */
    public function __() {
        $args = func_get_args();
        $expr = new Mage_Core_Model_Translate_Expr(array_shift($args), 'Sid_Wishlist');
        array_unshift($args, $expr);
        return Mage::app()->getTranslator()->translate($args);
    }
    
    /**
     * Liefert Session
     * 
     * @return Sid_Wishlist_Model_Session
     */
    public function getSession() {
    	return Mage::getSingleton('sidwishlist/session');
    }
    
    /**
     * Liefert den Merkzettel der Session
     * 
     * @return Sid_Wishlist_Model_Quote
     */
    public function getQuote() {
    	return $this->getSession()->getQuote();
    }
	
    /**
     * Validiert die Daten
     * 
     * @param array $data Daten
     * 
     * @return string|true String mit Fehlern oder true
     */
	public function validateData($data) {
		$error = array();
		
		if (empty($data) || !is_array($data)) {
			$error[] = $this->__("You have to enter some data!");
		}
		
		$msg = $this->__("You have to enter a name!");
		if (isset($data['name'])) {
			if (strlen($data['name']) < 1) {
				$error[] = $msg;
			}
		} else {
			$error[] = $msg;
		}
		
		if (count($error) > 0) {
			return implode('<br/>', $error);
		}
		
		return true;
	}
	
	/**
	 * Speichert den Merkzettel
	 * 
	 * @param array $data Daten
	 * @param int   &$id  ID
	 * 
	 * @return string|true
	 */
	public function saveQuote($data, &$id) {
		$quote = null;
		if ($id == 'new' && isset($data['id']) && $data['id'] == 'new') {
			$result = $this->validateData($data);
			if ($result !== true) {
				return $result;
			}
			
			unset($data['id']);
			
			/* @var $quote Sid_Wishlist_Model_Quote */ 
			$quote = Mage::getModel('sidwishlist/quote', $data);
			$quote->assignCustomer(Mage::getSingleton('customer/session')->getCustomer());
			if (isset($data['is_default'])) {
				$quote->setIsDefault((bool)$data['is_default']);
			}
		} elseif (is_numeric($id)) {
			/* @var $quote Sid_Wishlist_Model_Quote */
			$quote = Mage::getModel('sidwishlist/quote')->load($id);
			if ($quote->isEmpty()) {
				Mage::throwException($this->__("Collector List doesn't exist!"));
			}
		}
		if (!$quote) {
			Mage::throwException($this->__("No collection List available"));
		}
		
		if ($quote->getId()) {
			$this->getSession()->setQuoteId($quote->getId());
		}
		if ($product = $this->getSession()->getProductToAdd()) {
			if (($item = $quote->getItemByProduct($product)) !== false) {
				$this->updateQuote(
						array(
								$item->getId() => $item->getDescription()
						),
						array(
								$item->getId() => array('qty' => $item->getQty() * 1 + 1)
						)
				);
				return true;				
			}
			$result = $quote->addProduct($product);
			
			if (is_string($result)) {
				throw new Sid_Wishlist_Model_Quote_NoProductException($this->__($result));
			}
		} else {
			throw new Sid_Wishlist_Model_Quote_NoProductException($this->__('No Product to add!'));
		}
			
		$quote->collectTotals()
			->save()
		;
		
		$id = $quote->getId();
		$this->getSession()->replaceQuote($quote);
		
		return true;
	}
	
	/**
	 * Aktualisiert den Merkzettelmit den neuen Daten
	 * 
	 * @param array $desc       Enthält eine Zuordnung von ID zu Beschreibungen
	 * @param array $collection Enthält eine Zuordnung von ID und weiteren Parametern
	 * 
	 * @return Sid_Wishlist_Model_Manager
	 */
	public function updateQuote($desc, $collection) {
		if (empty($desc) && empty($collection)) {
			return $this;
		}
		
		if (!$this->getSession()->hasQuoteId()) {
			Mage::throwException($this->__('No collection list available'));
		}
		
		$hasChanges = false;
		$errors = array();
		//$desc und $collection haben die gleichen keys
		foreach ($collection as $id => $value) {
			$item = $this->getQuote()->getItemById($id);
			if (array_key_exists($id, $desc) && $desc[$id] != Mage::helper('sidwishlist')->defaultCommentString()) {
				if ($item->getDescription() != $desc[$id]) {
					$item->setData('description', $desc[$id]);
				}
			}
			
			//Muss vor Qty stehen
			if (isset($value['status']) && !$this->getQuote()->hasAuthorizedOrderer() && $value['status'] != Sid_Wishlist_Model_Quote_Item::STATUS_EDITABLE) {
				$errors[] = $this->__("Can't change status of '%s' - Share this list first with at least one authorized orderer", $item->getName());
			} else {
				if (isset($value['status']) && !is_null($item) && $item->getStatus() != $value['status']) {
					$item->setStatus($value['status']);
				}
			}
			
			if (is_null($item)) {
				//Item wurde entfernt
				$hasChanges = true;
				continue;
			}
			
			if ($item->getQty() != $value['qty']) {
				if (!is_numeric($value['qty'])) {
					$errors[] = $this->__('Items %s quantity requested must be numeric!', $item->getName());
					continue;
				}
				if ($item->getStatus() != Sid_Wishlist_Model_Quote_Item::STATUS_EDITABLE) {
					$this->getSession()->addNotice(
							$this->__('%s is no more editable', $item->getName())
					);
					
				} else {
					$item->setQtyRequested($value['qty']);
				}
			}			
			
			if ($item->hasDataChanges()) {
				$item->save();
				$hasChanges = true;
			}
		}
		
		if (!empty($errors)) {
			foreach ($errors as $error) {
				$this->getSession()->addError($error);
			}
		}
		
		//Da andere Benutzer ebenfalls Änderungen gemacht haben könnten
// 		if ($hasChanges) {
			$this->getQuote()
				->setTotalsCollectedFlag(false) //Force recollect
				->collectTotals()
				->save()
			;
// 		}
		
		return $this;
	}
	
	/**
	 * Teilt diese Liste mit anderen Personen
	 * 
	 * @param array  $emails  Liste von E-Mails
	 * @param string $message Nachricht
	 * 
	 * @return Sid_Wishlist_Model_Manager
	 */
	public function share($emails, $message) {
		
		/* ACLs anpassen und dann Mail schicken */
		$resource = Mage::getModel('customer/customer')->getResource();
		/* @var $resource Mage_Customer_Model_Resource_Customer */
		$adapter = $resource->getReadConnection();
	
		//$bind    = array('customer_email' => "'".implode("','", $emails)."'");
		$columns = array($resource->getEntityIdField(), 'email');
		$select  = $adapter->select()
			//Hier wird nur die Stammtabelle genutzt -> es ist nicht möglich 'checkout_authority' zu nutzen
			->from($resource->getEntityTable(), $columns)
			//->where('email in (:customer_email)')
			->where('email in ('."'".implode("','", $emails)."')")
		;	
		$lightCustomers = $adapter->fetchAll($select);
		$errors = array();
		$quote = $this->getQuote();
		$columns[] = 'checkout_authority';
		$found = array();
		foreach ($lightCustomers as $i => $customer) {
			$customer = Mage::getModel('customer/customer')->load($customer[$resource->getEntityIdField()], $columns);
			/* @var $customer Mage_Customer_Model_Customer */
			//Array per Mail zugreifbar machen
			$lightCustomers[$customer->getEmail()] = $customer;
			
			$quote->assignCustomer($customer);
			unset($lightCustomers[$i]);
			$found[] = $customer->getEmail();
		}
		foreach ($emails as $mail) {
			if (array_search($mail, $found)!== false) {
				continue;
			}
			$this->getSession()->addNotice($this->__("The customer with '%s' is not a customer of this shop", $mail));
		}
		$quote->save();
		
		$this->_sendMail($emails, $message);
		
		return $this;
	}
	
	/**
	 * Sendet eine E-Mail an alle Empfänger mit dem aktuellen Inhalt des Merkzettels
	 * 
	 * @param array  $emails  E-Mails
	 * @param string $message Nachricht
	 * 
	 * @return Sid_Wishlist_Model_Manager
	 */
	protected function _sendMail($emails, $message) {
		/* @var $email Sid_Wishlist_Model_Email */
		$email = Mage::getModel('sidwishlist/email');
		foreach ($emails as $mail) {
			$email->addRecipient($mail);
		}
		
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = Mage::getSingleton('customer/session')->getCustomer();
		
		if (!$customer) {
			$customer = $this->getQuote()->getCustomer();
		}
		$email->setSender($customer->getName(), $customer->getEmail())
			->setWishlist($this->getQuote())
			->setMessage($message)
			->setLink(mage::getUrl('*/*/view', array('share_code' => $this->getQuote()->getSharingCode())))
			->sendEmail()
		;
		
		return $this;
	}
}