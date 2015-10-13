<?php
class Egovs_Paymentbase_Model_Payplace_Api_Server_Wsi_Handler extends Mage_Api_Model_Server_Wsi_Handler
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
		/** @var Mage_Api_Helper_Data */
		$helper = Mage::helper('api/data');
	
		$helper->wsiArrayUnpacker($args);
		
		
		
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
	
		list($modelName, $methodName) = $this->_getResourceName($apiKey);
		$methodParams = $this->getMethodParams($modelName, $methodName);
	
		$args = $this->prepareArgs($methodParams, $args);
	
		$res = $this->call($sessionId, $apiKey, $args);
	
		$obj = $helper->wsiArrayPacker($res);
	
		return $obj;
	}
	
	/**
	 * Prepares arguments for the method calling. Sort in correct order, set default values for omitted parameters.
	 *
	 * @param Array $params
	 * @param Array $args
	 * @return Array
	 */
	public function prepareArgs($params, $args) {
	
		$callArgs = array();
	
		/* @var $parameter ReflectionParameter */
		foreach ($params AS $parameter) {
			$pName = $parameter->getName();
			if (is_object($args)) {
				$_class = $parameter->getClass();
				if (!_class) {
					continue;
				}
				$_class = $_class->getName();
				if (!($args instanceof $_class)) {
					continue;
				}
				$callArgs[$pName] = $args;
				break;
			}
			
			if( isset( $args[$pName] ) ){
				$callArgs[$pName] = $args[$pName];
			} else {				
				if($parameter->isOptional()){
					$callArgs[$pName] = $parameter->getDefaultValue();
				} else {
					Mage::logException(new Exception("Required parameter \"$pName\" is missing.", 0, null));
					$this->_fault('invalid_request_param');
				}
			}
		}
		return $callArgs;
	}
}