<?php

class Egovs_Zahlpartnerkonten_Helper_Data extends Egovs_Paymentbase_Helper_Data
{
	const ATTRIBUTE_USE_ZPKONTO = 'use_zpkonto';
	
	/**
	 * Prüft ob der Kunde ZP-Konten nutzt
	 *
	 * @param Mage_Customer_Model_Customer|int $customer Kunden-Objekt oder ID
	 * 
	 * @return bool
	 */
	public function isUseZpkonto($customer) {
		if (!$customer) {
			Mage::throwException($this->__("Can't check for ZPK, no customer object or ID given!"));
		}
		if (is_numeric($customer)) {
			$customer = Mage::getModel('customer/customer')->load($customer);
		}
		if ($customer->hasUseZpkonto()) {
			return (bool) $customer->getUseZpkonto();
		}
	
		//Gilt für Gäste
		if ($customer->isEmpty()) {
			return false;
		}
	
		$attrUseZpkonto = $customer->getAttribute(Egovs_Zahlpartnerkonten_Helper_Data::ATTRIBUTE_USE_ZPKONTO);
		$customer->setUseZpkonto((bool) $attrUseZpkonto->getDefaultValue());
		return (bool) $customer->getUseZpkonto();
	}
	
	/**
	 * Prüft ob die aktuelle Zahlmethode für das Kassenzeichen verwendet werden darf
	 * 
	 * @param Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis $kassenzeichenInfo  Kassenzeicheninfoergbnis aus ePayBL
	 * @param Egovs_Zahlpartnerkonten_Model_Pool										  $kassenzeichenModel Kassenzeichen aus Pool
	 * @param Mage_Payment_Model_Method_Abstract	          							  $payment			  Zahlmodul
	 * 
	 * @return Egovs_Zahlpartnerkonten_Helper_Data
	 */
	public function validateSaldoWithLastPaymentMethode($kassenzeichenInfo, $kassenzeichenModel, $payment) {
		/* @var $collection Mage_Sales_Model_Resource_Order_Payment_Collection */
		$collection = Mage::getResourceModel('sales/order_payment_collection');
		$collection->addFieldToSelect(array(
				'parent_id',
				'method',
				'kassenzeichen',
			)
		);
		$collection->join(
				array('orders' => 'sales/order'),
				'parent_id = orders.entity_id',
				array('state' => 'state', 'customer_id' => 'customer_id', 'store_id')
		);
		//Das aktuelle Payment und die Order sind hier noch nicht in der DB gespeichert!
		$collection->addFieldToFilter('customer_id', $kassenzeichenModel->getCustomerId());
		$collection->addFieldToFilter('state', array('neq' => Mage_Sales_Model_Order::STATE_CANCELED));
		$collection->addFieldToFilter('state', array('neq' => Mage_Sales_Model_Order::STATE_CLOSED));
		$collection->addFieldToFilter('kassenzeichen', array('in' => array($kassenzeichenModel->getKassenzeichen())));
		$collection->setOrder('parent_id', Mage_Sales_Model_Resource_Order_Payment_Collection::SORT_ORDER_DESC);
		$collection->getSelect()->limit(1);
		$item = $collection->getFirstItem();
		Mage::log(sprintf("zpk::sql:Last payment method:\n%s", $collection->getSelect()->assemble()), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
		if ($item && !$item->isEmpty() && $kassenzeichenModel->getLastPayment() != $item->getMethod()) {
			$kassenzeichenModel->setLastPayment($item->getMethod());
			$kassenzeichenModel->save();
		}
    	//der Account muss ausgeglichen sein oder das selbe Zahlverfahren haben
		if (isset($kassenzeichenInfo->saldo) && ($kassenzeichenInfo->saldo > 0) && ($kassenzeichenModel->getLastPayment() != $payment->getCode())) {
			$message = Mage::helper('zpkonten')->__('Your Account is not balanced! You can currently only use %s for payments!', $this->getTitle($kassenzeichenModel->getLastPayment(), $payment->getStore()));
			Mage::throwException($message);
		}
		return $this;
    }
    
    /**
     * Prüft ob das Kassenzeichen an der ePayBL existiert hat.
     * 
     * @param Egovs_Paymentbase_Model_Webservice_Types_Response_KassenzeichenInfoErgebnis $kassenzeichenInfo Kassenzeicheninfoergbnis aus ePayBL
     * 
     * @return boolean
     */
    public function kassenzeichenExists($kassenzeichenInfo) {
    	if ($kassenzeichenInfo && isset($kassenzeichenInfo->ergebnis) && $kassenzeichenInfo->ergebnis->getCode()) {
    		$code = $kassenzeichenInfo->ergebnis->getCodeAsInt();
    		if ($code == 0) {
    			return true;
    		}    		
    	}
    	
    	return false;
    }
    
    /**
     * Liefert Titel der Zahlmethode
     *
     * @param string $code    Modulecode
     * @param mixed  $storeId Store
     * 
     * @return string
     */
    public function getTitle($code, $storeId = null) {
    	if (null === $storeId) {
    		$storeId = Mage::app()->getStore();
    	}
    	$path = 'payment/'.$code.'/title';
    	return Mage::getStoreConfig($path, $storeId);
    }
}