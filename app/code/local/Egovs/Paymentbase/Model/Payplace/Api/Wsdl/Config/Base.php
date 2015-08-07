<?php
class Egovs_Paymentbase_Model_Payplace_Api_Wsdl_Config_Base extends Mage_Api_Model_Wsdl_Config_Base
{
	public function __construct($sourceData=null)
	{
		$this->_elementClass = 'Egovs_Paymentbase_Model_Payplace_Api_Wsdl_Config_Element';
		Varien_Simplexml_Config::__construct($sourceData);
	}
}