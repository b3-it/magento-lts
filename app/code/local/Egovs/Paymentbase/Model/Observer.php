<?php
/**
 * Oberserver für gemeinsam genutzte Methoden zur ePayment-Kommunikation.
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2011 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Paymentbase_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * Wird beim Zusammenführen von Warenkörben aufgerufen.
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 * 
	 * @throws	Exception
	 */
	public function onQuoteMerge($observer)
	{
		try
		{
			$quote = $observer->getData('quote');
			$this->testCart($quote->getAllVisibleItems());
		}
		catch(Exception $ex){
			Mage::getSingleton('customer/session')->addError($ex->getMessage());
		}
	}
	/**
	 * Wird vor dem Checkout aufgerufen
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onCheckoutEntryBefore($observer)
	{
		$quote = $observer['quote'];
		$adr = $this->getAddress($quote);
		$this->testCart($quote->getAllVisibleItems());
	}
	
	/**
	 * Wird beim updaten des Warenkorbs und vor den Magento-Methoden aufgerufen
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 * 
	 */
	public function onCheckoutCartUpdateItemsBefore($observer)
	{
		$cart = $observer['cart'];
		$request = $observer['request'];
		$product = $observer['product'];
		$quote = $cart->getQuote();


		$item = new Varien_Object(array('qty'=>$request->getQty()));
		$item->setProduct($product);
		$items = $quote->getAllVisibleItems();
		$items[] = $item;
		$this->testCart($items);
		
		
	}
	
	public function onCheckoutCartAddItemsAfter($observer)
	{
		/* @var $cart Mage_Checkout_Model_Cart */
		$cart =  Mage::getSingleton('checkout/cart');
		$request = $observer['request'];
		$product = $observer['product'];
		$response = $observer['response'];
		$quote = $cart->getQuote();
		
		//länge der Buchungsliste ermittel und ggf begrenzen
		$limit = intval(Mage::getStoreConfig('payment_services/paymentbase/accounting_list_limit', $this->getStore()));
		if ($limit > 0) {
			$cartlimit = Mage::getModel('paymentbase/cartlimit');
			$anzahl = $cartlimit->getAccountingListLength($quote);
		
			if ($anzahl > $limit ) {
				$items = $quote->getAllItems();
				$lastitem  = array_pop($items);
				
				
				$lastitem->setQuote($quote);
				/**
				 * If we remove item from quote - we can't use multishipping mode
				*/
				$quote->setIsMultiShipping(false);
				$lastitem->isDeleted(true);
				if ($lastitem->getHasChildren()) {
					foreach ($lastitem->getChildren() as $child) {
						$child->isDeleted(true);
					}
				}
				
				$parent = $lastitem->getParentItem();
				if ($parent) {
					$parent->isDeleted(true);
				}
				
				
				//$cart->removeItem($lastitem->getItemId());
				$cart->save();
				$message = Mage::helper('paymentbase')->__('You can not add this product at your cart. Please use a different order.');
				Mage::getSingleton('checkout/session')->addError($message);
				$response->setRedirect(Mage::getUrl('checkout/cart'));
				
			}
			
			
		}
	}
	

	/**
	 * Validiert den Warenkorb
	 * 
	 * @param array $items Items
	 * 
	 * @return void
	 * 
	 */
	public function testCart($items)
	{
		$count = 0;
		$max = intval(Mage::getStoreConfig('payment_services/paymentbase/maxcounthaushaltsstelle', $this->getStore()));

		if($max == null) return;

		$hstellen = array();


		$h = Mage::getStoreConfig('payment_services/paymentbase/haushaltsstelle');
		$h .= Mage::getStoreConfig('payment_services/paymentbase/objektnummer');
		if ($h != null) {
			if (!isset($hstellen[$h])) {
				$hstellen[$h] = array();
			}
			$hstellen[$h][] = 'Versandeigenschaften';
		}

		foreach ($items as $item) {
			if ($item->getParentItem()) {
				continue;
			}
			$product = $item->getProduct();
			 
			$h = $product->getHaushaltsstelle();
			$h .= $product->getObjektnummer();
			
			if ($h != null) {
				if (!isset($hstellen[$h])) {
					$hstellen[$h] = array();
				}
				$hstellen[$h][] = $item->getProduct()->getName();
			}
			 
			$h = $product->getHaushaltsstelle();
			$h .= $product->getObjektnummerMwst();
			if ($h != null) {
				if (!isset($hstellen[$h])) {
					$hstellen[$h] = array();
				}
				$hstellen[$h][] = $item->getProduct()->getName();
			}

		}

		if (count($hstellen) > $max) {
			$names = "";
			while (count($hstellen) > $max) {
				$name = array_pop($hstellen);
				$names .= implode(',',$name);
			}
			 

			Mage::throwException(Mage::helper('paymentbase')->__('You can not add this product at your cart. Please use a different order.'));
		}
	}
	
	/**
	 * Löscht abgelaufene Gateway Bestellungen
	 *
	 * @param Mage_Cron_Model_Schedule $schedule Zeitplan
	 * 
	 * @return Egovs_Paymentbase_Model_Observer
	 */
	public function cleanExpiredGatewayOrders($schedule) {
		$payments = array(
		    'giropay',
            'saferpay',
            'paypage',
            'payplacepaypage',
            'payplacegiropay',
            'egovs_girosolution_giropay',
            'egovs_girosolution_creditcard',
            'gka_tkonnektpay_debitcard',
        );
		
		foreach ($payments as $payment) {
			$lifetimes = Mage::getConfig()->getStoresConfigByPath("payment/$payment/cancel_order_after");
			$actives = Mage::getConfig()->getStoresConfigByPath("payment/$payment/cancel_order_after_active");
			foreach ($lifetimes as $storeId=>$lifetime) {
				if (!array_key_exists($storeId, $actives) || !$actives[$storeId]) {
					continue;
				}
				
				if ($lifetime < 10) {
					$lifetime = 10;
				}
				$lifetime *= 60;
			
				$orders = Mage::getModel('sales/order')->getCollection();
				
				//Magento > 1.4.1
				/* @var $orders Mage_Sales_Model_Resource_Order_Collection */
				$orders->addFieldToFilter('state', array('in' => array(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW)));
				$orders->join(
							array('payment_table' => 'sales/order_payment'),
							$orders->getConnection()->quoteInto('parent_id=main_table.entity_id AND method = ?', $payment),
							array('payment_method' => 'method')
						)
				;

				$orders->addFieldToFilter('store_id', $storeId);
				
				$dateObj = Mage::app()->getLocale()->date(time() - $lifetime);
				//convert store date to default date in UTC timezone without DST
				$dateObj->setTimezone(Mage_Core_Model_Locale::DEFAULT_TIMEZONE);
				$orders->addFieldToFilter('updated_at', array('to'=>date("Y-m-d H:i:s", $dateObj->getTimestamp())));
				/* Mage::log(sprintf("paymentbase::Clear expired orderes SQL:\n%s", $orders->getSelect()->assemble()),
						Zend_Log::DEBUG,
						Egovs_Helper::LOG_FILE
				); */
				
				$count = $orders->count();
				if ($count > 0) {
					Mage::log(sprintf("paymentbase::Cancelling %d orders with 'updated_at': %s and payment method: $payment", $count, date('Y-m-d H:i:s', $dateObj->getTimestamp())),
								Zend_Log::DEBUG,
								Egovs_Helper::LOG_FILE
					);
				}
				
				foreach ($orders->getAllIds() as $id) {
					/** @var $order Mage_Sales_Model_Order */
					$order = Mage::getModel('sales/order')->load($id);
					
					if ($order->isEmpty()) {
						continue;
					}

                    // Start store emulation process
                    $appEmulation = Mage::getSingleton('core/app_emulation');
                    $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($order->getStoreId());
                    //Dealing with uninitialized translator!
                    Mage::app()->getTranslator()->init('frontend', true);
                    $translateHelper = Mage::helper('paymentbase');
                    // Stop store emulation process
                    $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);

					if ($order->getState() == Mage_Sales_Model_Order::STATE_PAYMENT_REVIEW) {
						//Girosolution Besonderheiten
						if ($order->hasInvoices()) {
							//Rechnungen werden bei Girosolution erst nach der Bestätigung bei Girosolution erstellt
							continue;
						}
						
						//Im State STATE_PAYMENT_REVIEW ist kein Cancel möglich!
						$order->setState(Mage_Sales_Model_Order::STATE_PENDING_PAYMENT, false, $translateHelper->__('Modifying state for further processing.'), false);
					}
					/* @var $item Mage_Sales_Model_Order */
					if ($order->canCancel()) {
					    try {
                            $order->cancel();
                            //Der Kunde muss nicht benachrichtigt werden, da er noch keine Mail über die Bestellung erhalten hat!
                            $order->addStatusHistoryComment($translateHelper->__('Payment session has expired.'));
                            $order->save();
                        } catch (Exception $e) {
					        Mage::logException($e);
                        }
						continue;
					}
					
					//Falls nicht storniert werden kann
					if ($order->canUnhold()) {  // $this->isPaymentReview()
						continue;
					}
					
					$state = $order->getState();
					if ($order->isCanceled() || $state === Mage_Sales_Model_Order::STATE_COMPLETE || $state === Mage_Sales_Model_Order::STATE_CLOSED) {
						continue;
					}
						
					if ($order->getActionFlag(Mage_Sales_Model_Order::ACTION_FLAG_CANCEL) === false) {
						continue;
					}
					
					$allCanceled = true;
					foreach ($order->getAllItems() as $orderItem) {
					    /** @var Mage_Sales_Model_Order_Item $orderItem */
						if ($orderItem->getStatusId() != Mage_Sales_Model_Order_Item::STATUS_CANCELED) {
							$allCanceled = false;
							break;
						}
					}
					if (!$allCanceled) {
						//Irgendetwas stimmt nicht
						if ($order->canHold()) {
							$order->hold();
							$order->addStatusHistoryComment($translateHelper->__('Payment session has expired, but an unknown error occured. Please contact support!'));
						} else {
							$order->addStatusHistoryComment($translateHelper->__('Payment session has expired, hold is not possible an unknown error occured. Please contact support!'));
						}
						$order->save();
						continue;
					}
					//Mage_Sales_Model_Order::cancel()
					$order->getPayment()->cancel();
					
					//Mage_Sales_Model_Order::registerCancellation()
					$order->setSubtotalCanceled($order->getSubtotal() - $order->getSubtotalInvoiced());
					$order->setBaseSubtotalCanceled($order->getBaseSubtotal() - $order->getBaseSubtotalInvoiced());
					
					$order->setTaxCanceled($order->getTaxAmount() - $order->getTaxInvoiced());
					$order->setBaseTaxCanceled($order->getBaseTaxAmount() - $order->getBaseTaxInvoiced());
					
					$order->setShippingCanceled($order->getShippingAmount() - $order->getShippingInvoiced());
					$order->setBaseShippingCanceled($order->getBaseShippingAmount() - $order->getBaseShippingInvoiced());
					
					$order->setDiscountCanceled(abs($order->getDiscountAmount()) - $order->getDiscountInvoiced());
					$order->setBaseDiscountCanceled(abs($order->getBaseDiscountAmount()) - $order->getBaseDiscountInvoiced());
					
					$order->setTotalCanceled($order->getGrandTotal() - $order->getTotalPaid());
					$order->setBaseTotalCanceled($order->getBaseGrandTotal() - $order->getBaseTotalPaid());
					
					$order->setState(
							Mage_Sales_Model_Order::STATE_CANCELED,
							false,
							$translateHelper->__('Payment session has expired.'),
							false
					);
					Mage::dispatchEvent('order_cancel_after', array('order' => $order));
					
					$order->save();
				}
			}
		}
		return $this;
	}
	
	/**
	 * Fügt eine Notiz zu Adminbestellungen hinzu falls der Kunde noch offene Bestellungen hat
	 * 
	 * @param Varien_Object $observer Observer
	 * 
	 * @return void
	 */
	public function onAdminSalesOrderCreate($observer) {
		if (!$observer->hasAction() || !($observer->getAction() instanceof Mage_Adminhtml_Sales_Order_CreateController)) {
			return;
		}
		
		$session = Mage::getSingleton('adminhtml/session_quote');
		$customerId = $session->getCustomerId();
		if (!$customerId) {
			return;
		}
		
		if ($session->hasCachedOpenInvoices()) {
			$size = $session->getCachedOpenInvoices();
		} else {
			$collection = Mage::getModel('sales/order_invoice')->getCollection();
			/* @var $collection Mage_Sales_Model_Resource_Order_Invoice_Collection */
			$collection->join(array('orders' => 'sales/order'), "orders.entity_id = main_table.order_id and orders.customer_id = $customerId", 'customer_id')
				->addAttributeToFilter('main_table.state', array('eq' => Mage_Sales_Model_Order_Invoice::STATE_OPEN))
			;
			
// 			Mage::log('sql::'.$collection->getSelect()->assemble(), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			
			$size = $collection->getSize();
			$session->setData('cached_open_invoices', $size);
		}
		if ($size > 0) {
			$session->addNotice(Mage::helper('paymentbase')->__('This customer has %s open invoices', $size));
		}
	}
	
	/**
	 * Workaround für authorize_capture Payments
	 * 
	 * Payments mit authorize_capture (Debit & DebitPIN) überführen virtuelle Bestellungen nicht direkt in den State/Status Vollständig über.
	 * Das Problem liegt an Mage_Sales_Model_Order::_checkState, welches den endgültigen State erst nach dem ersten Speichern der Order zulässt.
	 * 
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onSalesOrderPaymentPlaceEnd($observer) {
		$payment = $observer->getPayment();
		
		if (!$payment) {
			return;
		}
		
		/* @var $order Mage_Sales_Model_order */
		$order = $payment->getOrder();
		
		//Soll nur nach dem ersten Speichern aufgerufen werden
		if (!$order || $order->isEmpty() || $order->getId()) {
			return;
		}
		
		if (!$order->isCanceled()
			&& !$order->canUnhold()
			&& !$order->canInvoice()
			&& !$order->canShip()
		) {
			if ($order->canCreditmemo() && $order->getIsVirtual()) {
				if ($order->getState() !== Mage_Sales_Model_Order::STATE_COMPLETE) {
					$order->setData('state', Mage_Sales_Model_Order::STATE_COMPLETE);
					$status = $order->getConfig()->getStateDefaultStatus($order->getState());
					
					$order->setStatus($status);
					$history = $order->addStatusHistoryComment(Mage::helper('paymentbase')->__('Nothing to ship, order is complete'), false); // no sense to set $status again
					$history->setIsCustomerNotified(false); // for backwards compatibility
				}
			}
		}
	}
	
	/**
	 * Wird beim speichern einer Bestellung aufgerufen
	 * 
	 * Eine Verarbeitung erfolgt nur beim ersten Speichervervorgang
	 *
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function onFirstSalesOrderSaveAfter($observer) {
		/* @var $order Mage_Sales_Model_order */
		$order = $observer->getOrder();
		
		//Soll nur nach dem ersten Speichern aufgerufen werden
		if (!$order || $order->isEmpty() || count($order->getOrigData()) > 0) {
			return;
		}
		
		$payment = $order->getPayment();
		if (!$payment || $payment->isEmpty()) {
			return;
		}
		
		if (!$payment->hasData('kassenzeichen')) {
			return; 
		}
		
		$bkz = $payment->getKassenzeichen();
		$transaction = Mage::getModel('paymentbase/transaction')->load($bkz);
		
		if ($transaction->isEmpty()) {
			return;
		}
		
		$transaction->delete();
	}
	
	/**
	 * Löscht den Kunden an der ePayment-Plattform
	 *
	 * Wird nach dem löschen eines Kunden aufgerufen.
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return Egovs_Paymentbase_Model_Observer
	 *
	 * @throws Exception
	 */
	public function doDeleteFromPlatform($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
	
		/* @var $helper Egovs_Paymentbase_Helper_Data */
		$helper = Mage::helper('paymentbase');
			
		if (!$helper) {
			return $this;
		}
		
		if (!($customer instanceof Mage_Customer_Model_Customer)) {
			return $this;
		}

		/*
		 * 20130308::Frank Rochlitzer
		 * Alle Kunden die an der ePayBL dauerhaft gespeichert werden, haben die ePayBL-Kunden-ID im Shop gespeichert.
		 */
		if ($customer->isEmpty()
			|| !$customer->hasData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID)
			|| !$customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID)
		) {
			return $this;
		}
		
		$customer->setDeleteOnPlatform(true);
		$objResult = $helper->loeschenKunde($customer, 'paymentbase', true);
	
		// wenn Fehler dann Mail an Admin
		if (!$objResult || $objResult instanceof SoapFault) {
			$sMailText = $helper->__('Error on call: loeschenKunde:\n');
			if ($objResult instanceof SoapFault) {
				$sMailText .= "SOAP: " . $objResult->getMessage() . "\n\n";
			} elseif (!$objResult) {
				$sMailText .= $helper->__("Error: Couldn't delete the customer on the ePayment server, no result returned!")."\n";
			}
				
			//Mage::throwException($sMailText);
			Mage::log($sMailText, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			return $this;
		}
	
		//Falls Fehler
		if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis) {
			$objResult = $objResult->ergebnis;
		}
		
		if ($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis && $objResult->getCodeAsInt() < 0) {
			//Kunde nicht vorhanden -> nur loggen!
			if ($objResult->getCodeAsInt() != -199) {
				$error = sprintf('Code: %s : %s', $objResult->getCode(), $objResult->getShortText());
				//Egovs_Paymentbase_Helper_Data::parseAndThrow($error, 'paymentbase');
				Mage::log($error, Zend_Log::ERR, Egovs_Helper::LOG_FILE);
			} else {
				Mage::log("paymentbase::The customer doesn't exist on the ePayment server (ID: {$customer->getId()}", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
			}
		}
	}
	
	/**
	 * Gibt einen Adressänderung an die ePayment-Plattform weiter.
	 *
	 * Wird nach dem speichern eines Kunden aufgerufen.<br>
	 * Falls keine Adresse mehr am Kunden existiert, wird der Kunde an der Plattform gelöscht.
	 *
	 * @param Varien_Event_Observer $observer Observer
	 *
	 * @return void
	 */
	public function doInformPattform($observer) {
		/* @var $customer Mage_Customer_Model_Customer */
		$customer = $observer->getCustomer();
	
		if (!$customer || $customer->getId() < 1) {
			return;
		}
	
		/* @var $helper Egovs_Paymentbase_Helper_Data */
		$helper = Mage::helper('paymentbase');		
		
		if (!$helper) {
			return;
		}
		
		$helper->changeCustomerAddressOnPlattform($customer);
	}
	
	public function syncBankAccountDataWithePayBL($schedule) {
		$_autoSync = Mage::getStoreConfigFlag('payment_services/paymentbase/auto_sync_epaybl_data');
		 
		if (!$_autoSync) {
			Mage::log(
				Mage::helper('paymentbase')->__('Bank account data synchronization with ePayBL is not enabled. Please enable it under Payment Services/ePayBL Settings'),
				Zend_Log::INFO,
				Egovs_Helper::LOG_FILE
			);
			return $this;
		}
		try {
			//Bei Zertifikatfehlern gibt PHP Soap die Meldung als Warning aus.
			//der SoapClient setzt das error_reporting jedoch immer auf 0 -> siehe mageCoreErrorHandler!
			set_error_handler(array(Mage::helper('paymentbase'), 'epayblErrorHandler'));
			Mage::helper('paymentbase/sync_bankAccountData')->sync();
			Mage::log(
				Mage::helper('paymentbase')->__('Bank account data synchronized with ePayBL Server'),
				Zend_Log::DEBUG,
				Egovs_Helper::LOG_FILE
			);
		} catch (Exception $e) {
			Mage::logException($e);
			Mage::log(
				Mage::helper('paymentbase')->__('The ePayBL Server is not available, check log files for further information.'),
				Zend_Log::ERR,
				Egovs_Helper::LOG_FILE
			);
		}
		restore_error_handler();
	}

	public function onSalesOrderInvoicePay(Varien_Event_Observer $observer) {
        /** @var \Mage_Sales_Model_Order_Invoice $invoice */
	    $invoice = $observer->getEvent()->getInvoice();
        if (is_null($invoice)) {
            return null;
        }

        if (!$invoice->getOrder()) {
            return null;
        }
        $payment = $invoice->getOrder()->getPayment();

        if (!$payment) {
            return null;
        }

        if(!$invoice->getOrderId()){
            return null;
        }

        $incomingPayment = Mage::getModel('paymentbase/incoming_payment');
        $incomingPayment->saveIncomingPayment($invoice->getOrderId(),$invoice->getOrder()->getBaseTotalPaid(),$invoice->getOrder()->getTotalPaid());



        $payment->setEpayblCaptureDate(Varien_Date::now());
        $payment->getResource()->saveAttribute($payment, Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CAPTURE_DATE);
    }
}