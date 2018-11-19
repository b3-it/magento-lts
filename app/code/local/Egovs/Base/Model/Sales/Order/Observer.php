<?php
/**
 * Evenbasiertes Senden von Bestellmails
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Holger Kögel <h.koegel@b3-it.de>
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2012 - 2017 B3 IT Systeme GmbH <https://www.b3-it.de>
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_Base_Model_Sales_Order_Observer extends Mage_Core_Model_Abstract {
	
	public function onSaferpaySalesOrderInvoiceAfterPay($observer) {
		$invoice = $observer->getInvoice ();
		if ($invoice instanceof Mage_Sales_Model_Order_Invoice) {
			
			$this->_sendInvoice ( $invoice );
		}
	}
	
	public function onCheckoutSubmitAllAfter($observer) {
		$order = $observer->getOrder ();
		if ($order == null) {
			return;
		}
		$icollection = Mage::getResourceModel ( 'sales/order_invoice_collection' )->addAttributeToSelect ( '*' )->setOrderFilter ( $order->getId () );
		$invoice = null;
		foreach ($icollection->getItems () as $item) {
			$invoice = $item;
		}
		
		$this->_sendInvoice ( $invoice );
	}

    /**
     * @param $invoice \Mage_Sales_Model_Order_Invoice
     *
     * @return void
     */
	private function _sendInvoice($invoice) {
		if ($invoice == null) {
            return;
        }
		if ($invoice->getEmailSent ()) {
            return;
        }
		if ($invoice->getDoNotSendEmail ()) {
            return;
        }
		if (Mage::getStoreConfig ( "sales_email/invoice/send_mail", $invoice->getStoreId () ) == 0) {
            return;
        }
        if (Mage::getStoreConfig ( "sales_email/invoice/send_mail", $invoice->getStoreId () ) == 2
            && (0.01 <= (float)$invoice->getGrandTotal())
        ) {
            return;
        }
		try {
			$invoice->sendEmail ();
		} catch ( Exception $ex ) {
			Mage::logException ( $ex );
		}
	}
}

