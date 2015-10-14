<?php
class Egovs_Paymentbase_Model_Payplace_Api_Server_V2_Adapter_Soap extends Mage_Api_Model_Server_V2_Adapter_Soap
{
	/**
	 * Transform wsdl url if $_SERVER["PHP_AUTH_USER"] is set
	 *
	 * @param array
	 * @param bool
	 *
	 * @return String
	 */
	protected function getWsdlUrl($params = null, $withAuth = true) {
		return Mage::helper('paymentbase/payplace_data')->getWsdlUrl($params, $withAuth, $this->getController());
	}
	
	/**
     * Try to instantiate Zend_Soap_Server
     * If schema import error is caught, it will retry in 1 second.
     *
     * @throws Zend_Soap_Server_Exception
     */
    protected function _instantiateServer() {
        $apiConfigCharset = Mage::getStoreConfig('api/config/charset');
        $wsdlCacheEnabled = (bool) Mage::getStoreConfig('api/config/wsdl_cache_enabled');

        if ($wsdlCacheEnabled) {
            ini_set('soap.wsdl_cache_enabled', '1');
        } else {
            ini_set('soap.wsdl_cache_enabled', '0');
        }

        $tries = 0;
        do {
            $retry = false;
            try {
            	$options = array('encoding' => $apiConfigCharset, 'classmap' => Egovs_Paymentbase_Model_Payplace_ClassMap::classMap());
                $this->_soap = new Zend_Soap_Server($this->getWsdlUrl(array("wsdl" => 1)), $options);
            } catch (SoapFault $e) {
                if (false !== strpos($e->getMessage(), "can't import schema from 'http://schemas.xmlsoap.org/soap/encoding/'")
                ) {
                    $retry = true;
                    sleep(1);
                } else {
                    throw $e;
                }
                $tries++;
            }
        } while ($retry && $tries < 5);
        use_soap_error_handler(false);
        $this->_soap
            ->setReturnResponse(true)
            ->setClass($this->getHandler())
        ;
    }
	
	/**
	 * Get wsdl config
	 *
	 * @return Mage_Api_Model_Wsdl_Config
	 */
	protected function _getWsdlConfig() {
		$wsdlConfig = Mage::getModel('paymentbase/payplace_api_wsdl_config');
		$wsdlConfig->setHandler($this->getHandler())
			->init();
		return $wsdlConfig;
	}
}