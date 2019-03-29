<?php

class Egovs_CreditWorth_Model_Observer extends Varien_Object
{

    /**
     * Check if a payment method is allowed.
     *
     * @param Varien_Event_Observer $observer
     * @return null
     */
    public function paymentMethodIsActive($observer)
    {
        /*
        if (!Mage::helper('egovs_creditworth')->moduleActive()) {
            return;
        }
        //*/
        /**
         * @var Egovs_CreditWorth_Helper_Data $helper
         */
        $helper = Mage::helper('egovs_creditworth');

        /**
         * @var \stdClass $checkResult
         */
        $checkResult = $observer->getResult();
        /**
         *
         * @var Mage_Payment_Model_Method_Abstract $method
         * @var Mage_Sales_Model_Quote $quote
         */
        $method = $observer->getMethodInstance();
        $method_code = $method->getCode();
        $quote = $observer->getQuote();

        if ($checkResult->isAvailable && isset($quote)) {
            $creditworth_type = $method->getConfigData('creditworth_type');

            if (!$creditworth_type) {
                // no credit worth type set for payment method
                // currently ignore this method
                return;
            }
            /**
             * Flag that says if the customer will be deleted
             * @var boolean $delete
             */
            $delete = !!$method->getConfigData('delete_customer_after_transaction');
            /**
             * @var Mage_Core_Model_Store $store
             * @var Mage_Customer_Model_Customer $customer
             */
            $store = $quote->getStore();
            $customer = $quote->getCustomer();

            /**
             * @var Mage_Core_Model_App_Emulation $appEmulation
             */
            if (Mage::app()->getStore()->isAdmin()) {
                $appEmulation = Mage::getSingleton('core/app_emulation');
                $initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($store);
            }

            /**
             * @var int $worthLevel
             */
            $worthLevel = $helper->getWorthLevel($customer, $store, $creditworth_type, $delete);

            // switch case doesn't work nice for this
            if ($method_code === 'bankpayment' || $creditworth_type === 'debit_auth') {
                // Vorkasse und Einzugsermächtigung extra logic
                if ($worthLevel < 4 && $checkResult->isAvailable && $helper->isCustomerBlocked($customer, $delete)) {
                    $checkResult->isAvailable = false;
                }
            } else if ($creditworth_type === 'giro') {
                // 4.2 Überweisung vor Lieferung
                if ($worthLevel < 2 && $checkResult->isAvailable && !$helper->isSumOpenInvoiceValid($quote, $method_code)) {
                    $checkResult->isAvailable = false;
                }
                if ($worthLevel < 3 && $checkResult->isAvailable && !$helper->isSuccessfulThreshold($quote, $method_code)) {
                    $checkResult->isAvailable = false;
                }
                if ($worthLevel < 4 && $checkResult->isAvailable && $helper->isCustomerBlocked($customer, $delete)) {
                    $checkResult->isAvailable = false;
                }
            } else if ($creditworth_type === 'debit') {
                // 4.4 Elektronische Lastschrift
                if ($worthLevel < 2 && $checkResult->isAvailable && $helper->isSumIntervalOverLimit($customer, $store, $method_code)) {
                    $checkResult->isAvailable = false;
                }
                if ($worthLevel < 3 && $checkResult->isAvailable && !$helper->isSuccessfulThreshold($quote, $method_code)) {
                    $checkResult->isAvailable = false;
                }
                if ($worthLevel < 4 && $checkResult->isAvailable && $helper->isCustomerBlocked($customer, $delete)) {
                    $checkResult->isAvailable = false;
                }
            }else if ($creditworth_type === 'creditcard') {
                if ($worthLevel < 2 && $checkResult->isAvailable && $helper->isSumIntervalOverLimit($customer, $store, $method_code)) {
                    $checkResult->isAvailable = false;
                }
                if ($worthLevel < 3 && $checkResult->isAvailable && $helper->isCustomerBlocked($customer, $delete)) {
                    $checkResult->isAvailable = false;
                }
            }

            // Stop store emulation process
            if ($appEmulation) {
                $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
            }
        }
    }
}