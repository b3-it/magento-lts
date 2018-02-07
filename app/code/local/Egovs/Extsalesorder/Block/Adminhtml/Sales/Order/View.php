<?php
/**
 * Adminhtml Sales Order View
 *
 * @category    Egovs
 * @package     Egovs_Extsalesorder
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2010 - 2018 B3 IT Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extsalesorder_Block_Adminhtml_Sales_Order_View extends Mage_Adminhtml_Block_Sales_Order_View
{
	/**
	 * Liefert einen Button oder null
	 * 
	 * @param string $id ID für Button
	 * 
	 * @return array|null
	 */
	protected function _getButton($id) {
		foreach ($this->_buttons as $level => $buttons) {
			if (isset($buttons[$id])) {
				 return $buttons[$id];
			}
		}
		
		return null;
	}
	/**
	 * Konstruktor
	 * 
	 * @return void
	 */
    public function __construct() {
    	parent::__construct();
    	
    	if ($this->_hasShipments()) {
    		$this->_removeButton('order_edit');
    	}
    	
    	$button = $this->_getButton('order_creditmemo');
    	$sortOrder = 0;
    	if (isset($button['sort_order'])) {
    		$sortOrder = $button['sort_order'];
    	}
    	$this->_removeButton('order_creditmemo');
        $coreHelper = Mage::helper('core');

    	if ($this->_isAllowedAction('creditmemo')
    		&& $this->getOrder()->canCreditmemo()
    		&& $this->getOrder()->getShipmentsCollection()->getSize() < 1
        ) {
    	    $message = $coreHelper->jsQuoteEscape(
    	        Mage::helper('sales')->__('This will create an offline refund. To create an online refund, open an invoice and create credit memo for it. Do you wish to proceed?')
    	    );
    		$onClick = "setLocation('{$this->getCreditmemoUrl()}')";
    		//Siehe dazu auch #1626 bzw. ZVM848
    		$paymentMethodInstance = $this->getOrder()->getPayment()->getMethodInstance();
    		if ($paymentMethodInstance->isGateway() && !$paymentMethodInstance->getSupportsOnlyOfflineCreditmemo()) {
    			$onClick = "confirmSetLocation('{$message}', '{$this->getCreditmemoUrl()}')";
    		}
    		$this->_addButton('order_creditmemo', array(
	    				'label'     => Mage::helper('sales')->__('Credit Memo'),
	    				'onclick'   => $onClick,
	    				'class'     => 'go'
	    				),
    				0,
    				$sortOrder
    		);
        }
    	
        $invoiceCanCancel = false;
    	$invoices = $this->getOrder()->getInvoiceCollection();
    	$paymentInstance = $this->getOrder()->getPayment()->getMethodInstance();
		//Mage_Sales_Model_Mysql4_Order_Invoice_Collection
		foreach ($invoices as $invoice) {
			if (($paymentInstance instanceof Egovs_Openaccountpayment_Model_Openaccount || $paymentInstance instanceof Egovs_BankPayment_Model_Bankpayment)
				&& $invoice instanceof Mage_Sales_Model_Order_Invoice
				&& $invoice->getState() == Mage_Sales_Model_Order_Invoice::STATE_OPEN
			) {
				//Damit Betellungen die nicht bezahlt sind aber eine Sendung gemacht wurde
				//storniert werden können (Bezahlung af Rechnung)
				$invoiceCanCancel = false;
				break;
			}
			/* @var $invoice Mage_Sales_Model_Order_Invoice */ 
			if ($invoice->canCancel()) {
				$invoiceCanCancel = true;
				break;
			}
			
        }
        /*
         * Sichtbar bei:
         * Kostenlosen Bestellungen
         * Bestellungen mit Auslieferungen
         */
        $invoiced = $this->getOrder()->getBaseTotalInvoiced();
        $baseGrandTotal = $this->getOrder()->getBaseGrandTotal();
        if ($this->_isAllowedAction('creditmemo')
    		&& !array_key_exists('order_creditmemo', $this->_buttons[0]) //darf nicht mit Mage-CreditMemo-Button auftauchen
    		&& !$invoiceCanCancel
    		&& $this->getOrder()->getState() != Mage_Sales_Model_Order::STATE_CLOSED
    		&& $this->getOrder()->getState() != Mage_Sales_Model_Order::STATE_CANCELED
        	&& ($this->_hasShipments() || ($baseGrandTotal == 0.0 && $invoiced == $baseGrandTotal))
    	) {
        	$button = $this->_getButton('order_cancel');
        	$sortOrder = 0;
        	if (isset($button['sort_order'])) {
        		$sortOrder = $button['sort_order'];
        	}        		
        	//Storno darf nicht mit Rückläufer auftauchen
        	$this->_removeButton('order_cancel');
            $this->_addButton('order_creditmemo', array(
		                'label'     => Mage::helper('extsalesorder')->__('Return'),
		                'onclick'   => 'setLocation(\'' . $this->getSpecialCreditmemoUrl() . '\')',
            			'class'     => 'go'
		            ),
            		0,
            		$sortOrder
            );
        }
    }
    
    /**
     * Prüft ob die Order schon Sendungen besitzt
     * 
     * @return bool
     */
    protected function _hasShipments() {
    	if (!$this->getOrder()->hasShipments()) {
    		return false;
    	}
    	
    	//Falls es Shipments gibt, könnten diese Zurückbeordert worden sein
    	$qtyShipped = 0;
    	foreach ($this->getOrder()->getAllItems() as $item) {
    		/* @var $item Mage_Sales_Model_Order_Item */
    		$qtyShipped += $item->getQtyShipped();
    	}
    	
    	return $qtyShipped > 0 ? true : false;
    }
    
    /**
     * Liefert Gutschrift URL
     * 
     * @return string
     */
    public function getSpecialCreditmemoUrl() {
    	return $this->getUrl('adminhtml/extsalesorder_creditmemo/start', array('_current'=>true));
    }
}