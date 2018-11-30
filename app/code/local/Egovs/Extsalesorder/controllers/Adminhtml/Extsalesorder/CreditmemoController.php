<?php
require_once "Mage/Adminhtml/controllers/Sales/Order/CreditmemoController.php";
/**
 *  
 * Adminhtml sales order creditmemo controller
 *
 * @category   	 Egovs
 * @package    	 Egovs_Extsalesorder
 * @name       	 Egovs_Extsalesorder_Adminhtml_Extsalesorder_CreditmemoController
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2018 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extsalesorder_Adminhtml_Extsalesorder_CreditmemoController extends Mage_Adminhtml_Sales_Order_CreditmemoController
{
    /**
	 * Kann Gutschrift erstellen?
	 * 
	 * @param Mage_Sales_Model_Order $order Order
	 * 
	 * @return bool
	 * 
	 * @see Mage_Adminhtml_Sales_Order_CreditmemoController::_canCreditmemo()
	 */
	protected function _canCreditmemo($order) {
		/**
         * Check order existing
         */
        if ($order === false || !$order->getId()) {
            $this->_getSession()->addError($this->__('The order no longer exists.'));
            return false;
        }

        /**
         * Check creditmemo create availability
         */
        if (!$order->canCreditmemo()
        	&& abs($order->getTotalPaid()-$order->getTotalRefunded())>=.0001
        	) {
            $this->_getSession()->addError($this->__('Cannot create credit memo for the order.'));
            return false;
        }
        return true;
	}
	
	/**
	 * Eigentliche Speicheraktion
	 * 
	 * @param Mage_Sales_Model_Order_Creditmemo $creditmemo Gutschrift
	 *  
	 * @return Egovs_Extsalesorder_Adminhtml_Extsalesorder_CreditmemoController
	 * 
	 * @see Mage_Adminhtml_Sales_Order_CreditmemoController::_saveCreditmemo()
	 */
    protected function _saveCreditmemo($creditmemo) {
        $transactionSave = Mage::getModel('core/resource_transaction')
            ->addObject($creditmemo)
            ->addObject($creditmemo->getOrder());
        if ($creditmemo->getInvoice()) {
            $transactionSave->addObject($creditmemo->getInvoice());
        }
        
        $this->_checkState($creditmemo->getOrder());
        
        $transactionSave->save();
       
        return $this;
    }
    
    /**
     * Save creditmemo
     * 
     * We can save only new creditmemo. Existing creditmemos are not editable
     * 
     * @return void
     */
    public function saveAction()
    {
        $data = $this->getRequest()->getPost('creditmemo');
        if (!empty($data['comment_text'])) {
        	Mage::getSingleton('adminhtml/session')->setCommentText($data['comment_text']);
        }

        try {
            $creditmemo = $this->_initCreditmemo();
            if ($creditmemo) {
            	$betrag = abs($creditmemo->getOrder()->getBaseTotalPaid()-$creditmemo->getOrder()->getBaseTotalRefunded());
            	
            	//Normale Stornierung (Bestellung > 0 €, Noch kein Geld erhalten)
            	if ($creditmemo->getOrder()->getBaseGrandTotal() > 0.0001 && $creditmemo->getOrder()->getBaseTotalPaid() <= 0.0001
            	) {
            		//Prüfen ob Sendungen existieren
            		if ($creditmemo->getOrder()->hasShipments()) {
            			$creditmemoItems = $creditmemo->getAllItems();
            			if (count($creditmemoItems) < 1) {
            				Mage::throwException($this->__('No Items To Refund, you need at least one not cancelled invoice').'.');
            			}
            			foreach ($creditmemoItems as $item) {
            				if (!$data['items'][$item->getOrderItemId()]['back_to_stock']) {
            					continue;
            				}
            				$item->getOrderItem()->setQtyShipped(
            						max($item->getOrderItem()->getQtyShipped() - $item->getQty(), 0)
            					)->save()
            				;
            			}
            		}
            		//Erst alle Rechnungen Stornieren
            		/* @var $invoice Mage_Sales_Model_Order_Invoice */
            		foreach ($creditmemo->getOrder()->getInvoiceCollection()->getItems() as $invoice) {
            			try {
            				if (!$invoice->canCancel()) {
            					continue;
            				}
            				$invoice->cancel();
            				$this->_saveInvoice($invoice);
            				$this->_getSession()->addSuccess($this->__('Invoice was successfully canceled.'));
            			}
            			catch (Mage_Core_Exception $e) {
            				$this->_getSession()->addError($e->getMessage());
            			}
            			catch (Exception $e) {
            				$this->_getSession()->addError($this->__('Invoice cancel error.'));
            			}
            		}
            		//Dann Bestellung stornieren
            		$order = $creditmemo->getOrder();
            		try {
            			$order->cancel()
            				->save();
            			$this->_getSession()->addSuccess(
            					$this->__('Order was successfully cancelled.')
            			);
            		}
            		catch (Mage_Core_Exception $e) {
            			$this->_getSession()->addError($e->getMessage());
            		}
            		catch (Exception $e) {
            			$this->_getSession()->addError($this->__('Order was not cancelled.'));
            		}
            		
            		$this->_redirect('adminhtml/sales_order/view', array('order_id' => $creditmemo->getOrderId()));
            		//keine weitere Verarbeitung!!!
            		return;
            	}
            	if (array_key_exists('allow_zero_grand_total', $data) && $data['allow_zero_grand_total'] > 0 && $betrag <.0001) {
            		$creditmemo->setAllowZeroGrandTotal(true);
            		/*
            		 * Ab Magento 1.6 notwendig um Order zu schließen
            		 * 
            		 * @see Mage_Sales_Model_Order::_checkState()
            		 */
            		$creditmemo->getOrder()->setForcedCanCreditmemo(false);
            	}
            	
                if (($creditmemo->getGrandTotal() <=0) && (!$creditmemo->getAllowZeroGrandTotal())) {
                    Mage::throwException(
                        $this->__('Credit memo\'s total must be positive.')
                    );
                }
				
                $creditmemoItems = $creditmemo->getAllItems();
                if (count($creditmemoItems) < 1) {
                	Mage::throwException(
                        $this->__('No Items To Refund').'.'
                    );
                } else {
                	$itemsQtyToRefund = 0;
                	foreach ($creditmemoItems as $creditmemoItem) {
                		$itemsQtyToRefund += $creditmemoItem->getQty();
                	}
                	
                	if ($itemsQtyToRefund < 1) {
                		Mage::throwException(
                        $this->__('No Items To Refund').'.');
                	}
                }

                $comment = '';
                if (!empty($data['comment_text'])) {
                    $creditmemo->addComment(
                        $data['comment_text'],
                        isset($data['comment_customer_notify']),
                        isset($data['is_visible_on_front'])
                    );
                    if (isset($data['comment_customer_notify'])) {
                        $comment = $data['comment_text'];

                    }
                }

                if (isset($data['do_refund'])) {
                    $creditmemo->setRefundRequested(true);
                }
                if (isset($data['do_offline'])) {
                    $creditmemo->setOfflineRequested((bool)(int)$data['do_offline']);
                }

                $creditmemo->register();
                if (!empty($data['send_email'])) {
                    $creditmemo->setEmailSent(true);
                }

				$creditmemo->getOrder()->setCustomerNoteNotify(!empty($data['send_email']));
                $this->_saveCreditmemo($creditmemo);
                $creditmemo->sendEmail(!empty($data['send_email']), $comment);
                $this->_getSession()->addSuccess($this->__('The credit memo has been created.'));
                Mage::getSingleton('adminhtml/session')->getCommentText(true);
                $this->_redirect('adminhtml/sales_order/view', array('order_id' => $creditmemo->getOrderId()));
                return;
            } else {
                $this->_forward('noRoute');
                return;
            }
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
			Mage::getSingleton('adminhtml/session')->setFormData($data);
        } catch (Exception $e) {
			Mage::logException($e);
            $this->_getSession()->addError($this->__('Cannot save the credit memo.'));
        }
        $this->_redirect('*/*/new', array('_current' => true));
    }

    /**
     * State prüfen
     *
     * @param Mage_Sales_Model_Order $order Order
     *
     * @return void
     * @see Mage_Sales_Model_Order->_checkState()
     */
    protected function _checkState(Mage_Sales_Model_Order $order = null) {
        if ($order == null) {
            if ($orderId = $this->getRequest()->getParam('order_id')) {
                $order  = Mage::getModel('sales/order')->load($orderId);
            }
        }

        if (!$this->_canCreditmemo($order)) {
            return;
        }

        $data = $this->getRequest()->getPost('creditmemo');
        $unlockCustomer = false;
        if (array_key_exists('special_cancel', $data) && $data['special_cancel'] == true) {
            $unlockCustomer = true;
        }

        $items = array();
        foreach ($order->getAllItems() as $orderItem) {
            if (!$orderItem->isDummy() && !$orderItem->getQtyToRefund()) {
                continue;
            }

            if ($orderItem->isDummy()) {
                $qty = 1;
            } else {
                $qty = $orderItem->getQtyToRefund();
            }

            if ($qty > 0)
                $items[] = $orderItem;
        }

        if (count($items) > 0) {
            return;
        }

        //Bestellung enthält keine Produkte für Gutschrift mehr --> storniert
        //In Magento 1.6 kann der STATE CLOSED nicht mehr von außen gesetzt werden!
// 		$order->setState(Mage_Sales_Model_Order::STATE_CLOSED, true);

        if ($order->getConfig()->getStatusLabel(Egovs_Extsalesorder_Model_Sales_Order::SPECIAL_CANCEL_STATUS)
            && $unlockCustomer
        ) {
            $order->setStatus(Egovs_Extsalesorder_Model_Sales_Order::SPECIAL_CANCEL_STATUS);
        }
    }

    /**
     * Save data for invoice and related order
     *
     * @param Mage_Sales_Model_Order_Invoice $invoice Rechnung
     *
     * @return Egovs_Extsalesorder_Adminhtml_Extsalesorder_CreditmemoController
     */
    protected function _saveInvoice($invoice) {
        $invoice->getOrder()->setIsInProcess(true);
        $transactionSave = Mage::getModel('core/resource_transaction')
            ->addObject($invoice)
            ->addObject($invoice->getOrder())
            ->save();

        return $this;
    }
}