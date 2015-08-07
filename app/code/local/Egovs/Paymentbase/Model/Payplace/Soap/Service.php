<?php
/**
 * File for class PayplaceXmlApiServiceProcess
 * @package PayplaceXmlApi
 * @subpackage Services
 * @date 04.12.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */

/**
 * This class stands for PayplaceXmlApiServiceProcess originally named Process
 * @package PayplaceXmlApi
 * @subpackage Services
 * @date 04.12.2014
 * @author Frank Rochlitzer
 * @version 0.1.0.0
 */
class Egovs_Paymentbase_Model_Payplace_Soap_Service extends Egovs_Paymentbase_Model_Payplace_WsdlClass
{
	/**
	 * Method to call the operation originally named process
	 * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::getSoapClient()
	 * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::setResult()
	 * @uses Egovs_Paymentbase_Model_Payplace_WsdlClass::saveLastError()
	 * @param Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request $_payplaceXmlApiStructXmlApiRequest
	 * 
	 * @return Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Response
	 */
	public function process(Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Request $_payplaceXmlApiStructXmlApiRequest)
	{
		try
		{
			return $this->setResult(self::getSoapClient()->process($_payplaceXmlApiStructXmlApiRequest));
		}
		catch(SoapFault $soapFault)
		{
			return !$this->saveLastError(__METHOD__, $soapFault);
		}
	}
	/**
	 * Returns the result
	 * @see Egovs_Paymentbase_Model_Payplace_WsdlClass::getResult()
	 * @return Egovs_Paymentbase_Model_Payplace_Types_Xml_Api_Response
	 */
	public function getResult()
	{
		return parent::getResult();
	}
	/**
	 * Method returning the class name
	 * @return string __CLASS__
	 */
	public function __toString()
	{
		return __CLASS__;
	}
}