<?php
/**
 * Controller für Merkzettel-Aktionen
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_IndexController extends Sid_Wishlist_Controller_Abstract
{
	/**
	 * Prüft ob de Aktion erlaubt ist
	 *
	 * @return bool
	 */
	protected function _isAllowed() {
		//TODO: Implement Role Check!
		/*
		 * [10:04:08] Holger Kögel: Sid_Roles_Model_Customer_Authority::getIsAuthorizedOrderer($customer)
		 */
		return true;
	}
	
	/**
	 * State Model holen
	 *
	 * @return Sid_Wishlist_Model_State
	 */
	protected function _getState() {
		return Mage::getSingleton('sidwishlist/state');
	}
	
	public function deleteAction() {
		/*
		 * Load an object by id
		 * Request looking like:
		 * http://site.com/sidwishlist?id=15
		 *  or
		 * http://site.com/sidwishlist/id/15
		 */

		$quoteId = $this->getRequest()->getParam('id');

		if ($quoteId != null && $quoteId != '') {
			$quote = Mage::getModel('sidwishlist/quote')->load($quoteId);
		} else {
			$quote = null;
		}
		
		if (!$quote || $quote->isEmpty()) {
			Mage::getSingleton('customer/session')->addError($this->__('No collection list available!'));
			return;
		}
		
		$quote->delete();
		
		$this->getSession()->addSuccess($this->__("Collection list '%s' successfully deleted", $quote->getName()));
		
		$this->_redirect('*/*/index', array('_secure'=>true));
	}
	
	/**
	 * Standart-Aktion
	 * 
	 * Zeigt eine Übersicht der Merkzettel an
	 * 
	 * @return void
	 */
	public function indexAction() {			
		$this->loadLayout();
		$this->_initLayoutMessages('customer/session');
		$this->_initLayoutMessages('sidwishlist/session');
		$this->renderLayout();
    }
    
    /**
     * Hinzufügen-Auswahl Aktion
     * 
     * @return void
     */
    public function addAction() {
    	/* @var $quoteCollection Sid_Wishlist_Model_Resource_Quote_Collection */
    	$quoteCollection = Mage::getModel('sidwishlist/quote')->getCollection();
    	$customerId = Mage::getSingleton('customer/session')->getCustomerId();
    	
    	if (!is_numeric($customerId) || $customerId < 1) {
    		$this->_forward('denied');
    		return;
    	}
    	
    	$referer = $this->_getRefererUrl();
    	//Darf nur beim ersten Mal oder bei neuen Produkten gesetzt werden
    	$params = new Varien_Object($this->getRequest()->getParams());
    	if (!$this->getSession()->hasParams() || ($this->getSession()->getProductToAdd() && $params->getProduct() && $this->getSession()->getProductToAdd()->getId())) {
    		$this->getSession()->setParams($this->getRequest()->getParams());
    	}
    	if (!$this->getSession()->getProductToAdd()) {
    		$this->getSession()->unsParams();
    		$this->_redirect('', array('_secure'=>true));
    		return;
    	}
    	
    	if (!$this->getSession()->getProductToAdd()->isAvailable()) {
    		$this->getSession()->unsParams();
    		Mage::getSingleton('catalog/session')->addError($this->__('This product is currently out of stock.'));
    		if ($referer) {
    			$this->_redirectUrl($referer);
    		} else {
    			$this->_redirect('', array('_secure'=>true));
    		}
    		return;
    	}
    	
    	if ($this->_getState()->getActiveStep() != Sid_Wishlist_Model_State::STEP_ADD_SELECT) {
	    	$this->_getState()->setActiveStep(
	    			Sid_Wishlist_Model_State::STEP_ADD_SELECT
	    	);
    	}
    	
    	$quoteCollection->addFieldToFilter('customer_acls', array('like' => "%i:$customerId;%"));
    	
    	if (!$this->getSession()->hasBackUrl() && !empty($referer)) {
    		$this->getSession()->setBackUrl($referer);
    	}
    	
    	/*
    	 * Falls es noch keine Merkzettel gibt
    	 */
    	if ($quoteCollection->getSize() < 1) {
    		$this->getSession()->setNoWishlists(true);
    		$this->_redirect('*/*/newwishlist', array('_secure'=>true));
    		return;
    	}
    	
    	$this->loadLayout();
    	$this->_initLayoutMessages('customer/session');
    	$this->_initLayoutMessages('sidwishlist/session');
    	$this->renderLayout();
    }
    
    /**
     * Redirect zu der Seite die vor dem Hinzufügen zur Merkliste aktuell war
     * 
     * @return void
     */
    public function backFromAddAction() {
    	$back = $this->getSession()->getBackUrl();
    	$this->getSession()->unsBackUrl();
    	$this->_redirectUrl($back);
    }
    
    /**
     * Redirect zu der Seite die vor dem Hinzufügen zur Merkliste aktuell war
     *
     * @return void
     */
    public function backFromAddNewAction() {
    	if ($this->getSession()->hasNoWishlists()) {
	    	$back = $this->getSession()->getBackUrl();
	    	$this->getSession()->unsBackUrl();
	    	$this->getSession()->unsNoWishlists();
	    	$this->_redirectUrl($back);
	    	return;
    	}
    	$this->_redirect('*/*/add', array('_secure' => true));
    }
    
    /**
     * Aktion zum Hinzufügen eines Produktes zum Merkzettel
     * 
     * Der Merkzettel wurde entweder gerade angelegt oder vorher ausgewählt.
     * 
     * @return void
     */
    public function addPostAction() {
    	if (!$this->getRequest()->isPost()
    		|| $this->_getState()->getActiveStep() != Sid_Wishlist_Model_State::STEP_ADD_SELECT
    	) {
    		if ($this->_getState()->getActiveStep() == Sid_Wishlist_Model_State::STEP_SUCCESS) {
    			$wishlistId = $this->getRequest()->getPost('wishlist_id', false);
    			$this->_forward('view', null, null, array('_secure'=>true, 'id' => $wishlistId));
    			return;
    		}
    		$this->_redirect('*/*/add', array('_secure'=>true));
    		return;
    	}
    	
    	try {
    		$data = $this->getRequest()->getPost('wishlist', array());
    		$wishlistId = $this->getRequest()->getPost('wishlist_id', 'new');
    		Mage::getSingleton('sidwishlist/session')->setData('wishlist_post_data', $data);

    		if ($wishlistId == 'add') {
    			$this->_redirect('*/*/newwishlist', array('_secure'=>true));
    			return;
    		}
			
    		$result = $this->_getManager()->saveQuote($data, $wishlistId);
    		if ($result !== true) {
    			Mage::getSingleton('sidwishlist/session')->addError($result);
    			$this->_redirect('*/*/newwishlist', array('_secure'=>true));
    			return;
    		}

    		Mage::getSingleton('sidwishlist/session')->unsetData('wishlist_post_data');
    		Mage::getSingleton('sidwishlist/session')->unsParams();

    		$this->_getState()->setCompleteStep(Sid_Wishlist_Model_State::STEP_ADD_SELECT);
    		
    	} catch (Sid_Wishlist_Model_Quote_NoProductException $e) {
            Mage::getSingleton('core/session')->addError($e->getMessage());
            $this->getSession()->unsParams();
            if ($e->getRefererUrl() !== NULL && $this->_isUrlInternal($e->getRefererUrl())) {
                $this->_redirectUrl($e->getRefererUrl());
            } else {
                //redirect to Startpage
                $this->_redirect('', array('_secure' => true));
            }
    		return;
    	} catch (Mage_Core_Exception $e) {
    		Mage::logException($e);
    		$messages = array_unique(explode("\n", $e->getMessage()));
    		foreach ($messages as $message) {
    			Mage::getSingleton('sidwishlist/session')->addError($message);
    		}
    		
    		if ($wishlistId == 'new') {
                $this->_forward('newwishlist', null, null, array('_secure'=>true));
    			return;
    		}
    		$this->_forward('add', null, null, array('_secure'=>true));
    		return;
    	} catch (Exception $e) {
    		Mage::getSingleton('sidwishlist/session')->addException(
    				$e,
    				Mage::helper('checkout')->__('Data saving problem'));
    		Mage::log("sidwishlist::".$e->getMessage(), Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);

    		if ($wishlistId == 'new') {
                $this->_forward('newwishlist', null, null, array('_secure'=>true));
    			return;
    		}
            $this->_forward('add', null, null, array('_secure'=>true));
    		return;
    	}
    	
    	$this->getSession()->unsNoWishlists();
    	
    	$this->_getState()->setActiveStep(
    			Sid_Wishlist_Model_State::STEP_SUCCESS
    	);
    	
    	$this->_forward('view', null, null, array('_secure'=>true, 'id' => $wishlistId));
    }
    
    /**
     * Aktion zum aktualisieren des Merkzettels
     * 
     * @return void
     */
    public function updatePostAction() {
    	$descs = $this->getRequest()->getPost('description', array());
    	$collection = $this->getRequest()->getPost('collection', array());
    	
    	$this->_getManager()->updateQuote($descs, $collection);
    	
    	if ($this->getRequest()->has('save_and_share')) {
    		$this->_forward('share');
    		return;
    	}
    	
    	if ($this->getRequest()->has('share_key')) {
    		$this->_forward('sharePost');
    		return;
    	}
    	
    	$this->loadLayout();
    	$this->_initLayoutMessages('customer/session');
    	$this->_initLayoutMessages('sidwishlist/session');
    	$this->renderLayout();
    }
    
    public function shareAction() {
    	$this->loadLayout();
    	$this->_initLayoutMessages('customer/session');
    	$this->_initLayoutMessages('sidwishlist/session');
    	$this->renderLayout();
    }
    
    public function sharePostAction() {
    	if (!$this->getRequest()->isPost()) {
    		$this->_forward('index');
    		return;
    	}
    	
    	if (!$this->_validateFormKey()) {
    		return $this->_redirect('*/');
    	}
    	
    	//$emails  = explode(',', $this->getRequest()->getPost('emails'));
    	// split the phrase by any number of commas or space characters,
    	// which include " ", \r, \t, \n and \f
    	$emails = preg_split("/[\s,]+/", $this->getRequest()->getPost('emails'), -1, PREG_SPLIT_NO_EMPTY);
        $message = nl2br(htmlspecialchars((string) $this->getRequest()->getPost('message')));
        $error   = false;
        if (empty($emails)) {
            $error = $this->__('Email address can\'t be empty.');
        } elseif (count($emails) > 5) {
            $error = $this->__('Please enter no more than 5 email addresses.');
        } else {
            foreach ($emails as $index => $email) {
                $email = trim($email);
                if (!Zend_Validate::is($email, 'EmailAddress')) {
                    $error = $this->__('Please input a valid email address.');
                    break;
                }
                $emails[$index] = $email;
            }
        }
        if ($error) {
            Mage::getSingleton('sidwishlist/session')->addError($error);
            Mage::getSingleton('sidwishlist/session')->setSharingForm($this->getRequest()->getPost());
            $this->_redirect('*/*/share');
            return;
        }
    	    	
    	$this->_getManager()->share($emails, $message);
    	
    	$this->_forward('view', null, null, array('id' => $this->getQuote()->getId()));
    }
    
    /**
     * Neuen Merkzettel erstellen Aktion
     * 
     * @return void
     */
    public function newWishlistAction() {
    	$customerId = Mage::getSingleton('customer/session')->getCustomerId();
    	 
    	if (!is_numeric($customerId) || $customerId < 1) {
    		$this->_forward('denied');
    		return;
    	}
    	
    	if ($this->_getState()->getActiveStep() != Sid_Wishlist_Model_State::STEP_ADD_SELECT
    		|| $this->_getState()->getCompleteStep($this->_getState()->getActiveStep())
    	) {
    		$this->_redirect('*/*/add', array('_secure'=>true));
    		return;
    	}
    	    	
    	$this->loadLayout();
    	$this->_initLayoutMessages('customer/session');
    	$this->_initLayoutMessages('sidwishlist/session');
    	$this->renderLayout();
    }
    
    public function viewAction() {
    	if (!$this->getSession()->hasQuote()) {
    		if ($this->getRequest()->has('share_code')) {
    			$quote = Mage::getModel('sidwishlist/quote')->loadByShareCode($this->getRequest()->get('share_code', false));
    			$this->getSession()->replaceQuote($quote);
    		} else {
	    		$quoteId = $this->getRequest()->get('id', false);
	    		if (!$quoteId) {
	    			$quoteId = $this->getRequest()->getPost('wishlist_id', false);
	    		}
	    		$this->getSession()->setQuoteId($quoteId);
    		}
    		    		
    		if (!$this->getSession()->getQuote() || $this->getSession()->getQuote()->isEmpty()) {
    			Mage::getSingleton('customer/session')->addError($this->__('No collector list selected'));
    			$this->getSession()->clear();
    			$this->_redirect('', array('_secure'=>true));
    		}
    	}
    	
    	if (!$this->getQuote()->hasAuthorizedOrderer()) {
    		$this->getSession()->addNotice($this->__("This collection list has no authorized orderers!"));
    	}
    	$infos = $this->getQuote()->getAssignedCustomersInformation();
    	if (isset($infos['specials'])) {
    		$this->getSession()->addNotice($infos['specials']);
    	}
    	
    	if (isset($infos['commons'])) {
    		$this->getSession()->addNotice($infos['commons']);
    	}
    	
    	$this->loadLayout();    	
    	$this->_initLayoutMessages('customer/session');
    	$this->_initLayoutMessages('sidwishlist/session');
    	$this->renderLayout();
    }
}