<?php
/**
 * Controller für Merkzettel-Item-Aktionen
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Wishlist_Quote_ItemController extends Sid_Wishlist_Controller_Abstract
{
	/**
	 * Prüft ob de Aktion erlaubt ist
	 *
	 * @return bool
	 */
	protected function _isAllowed() {
		//TODO: Implement Role Check!
		return true;
	}
	
	/**
	 * Löscht ein Element von der Merkliste
	 * 
	 * @return void
	 */
	public function deleteAction() {
		/*
		 * Load an object by id
		 * Request looking like:
		 * http://site.com/sidwishlist?id=15
		 *  or
		 * http://site.com/sidwishlist/id/15
		 */

		$quoteItemId = $this->getRequest()->getParam('id');
		$backUrl = $this->getRequest()->getParam(Mage_Core_Controller_Varien_Action::PARAM_NAME_URL_ENCODED);
		$backUrl = Mage::helper('core/url')->urlDecode($backUrl);

		if ($quoteItemId != null && $quoteItemId != '') {
			$quoteItem = Mage::getModel('sidwishlist/quote_item')->load($quoteItemId);
		} else {
			$quoteItem = null;
		}
		
		if (!$quoteItem || $quoteItem->isEmpty()) {
			$this->getSession()->addError($this->__('No collection item available!'));
			$this->_redirectUrl($backUrl);
			return;
		}
		
		$quoteItem->delete();
		$quoteItem->getQuote()->collectTotals()
			->save()
		;
		$this->getSession()->addSuccess($this->__("Collection item successfully deleted"));
		
		$this->_redirectUrl($backUrl);
	}
	
	/**
	 * Löscht alle Elemente von der Merkliste
	 * 
	 * @return void
	 */
	public function deleteAllAction() {
		/*
		 * Load an object by id
		* Request looking like:
		* http://site.com/sidwishlist?id=15
		*  or
		* http://site.com/sidwishlist/id/15
		*/
	
		$quoteId = $this->getRequest()->getParam('id');
	
		/* @var $quote Sid_Wishlist_Model_Quote */
		if ($quoteId != null && $quoteId != '') {
			$quote = Mage::getModel('sidwishlist/quote')->load($quoteId);
		} else {
			$quote = null;
		}
	
		if (!$quote || $quote->isEmpty()) {
			$this->getSession()->addError($this->__('No collection list available'));
			return;
		}
	
		$count = 0;
		foreach ($quote->getAllVisibleItems() as $item) {
			$item->delete();
			$count++;
		}
		$quote->collectTotals()
			->save()
		;
	
		$this->getSession()->addSuccess($this->__("%s collection items successfully deleted.", $count));
	
		$this->_redirect('*/index');
	}
	
	/**
	 * Fügt ein Element zum Warenkorb hinzu
	 * 
	 * @return void
	 */
	public function cartAction() {
		$quote   = $this->getQuote();
        if (!$quote) {
            return $this->_redirect('*/index');
        }

        if (!$this->isAuthorizedOrderer()) {
        	$this->getSession()->addError($this->__('Action not allowed!'));
        	return $this->_redirect('*/index');
        }
        
        $itemId = (int) $this->getRequest()->getParam('item');

        /* @var $item Sid_Wishlist_Model_Quote_Item */
        //$item = Mage::getModel('sidwishlist/quote_item')->load($itemId);
        //Nötig um Sales Quote zu laden und neueste Daten
        $item = $quote->getItemById($itemId)->load($itemId);
        
        if (!$item->getId() || $item->getQuoteId() != $quote->getId()) {
            return $this->_redirect('*/index');
        }

        // Set qty
        $qty = $this->getRequest()->getParam('qty');
        if (is_array($qty)) {
            if (isset($qty[$itemId])) {
                $qty = $qty[$itemId];
            } else {
                $qty = $item->getQty();
            }
        }
        
        $session    = $this->getSession();
        $cart       = Mage::getSingleton('checkout/cart');

        $redirectUrl = Mage::getUrl('*/index');

        try {
            $this->_addItemToCart($item, $qty);
            
            $cart->save()->getQuote()->collectTotals();
            $quote->collectTotals()->save();

//             Mage::helper('wishlist')->calculate();

            if (Mage::helper('checkout/cart')->getShouldRedirectToCart()) {
                $redirectUrl = Mage::helper('checkout/cart')->getCartUrl();
            } else if ($this->_getRefererUrl()) {
                $redirectUrl = $this->_getRefererUrl();
            }
//             Mage::helper('wishlist')->calculate();
        } catch (Mage_Core_Exception $e) {
            if ($e->getCode() == Mage_Wishlist_Model_Item::EXCEPTION_CODE_NOT_SALABLE) {
                $session->addError(Mage::helper('wishlist')->__('This product(s) is currently out of stock'));
            } else if ($e->getCode() == Mage_Wishlist_Model_Item::EXCEPTION_CODE_HAS_REQUIRED_OPTIONS) {
            	Mage::getSingleton('sidwishlist/session')->addNotice($e->getMessage());
            	$redirectUrl = Mage::getUrl('*/index/view/', array('id' => $quote->getId()));
            } else {
            	Mage::getSingleton('sidwishlist/session')->addNotice($e->getMessage());
                $redirectUrl = Mage::getUrl('*/index/view/', array('id' => $quote->getId()));
            }
        } catch (Exception $e) {
            $session->addException($e, Mage::helper('sidwishlist')->__('Cannot add item to shopping cart'));
        }

//         Mage::helper('wishlist')->calculate();

        return $this->_redirectUrl($redirectUrl);
	}
}