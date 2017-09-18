<?php
/**
 * Girosolution Helper Data
 * 
 * Überschreibt hier nur Egovs_Paymentbase_Helper_Data
 *
 * @category   	Gka
 * @package    	Gka_Tkonnektpay
 * @name       	Gka_Tkonnektpay_Helper_Data
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 IT Systeme GmbH - http://www.b3-it.de
 */
class Gka_Tkonnektpay_Helper_Data extends Egovs_Paymentbase_Helper_Data
{
	public function getLanguageCode() {
		$result = 'de';
		$languageCode = Mage::getStoreConfig('general/locale/code', Mage::app()->getStore()->getId());
		if(isset($languageCode)) {
			if(strlen($languageCode) > 2) {
				$languageCode = substr($languageCode, 0, 2);
				$result = strtolower($languageCode);
			}
		}
		return $result;
	}

	public function isAlive($mandantNr = null) {
	    Egovs_Paymentbase_Helper_Tkonnekt_Factory::initTkonnekt();

        $msg = null;
        $iReturnCode = null;

        // Sends request to TKonnekt.
        $request = new TKonnekt_SDK_Request('isAlive');
        $request->addParam('merchantId', $this->getMerchantId());

        $store = Mage::app()->getStore();
        $secure = Mage::getStoreConfigFlag(Mage_Core_Model_Store::XML_PATH_SECURE_IN_FRONTEND);
        $newUrl = $store->getBaseUrl(Mage_Core_Model_Store::URL_TYPE_LINK, $secure).'/tkonnekt/debitcard/isAlive';
        $request->addParam('notifyUrl', $newUrl);

        $request->setSecret($this->getProjectPassword());

        $request->submit();

        if (!$request->requestHasSucceeded()) {
            $iReturnCode = $request->getResponseParam('rc');
            $strResponseMsg = $request->getResponseMessage();
            if (!$strResponseMsg) {
                $strResponseMsg = $this->_getHelper()->__("Unknown server error: %s", $iReturnCode);
            } else {
                $strResponseMsg = $this->_getHelper()->__("$strResponseMsg: %s", $iReturnCode);
            }
            throw new Exception($strResponseMsg);
        }
    }

    /**
     * Get Merchant Id
     *
     * @return string
     */
    public function getMerchantId() {
        $merchantId = Mage::getStoreConfig('payment/gka_tkonnektpay_debitcard/merchant_id');
        $merchantId = Mage::helper('core')->decrypt($merchantId);

        return $merchantId;
    }

    /**
     * Get Project password
     *
     * @return string
     */
    public function getProjectPassword() {
        $projectPassword = Mage::getStoreConfig('payment/gka_tkonnektpay_debitcard/project_pwd');
        $projectPassword = Mage::helper('core')->decrypt($projectPassword);

        return $projectPassword;
    }
}
