<?php
class Egovs_Paymentbase_Model_Payplace_Api_Server_V2_Handler extends Mage_Api_Model_Server_V2_Handler
{
	/**
	 * Interceptor for all interfaces
	 *
	 * @param string $function
	 * @param array $args
	 * 
	 */	
	public function __call ($function, $args)
	{
		$args = $args[0];
	
		if (!($args instanceof Egovs_Paymentbase_Model_Payplace_Types_Callback_Request)) {
			$this->_fault('invalid_request_param');
		}
		
		
		$auth = Mage::getModel('paymentbase/payplace_api_server_wsi_adapter_auth');
		$auth = $auth->getRequestUser();
		
		$sessionId = Mage_Api_Model_Server_Handler_Abstract::login($auth[0],$auth[1]);
		
		$apiKey = '';
		$nodes = Mage::getSingleton('api/config')->getNode('v2/resources_function_prefix')->children();
		foreach ($nodes as $resource => $prefix) {
			$prefix = $prefix->asArray();
			if (false !== strpos($function, $prefix)) {
				$method = substr($function, strlen($prefix));
				$apiKey = $resource . '.' . strtolower($method[0]).substr($method, 1);
			}
		}
	
		return $this->call($sessionId, $apiKey, $args);
	}
}