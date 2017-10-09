<?php
/**
 * Abstrakter Controller für Merkzettel
 * 
 * @category   	Sid
 * @package    	Sid_Wishlist
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2012 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2012 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Sid_Wishlist_Controller_Abstract extends Mage_Core_Controller_Front_Action
{
	protected $_localFilter = null;
	
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
	 * Liefert den Merzettel Manager
	 * 
	 * @return Sid_Wishlist_Model_Manager
	 */
	protected function _getManager() {
		return Mage::getSingleton('sidwishlist/manager');
	}
	
	/**
	 * Processes localized qty (entered by user at frontend) into internal php format
	 *
	 * @param float $qty Anzahl
	 * 
	 * @return float|int|null
	 */
	protected function _processLocalizedQty($qty)
	{
		if (!$this->_localFilter) {
			$this->_localFilter = new Zend_Filter_LocalizedToNormalized(array('locale' => Mage::app()->getLocale()->getLocaleCode()));
		}
		$qty = $this->_localFilter->filter($qty);
		if ($qty < 0) {
			$qty = null;
		}
		return $qty;
	}
	
	/**
	 * Liefert die Session
	 * 
	 * @return Sid_Wishlist_Model_Session
	 */
	public function getSession() {
		return Mage::getSingleton('sidwishlist/session');
	}
	
	/**
	 * Liefert den Merkzettel aus der Session
	 *
	 * @return Sid_Wishlist_Model_Quote
	 */
	public function getQuote() {
		return $this->getSession()->getQuote();
	}
	
	/**
	 * Prüft ob der aktuelle Nutzer Berechtigter Interessent (BI) oder Besteller (BB) ist.
	 * 
	 * @return bool
	 */
	public function isAuthorizedOrderer() {
		return Mage::helper('sidwishlist')->isAuthorizedOrderer();
	}
	
	/**
	 * Wird vor dem Dispatch aufgerufen
	 *
	 * @return Sid_Wishlist_Controller_Abstract
	 *
	 * @see Mage_Core_Controller_Front_Action::preDispatch()
	 */
	public function preDispatch() {
		parent::preDispatch();
	
		if (!Mage::getSingleton('customer/session')->authenticate($this)) {
			$this->setFlag('', 'no-dispatch', true);
			if (!Mage::getSingleton('customer/session')->getBeforeSidWishlistUrl()) {
				Mage::getSingleton('customer/session')->setBeforeSidWishlistUrl($this->_getRefererUrl());
			}
			Mage::getSingleton('customer/session')->setBeforeSidWishlistRequest($this->getRequest()->getParams());
		}
		if (!Mage::getStoreConfigFlag('sidwishlist/general/active')) {
			$this->norouteAction();
			return $this;
		}
		
		if ($this->getRequest()->isDispatched()
				&& $this->getRequest()->getActionName() !== 'denied'
				&& !$this->_isAllowed()
			) {
			$this->_forward('denied');
			$this->setFlag('', self::FLAG_NO_DISPATCH, true);
	
			return $this;
		}
	
		return $this;
	}
	
	/**
	 * Zugriff verweigert oder nicht angemeldet Aktion
	 * 
	 * @return void
	 */
	public function deniedAction() {
		$this->getResponse()->setHeader('HTTP/1.1', '403 Forbidden');
		$session = Mage::getSingleton('customer/session');
	
		if (!Mage::getSingleton('customer/session')->authenticate($this)) {
			Mage::getSingleton('core/session')->addError($this->__('Access denied, Please first login!'));
			$this->setFlag('', 'no-dispatch', true);
			if (!Mage::getSingleton('customer/session')->getBeforeSidWishlistUrl()) {
				Mage::getSingleton('customer/session')->setBeforeSidWishlistUrl($this->_getRefererUrl());
			}
			Mage::getSingleton('customer/session')->setBeforeSidWishlistRequest($this->getRequest()->getParams());
			return;
		}
	
		Mage::getSingleton('core/session')->addError($this->__("Action not allowed, access denied!"));
		$productId = $this->getRequest()->getParam('product', false);
		$this->_redirect('catalog/product/view', array('id' => $productId));
	}
	
	public function allcartAction() {
		$quote   = $this->getQuote();
		if (!$quote) {
			$this->_forward('noRoute');
			return ;
		}
		$isOwner    = $quote->isOwner(Mage::getSingleton('customer/session')->getCustomerId());
		
		$messages   = array();
		$addedItems = array();
		$notSalable = array();
		$hasOptions = array();
		
		$cart       = Mage::getSingleton('checkout/cart');
		$collection = $quote->getItemsCollection();
		
		$qtys = $this->getRequest()->getParam('qty');
		foreach ($collection as $item) {
			/* @var $item Sid_Wishlist_Model_Quote_Item */
			try {
				$item->unsProduct();
		
				$qty = null;
				// Set qty
				if (isset($qtys[$item->getId()])) {
					$qty = $qtys[$item->getId()];
				}
		
				// Add to cart
				if ($this->_addItemToCart($item, $qty)) {
					$addedItems[] = $item->getProduct();
				}
		
			} catch (Mage_Core_Exception $e) {
				if ($e->getCode() == Sid_Wishlist_Model_Quote_Item::EXCEPTION_CODE_NOT_SALABLE) {
					$notSalable[] = $item;
				} else if ($e->getCode() == Sid_Wishlist_Model_Quote_Item::EXCEPTION_CODE_HAS_REQUIRED_OPTIONS) {
					$hasOptions[] = $item;
				} else {
					$messages[] = $this->__('%s for "%s".', trim($e->getMessage(), '.'), $item->getProduct()->getName());
				}
			} catch (Exception $e) {
				Mage::logException($e);
				$messages[] = Mage::helper('sidwishlist')->__('Cannot add the item to shopping cart.');
			}
		}
		
		if ($isOwner) {
			$indexUrl = Mage::helper('sidwishlist')->getListUrl($quote->getId());
		} else {
			//TODO Implement me
			//$indexUrl = Mage::getUrl('wishlist/shared', array('code' => $quote->getSharingCode()));
			$indexUrl = Mage::helper('sidwishlist')->getListUrl($quote->getSharingCode());
		}
		if (Mage::helper('checkout/cart')->getShouldRedirectToCart()) {
			$redirectUrl = Mage::helper('checkout/cart')->getCartUrl();
		} else if ($this->_getRefererUrl()) {
			$redirectUrl = $this->_getRefererUrl();
		} else {
			$redirectUrl = $indexUrl;
		}
		
		if ($notSalable) {
			$products = array();
			foreach ($notSalable as $item) {
				$products[] = '"' . $item->getProduct()->getName() . '"';
			}
			$messages[] = Mage::helper('sidwishlist')->__('Unable to add the following product(s) to shopping cart: %s.', join(', ', $products));
		}
		
		if ($hasOptions) {
			$products = array();
			foreach ($hasOptions as $item) {
				$products[] = '"' . $item->getProduct()->getName() . '"';
			}
			$messages[] = Mage::helper('sidwishlist')->__('Product(s) %s have required options. Each of them can be added to cart separately only.', join(', ', $products));
		}
		
		if ($messages) {
			$isMessageSole = (count($messages) == 1);
			if ($isMessageSole && count($hasOptions) == 1) {
				$item = $hasOptions[0];
				if ($isOwner) {
					$item->delete();
				}
				$redirectUrl = $item->getProductUrl();
			} else {
				$quoteSession = Mage::getSingleton('sidwishlist/session');
				foreach ($messages as $message) {
					$quoteSession->addError($message);
				}
				$redirectUrl = $indexUrl;
			}
		}
		
		if ($addedItems) {
			// save wishlist model for setting date of last update
			try {
				$quote->save();
			}
			catch (Exception $e) {
				Mage::getSingleton('sidwishlist/session')->addError($this->__('Cannot update wishlist'));
				$redirectUrl = $indexUrl;
			}
		
			$products = array();
			foreach ($addedItems as $product) {
				$products[] = '"' . $product->getName() . '"';
			}
		
			Mage::getSingleton('checkout/session')->addSuccess(
			Mage::helper('sidwishlist')->__('%d product(s) have been added to shopping cart: %s.', count($addedItems), join(', ', $products))
			);
		}
		// save cart and collect totals
		$cart->save()->getQuote()->collectTotals();
		
		$this->_redirectUrl($redirectUrl);
	}
	
	/**
	 * Fügt das Merkzettelelement dem Warenkorb hinzu
	 * 
	 * @param Sid_Wishlist_Model_Quote_Item &$item
	 * @param float                         $qty
	 * 
	 * @return boolean
	 */
	protected function _addItemToCart(&$item, $qty) {
		if (!$qty) {
			$qty = $item->getQty();
		}
		$qty = $this->_processLocalizedQty($qty);
		$request = array();
		if ($qty) {
			$item->addQtyGranted($qty);
			if ($item->getQtyGranted() >= $item->getQty()) {
				$item->setStatus(Sid_Wishlist_Model_Quote_Item::STATUS_ACCEPTED);
			} else {
				$item->setStatus(Sid_Wishlist_Model_Quote_Item::STATUS_BACKORDER);
			}
			
		}
		
		$request['qty'] = $qty;
		$request['uenc'] = Mage::helper('core/url')->getEncodedUrl($item->getProduct()->getProductUrl());
		$request['product'] = $item->getProduct()->getId();
		
		//Individualisierungsoptionen verarbeiten
		$optionIds = $item->getOptionByCode('option_ids');
		if ($optionIds) {
			$optionIds = $optionIds->getValue();
			$optionIds = explode(',', $optionIds);
			$options = array();
			foreach ($optionIds as $id) {
				$option = $item->getOptionByCode("option_$id");
				if (!$option) {
					continue;
				}
				$options[$id] = $option->getValue();
			}
			$request['options'] = $options;
		}
		if ($item->getId() > 0) {
			$request['sidwishlist_item_id'] = $item->getId();
		}
		
		$product = $item->getProduct();
		if ($product->isComposite()) {
			$typeInstance = $product->getTypeInstance(true);
			$typeInstance->setStoreFilter($product->getStoreId(), $product);
			
			$optionCollection = $typeInstance->getOptionsCollection($product);
			
			$selectionCollection = $typeInstance->getSelectionsCollection(
					$typeInstance->getOptionsIds($product),
					$product
			);
			
			$optionCollection= $optionCollection->appendSelections(
					$selectionCollection, false,
					Mage::helper('catalog/product')->getSkipSaleableCheck()
			);
			
			$bundleOptions = array();
			$bundleOptionsQty = array();
			foreach ($optionCollection as $optionId => $option) {
                $_selections = array();
                $_selectionsQty = array();
			    /** @var $child Sid_Wishlist_Model_Quote_Item */
				foreach ($item->getChildren() as $child) {
					$itemProduct = $child->getProduct();
					if (!$itemProduct) {
						continue;
					}
					$itemProductId = $itemProduct->getId();

					foreach ($option->getSelections() as $selection) {
						if ($selection->getProductId() == $itemProductId
								&& $selection->getOptionId() == $optionId) {
							$_selections[] = $selection->getSelectionId();
							if ($child->getQty() > 1) {
								$_selectionsQty[$selection->getSelectionId()] = $child->getQty();
							}
							break;
						}
					}
				}
				if (count($_selections) > 1) {
                    $bundleOptions[$optionId] = $_selections;
                } elseif (!empty($_selections)) {
                    $bundleOptions[$optionId] = array_shift($_selections);
                }

                if (count($_selectionsQty) > 1) {
                    $bundleOptionsQty[$optionId] = $_selectionsQty;
                } elseif (!empty($_selectionsQty)) {
                    $bundleOptionsQty[$optionId] = array_shift($_selectionsQty);
                }
			}
			
			if (!empty($bundleOptions)) {
				$request['bundle_option'] = $bundleOptions;
			}
			if (!empty($bundleOptionsQty)) {
				$request['bundle_option_qty'] = $bundleOptionsQty;
			}
		}
		
		
		$preparedLinks = array();
		switch ($item->getProduct()->getTypeId()) {
			case Mage_Downloadable_Model_Product_Type::TYPE_DOWNLOADABLE:
				if ($item->getProduct()->getLinksPurchasedSeparately()) {
					Mage::getSingleton('checkout/session')->addNotice(Mage::helper('sidwishlist')->__('Product %s have separate links, all links have been selected', $item->getProduct()->getName()));
					//Wichtig sonst funktioniert hinzufügen zum Warenkorb nicht!
					/**
					 * @see Mage_Downloadable_Model_Product_Type::__prepareProduct
					*/
					$links = $item->getProduct()->getTypeInstance(true)->getLinks($item->getProduct());
					foreach ($links as $link) {
						$preparedLinks[] = $link->getId();
					}
				}
				break;
		}
		
		if (!empty($preparedLinks)) {
			$request['links'] = $preparedLinks;
		}
		
		$cart       = Mage::getSingleton('checkout/cart');
	
		return $item->addToCart($cart, $request, false);
	}
}