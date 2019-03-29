<?php

class Egovs_CreditWorth_Helper_Data extends Mage_Core_Helper_Abstract
{
    /**
     *
     * @param Mage_Customer_Model_Customer $customer
     * @param Mage_Core_Model_Store $store
     * @param string $creditworth_type
     * @param bool $delete
     * @return int
     */
    public function getWorthLevel(Mage_Customer_Model_Customer $customer, Mage_Core_Model_Store $store, $creditworth_type, bool $delete) {

        $epayblId = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);

        // need to get the type of the method which worth type it is
        // depending on that, it needs to use different value from customer
        $worthLevel = $customer->getData('credit_worth_'.strtok($creditworth_type, '_'));

        $useEPayBlCredit = boolval($store->getConfig("payment_services/paymentbase/creditworth_use_epaybl"));

        if ($useEPayBlCredit && !!$epayblId && !$delete) {
            /**
            * @var Egovs_Paymentbase_Helper_Data $payment
            */
            $payment = Mage::helper('paymentbase');
            /**
             * @var Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis $val
             */
            $val = $payment->getCustomerFromEPayment($epayblId, true);

            if ($val instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis) {
                if (!!$val->ergebnis->istOk) {
                    $kunde = $val->kunde;
                    if ($creditworth_type === 'creditcard') {
                        $worthLevel = $kunde->bonitaetsLevelKreditkarte;
                    } else if ($creditworth_type === 'debit' || $creditworth_type === 'debit_auth') {
                        $worthLevel = $kunde->bonitaetsLevelLastschrift;
                    } else if ($creditworth_type === 'giro') {
                        $worthLevel = $kunde->bonitaetsLevelUeberweisung;
                    }
                }
            }
        }
        return $worthLevel;
    }

    /**
     *
     * @param Mage_Customer_Model_Customer $customer
     * @param string $creditworth_type
     * @param bool $delete
     * @return boolean
     */
    public function isCustomerBlocked(Mage_Customer_Model_Customer $customer, bool $delete) {
        $epayblId = $customer->getData(Egovs_Paymentbase_Helper_Data::ATTRIBUTE_EPAYBL_CUSTOMER_ID);
        if ($delete || !$epayblId) {
            return false;
        }
        /**
         * @var Egovs_Paymentbase_Helper_Data $payment
         */
        $payment = Mage::helper('paymentbase');
        /**
         * @var Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis $val
         */
        $val = $payment->getCustomerFromEPayment($epayblId, true);

        if ($val instanceof Egovs_Paymentbase_Model_Webservice_Types_Response_KundenErgebnis) {
            if (!$val->ergebnis->istOk) {
                // Kunde existiert nicht an epaybl, also ist er auch nicht gesperrt
                return false;
            } else {
                $kunde = $val->kunde;
                if (isset($kunde->status)) {
                    return $kunde->status->code !== "AKTIV";
                } else {
                    return false;
                }
            }
        }
        return false;
    }

    /**
     *
     * @param Mage_Sales_Model_Quote $quote
     * @param string $method_code
     * @return boolean
     */
    public function isSumOpenInvoiceValid(Mage_Sales_Model_Quote $quote, $method_code) {
        /**
         * @var Mage_Customer_Model_Customer $customer
         * @var Mage_Core_Model_Store $store
         */
        $customer = $quote->getCustomer();
        $store = $quote->getStore();

        $sum_invoice_threshold = $store->getConfig("payment_services/paymentbase/creditworth_sum_invoice_threshold");
        $sum_invoice_limit = $store->getConfig("payment_services/paymentbase/creditworth_sum_invoice_limit");

        // below threshold is always okay
        if ($quote->getBaseGrandTotal() < floatval($sum_invoice_threshold)) {
            return true;
        }

        $sum = $this->getSumOpenInvoice($customer, $method_code);

        return $sum <= floatval($sum_invoice_limit);
    }

    /**
     * @internal
     * @param Mage_Customer_Model_Customer $customer
     * @param string $method_code
     * @return number
     */
    public function getSumOpenInvoice(Mage_Customer_Model_Customer $customer, $method_code) {
        $customerId = $customer->getId();
        /**
         * @var $collection Mage_Sales_Model_Resource_Order_Invoice_Collection
         */
        $collection = Mage::getModel('sales/order_invoice')->getCollection();

        $collection->join(array('orders' => 'sales/order'), "orders.entity_id = main_table.order_id", 'customer_id')
        ->join(array('payment' => 'sales/order_payment'), "orders.entity_id = payment.parent_id", array("payment_method" => "method"));
        $collection
        ->addAttributeToFilter('orders.customer_id', array('eq' => $customerId))
        ->addAttributeToFilter('payment.method', array('eq' => $method_code))
        ->addAttributeToFilter('main_table.state', array('eq' => Mage_Sales_Model_Order_Invoice::STATE_OPEN))
        ;

        // reset unneeded columns, only sum_total needed
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS);

        $collection->addExpressionFieldToSelect('sum_total', 'SUM({{grand_total}})', ['grand_total' => 'main_table.base_grand_total']);

        $item = $collection->getFirstItem();
        if ($item) {
            return floatval($item->getData('sum_total'));
        }
        return 0;
    }

    /**
     *
     * @param Mage_Customer_Model_Customer $customer
     * @param Mage_Core_Model_Store $store
     * @param string $method_code
     * @return boolean
     */
    public function isSumIntervalOverLimit(Mage_Customer_Model_Customer $customer, Mage_Core_Model_Store $store, $method_code) {
        $sum_interval_weeks = $store->getConfig("payment_services/paymentbase/creditworth_sum_interval_weeks");
        $sum_interval_limit = $store->getConfig("payment_services/paymentbase/creditworth_sum_interval_limit");

        $sum = $this->getSumOrderIterval($customer, $method_code, intval($sum_interval_weeks));

        return $sum > floatval($sum_interval_limit);
    }

    /**
     * @internal
     * @param Mage_Customer_Model_Customer $customer
     * @param string $method_code
     * @param int $weeks
     * @return number
     */
    public function getSumOrderIterval(Mage_Customer_Model_Customer $customer, $method_code, int $weeks) {
        $customerId = $customer->getId();

        /**
         * @var $collection Mage_Sales_Model_Resource_Order_Collection
         */
        $collection = Mage::getModel('sales/order')->getCollection();
        $collection
        ->join(array('payment' => 'sales/order_payment'), "main_table.entity_id = payment.parent_id", array("payment_method" => "method"));

        $collection
        ->addAttributeToFilter('main_table.customer_id', array('eq' => $customerId))
        ->addAttributeToFilter('payment.method', array('eq' => $method_code))
        ->addFieldToFilter('main_table.created_at', array(
            // Varien DB has no constant for weeks, even if mysql supports it
            // use days times 7 instead to get weeks
            'gteq' => $collection->getSelect()->getAdapter()->getDateSubSql('CURDATE()', $weeks * 7, Varien_Db_Adapter_Interface::INTERVAL_DAY)
        ));

        // reset unneeded columns, only sum_total needed
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS);

        $collection->addExpressionFieldToSelect('sum_total', 'SUM({{grand_total}})', ['grand_total' => 'main_table.base_grand_total']);

        $item = $collection->getFirstItem();
        if ($item) {
            return floatval($item->getData('sum_total'));
        }
        return 0;
    }

    /**
     * @internal
     * @param Mage_Customer_Model_Customer $customer
     * @param string $method_code
     * @param int $weeks
     * @return number
     */
    public function getSuccessfulOrders(Mage_Customer_Model_Customer $customer, $method_code, int $weeks) {
        $customerId = $customer->getId();
        /**
         * @var $collection Mage_Sales_Model_Resource_Order_Invoice_Collection
         */
        $collection = Mage::getModel('sales/order_invoice')->getCollection();

        $collection->join(array('orders' => 'sales/order'), "orders.entity_id = main_table.order_id", 'customer_id')
        ->join(array('payment' => 'sales/order_payment'), "orders.entity_id = payment.parent_id", array("payment_method" => "method"));
        $collection
        ->addAttributeToFilter('orders.customer_id', array('eq' => $customerId))
        ->addAttributeToFilter('payment.method', array('eq' => $method_code))
        ->addAttributeToFilter('main_table.state', array('eq' => Mage_Sales_Model_Order_Invoice::STATE_PAID))
        ->addFieldToFilter('main_table.updated_at', array(
            // Varien DB has no constant for weeks, even if mysql supports it
            // use days times 7 instead to get weeks
            'lteq' => $collection->getSelect()->getAdapter()->getDateSubSql('CURDATE()', $weeks * 7, Varien_Db_Adapter_Interface::INTERVAL_DAY)
        ))
        ;

        // reset unneeded columns, only sum_total needed
        $collection->getSelect()->reset(Zend_Db_Select::COLUMNS);

        return $collection->getSize();
    }

    /**
     *
     * @param Mage_Sales_Model_Quote $quote
     * @param string $method_code
     * @return boolean
     */
    public function isSuccessfulThreshold(Mage_Sales_Model_Quote $quote, $method_code) {
        /**
         * @var Mage_Customer_Model_Customer $customer
         * @var Mage_Core_Model_Store $store
         */
        $customer = $quote->getCustomer();
        $store = $quote->getStore();
        $weeks = $store->getConfig("payment_services/paymentbase/creditworth_successful_weeks");
        $threshold = $store->getConfig("payment_services/paymentbase/creditworth_successful_threshold");

        // below threshold is always okay
        if ($quote->getBaseGrandTotal() < floatval($threshold)) {
            return true;
        }
        return $this->getSuccessfulOrders($customer, $method_code, intval($weeks)) > 0;
    }
}