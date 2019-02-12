<?php
class Egovs_Paymentbase_Model_Payplace_Api_V2 extends Mage_Api_Model_Resource_Abstract
{
	protected $_module = "payplace";
	
	/**
	 * Dispatches fault
	 *
	 * @param string $code
	 */
	protected function _fault($code, $customMessage=null) {
		$apiException = new Mage_Api_Exception($code, $customMessage);
		Mage::logException($apiException);
		throw $apiException;
	}
	
	/**
	 * Method to call the operation originally named notify
	 * 
	 * @param Egovs_Paymentbase_Model_Payplace_Types_Callback_Request $_payplaceStructCallbackRequest
	 * 
	 * @return Egovs_Paymentbase_Model_Payplace_Types_Callback_Response
	 */
	public function notify(Egovs_Paymentbase_Model_Payplace_Types_Callback_Request $_payplaceCallbackRequest)
	{
		try {
			Mage::log("{$this->_module}::notify called", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			/* @var $_adapter Mage_Api_Model_Server_Wsi_Adapter_Soap */
			$_adapter = $this->_getServer()->getAdapter();
			$xml = $_adapter->getController()->getRequest()->getRawBody();
// 			$xml = $postdata = file_get_contents("php://input");
			Mage::log("PayPlace notify request: \n".$xml, Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
			
			if (intval($_payplaceCallbackRequest->getPaymentResponse()->getRc()) != 0) {
				$_rc = $_payplaceCallbackRequest->getPaymentResponse()->getMessage();
				Mage::log($_rc, Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
				$this->_fault('rc_invalid', $_rc);
			}
			//Basketid: bewischafternummer/kassenzeichen
			list($bewirtschafterNr, $kassenzeichen) = explode('/', $_payplaceCallbackRequest->getPaymentResponse()->getBasketId());
			if ((!$kassenzeichen) || (!$bewirtschafterNr)) {
				$this->_fault('basket_id_invalid');
			}
			
			$orderId = $_payplaceCallbackRequest->getPaymentResponse()->getAdditionalData();
			if (!is_numeric($orderId)) {
				$orderId = $_payplaceCallbackRequest->getPaymentResponse()->getEventExtId();
			}
			if (empty($orderId) || !is_numeric($orderId)) {
				$this->_fault('order_id_invalid');
			}
			$orderId = intval($orderId);
			
			/* @var $order Mage_Sales_Model_Order */
			$order = Mage::getModel('sales/order')->load($orderId);
			
			if (!$order || $order->isEmpty()) {
				$this->_fault('order_not_found');
			}
			
			/* @var $hash Egovs_Paymentbase_Helper_Payplace_Hash */
			$hash = Mage::helper('paymentbase/payplace_hash');
			
			$orderHash = $hash->getHash4Order($order);
			$reqHash = $hash->getHash($orderId, 
									  $bewirtschafterNr, 
									  $kassenzeichen, 
									  $_payplaceCallbackRequest->getPaymentResponse()->getAmount(),
									$_payplaceCallbackRequest->getPaymentResponse()->getCurrency());
			
			//verify	
			
			if (($orderHash != $_payplaceCallbackRequest->getId()) || ($orderHash != $reqHash)) {
				$this->_fault('id_invalid');
			}
			
			$payment = $order->getPayment();
			$paymentInst = $payment->getMethodInstance();
			$this->_module = $payment->getMethod();
			//if($payment->getKassenzeichen() == $kassenzeichen)
			{
				/*
				if ($this->_getOrder()->getData('status') != Mage_Sales_Model_Order::STATE_PENDING_PAYMENT) {
	    				Mage::log("$module::NOTIFY_ACTION:Saferpay notify already called, omitting!", Zend_Log::INFO, Egovs_Helper::LOG_FILE);
	    				return;
	    		}
		    	//dauert ca. 340msec
		    	//$this->_getOrder()->setData('status', 'notify')->save();
		    	//dauert ca. 32msec
		    	$this->_getOrder()->setData('status', 'notify');
		    	$resource = $this->_getOrder()->getResource();
		    	$resource->saveAttribute($this->_getOrder(), 'status');
		    	*/
				
				
				
				if ($order->canInvoice() && ($order->getState() == Mage_Sales_Model_Order::STATE_PENDING_PAYMENT)) {
					$kartenTyp = null;
					$referenzId = $_payplaceCallbackRequest->getPaymentResponse()->getTxExtId();
					$wid = $_payplaceCallbackRequest->getPaymentResponse()->getBasketId();
					
					if ($_payplaceCallbackRequest->getPaymentResponse()->getKind() == Egovs_Paymentbase_Model_Payplace_Enum_KindEnum::VALUE_CREDITCARD) {
						switch ($_payplaceCallbackRequest->getPaymentResponse()->getBrand()) {
							case "MasterCard":
								$kartenTyp = "MASTER";
								break;
							case "Visa":
								$kartenTyp = "VISA";
								break;
						}
						
						if (!$kartenTyp) {
							$msg = sprintf('Unkown creditcard type %s', $_payplaceCallbackRequest->getPaymentResponse()->getBrand());
							$this->_log($msg, Zend_Log::ERR);
							$this->_fault('unknown_creditcard_type', $msg);
						}
					}
					
					// so, jetzt Zugriff auf SOAP-Schnittstelle beim eGovernment
					$objResult = null;
					for ($i = 0; $i < 3 && !($objResult instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_Ergebnis) && (!$objResult || !$objResult->isOk()); $i++) {
						$this->_log(sprintf("NOTIFY_ACTION:Try %s to activate kassenzeichen...", $i+1));
						try {
							//Aktiviert z. B. das Kassenzeichen
							$objResult = $paymentInst->aktiviereKassenzeichen($wid, $referenzId, $kartenTyp);
						} catch (Exception $e) {
							$this->_log(sprintf("NOTIFY_ACTION:Activating Kassenzeichen failed: %s", $e->getMessage()), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
						}
					}
					$this->_log(sprintf("NOTIFY_ACTION:Tried to activate Kassenzeichen, validating result..."), Zend_Log::DEBUG);
					
					// wenn Web-Service nicht geklappt hat
					if (!$objResult || !$objResult->isOk()) {
						$kassenzeichen = 'empty';
						$subject = "{$this->_module}::NOTIFY_ACTION:WS aktiviereTempKassenzeichen() nicht erfolgreich";
						$sMailText = '';
						if ($order->getPayment()->hasData('kassenzeichen')) {
							$kassenzeichen = $order->getPayment()->getKassenzeichen();
					
							$this->_log("$subject!\n\nKassenzeichen:$kassenzeichen\n\n".var_export($objResult, true), Zend_Log::WARN);
							$sMailText = "Während der Kommunikation mit dem ePayment-Server trat ein Fehler auf!\n\nKassenzeichen:$kassenzeichen\n";
							$sMailText .= "Falls das jeweilige Kassenzeichen bereits aktiviert wurde, kann dieser Fehler ignoriert werden.\n";
							$sMailText .= "Überprüfen Sie hierzu die entsprechenden Protokolldateien (Logfiles)!\n\n";
							if ($objResult) {
								$sMailText .= "ObjResult:\n".var_export($objResult, true);
							}
						} else {
							$this->_log("$subject\n\n".var_export($objResult, true), Zend_Log::WARN);
							$sMailText = "Während der Kommunikation mit dem ePayment-Server trat ein Fehler auf!\n\n";
							$sMailText .= "Überprüfen Sie hierzu die entsprechenden Protokolldateien (Logfiles)!\n\n";
							if ($objResult) {
								$sMailText .= "ObjResult:\n".var_export($objResult, true);
							}
						}
						Mage::helper("paymentbase")->sendMailToAdmin($sMailText, $subject);
						$this->_fault("epaybl_call_error", $sMailText);
					} else {
						$kassenzeichen = 'empty';
						if ($order->getPayment()->hasData('kassenzeichen')) {
							$kassenzeichen = $order->getPayment()->getKassenzeichen();
							$this->_log("NOTIFY_ACTION:Using Kassenzeichen: $kassenzeichen");
						} else {
							$this->_log("Fehler:WS kein Kassenzeichen im Payment enthalten", Zend_Log::ERR);
							$sMailText = "WS kein Kassenzeichen im Payment enthalten!";
								
							Mage::helper("paymentbase")->sendMailToAdmin($sMailText);
						}
						$this->_log("WS Kassenzeichen successfully activated : $kassenzeichen", Zend_Log::NOTICE);
					}
					
					// it's a valid order
					$this->_log("Order is valid, preparing invoice...");
					$invoicable = true;
				
						//STATE_COMPLETE ist in Magento 1.6 geschützt
						//wird für Virtuelle Produkte aber automatisch gesetzt
						$orderState = Mage_Sales_Model_Order::STATE_PROCESSING;
					
					$order->setState($orderState);
				
					$orderStatus = Mage::getStoreConfig("payment/".$this->_module."/order_status");
				
					if (!$orderStatus || $order->getIsVirtual()) {
						$orderStatus = $order->getConfig()->getStateDefaultStatus($orderState);
					}
					 
					$order->sendNewOrderEmail();
					// we add a status message to the message-section in admin
					$order->addStatusToHistory($orderStatus, Mage::helper($this->_module)->__('Customer successfully granted by Payplace'), true);
				
					$invoice = $order->prepareInvoice();
				
					$invoice->register();
					if ($paymentInst->canCapture()) {
						$invoice->capture();
					}
					$order->addRelatedObject($invoice);
					$invoice->setOrder($order);
					$invoice->save();
					
					if (!$invoicable && !$order->hasInvoices()) {
						/*
						 * payment was not successfull. this code should not be executed
						* to make it safe, we redirect to failure action
						*/
						$msg= Mage::helper($this->_module)->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper('paymentbase')->getCustomerSupportMail());
						$this->_log("NOTIFY_ACTION:NOT INVOICABLE NO EXISTING INVOICES : $msg", Zend_Log::ERR);
						$order->addStatusToHistory(Mage_Sales_Model_Order::STATE_CANCELED, $msg, true);
						if ($order->canCancel()) {
							$order->cancel();
						}
						$order->sendOrderUpdateEmail(true, Mage::helper($this->_module)->__('TEXT_PROCESS_ERROR_STANDARD', Mage::helper('paymentbase')->getCustomerSupportMail()));
						$this->_fault('data_invalid');
					} else {
						$order->addStatusToHistory($order->getState(), Mage::helper($this->_module)->__('Order is now ready for processing'));
					}
					$order->save();
					$this->_log("NOTIFY_ACTION:order saved!");
				
				}	
			}
			
			$response = new Egovs_Paymentbase_Model_Payplace_Types_Callback_Response($_payplaceCallbackRequest->getId(), $_payplaceCallbackRequest->getVersion());
			
			return $response;
		}
		catch(SoapFault $soapFault) {
			$this->_fault('data_invalid', $soapFault->getMessage());
		}
	}
	
	
	protected function _log($msg, $logLevel =  Zend_Log::DEBUG, $logFile = Egovs_Helper::LOG_FILE) {
		Mage::log($this->_module.'::'.$msg, $logLevel, $logFile);	
	}
}