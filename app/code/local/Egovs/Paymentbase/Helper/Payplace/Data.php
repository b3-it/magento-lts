<?php
/**
 * Basishelperklasse für gemeinsam genutzte Methoden für Payplace.
 *
 *
 * @category	Egovs
 * @package		Egovs_Paymentbase
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright	Copyright (c) 2015 B3-IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Paymentbase_Helper_Payplace_Data extends Mage_Core_Helper_Abstract
{
	/**
	 * Transform wsdl url if $_SERVER["PHP_AUTH_USER"] is set
	 *
	 * @param array
	 * @param bool
	 * @param object 
	 * 
	 * @return String
	 */
	public function getWsdlUrl($params = null, $withAuth = true, $controller) {
		$wsdlUrl = ($params !== null)
				? Mage::helper('api')->getServiceUrl('*/*/*', array('_current' => true, '_query' => $params))
				: Mage::helper('api')->getServiceUrl('*/*/*')
		;
		$_parsedUrl = parse_url($wsdlUrl);
		
		if( $withAuth ) {
			$phpAuthUser = $controller->getRequest()->getServer('PHP_AUTH_USER', false);
			$phpAuthPw = $controller->getRequest()->getServer('PHP_AUTH_PW', false);
	
			if ($phpAuthUser && $phpAuthPw) {
				if (!$_parsedUrl) {
					throw new Exception(sprintf("URL '%s' is malformed", $wsdlUrl));
				}
				if (!isset($_parsedUrl['scheme'])) {
					throw new Exception(sprintf("Can't parse URL scheme from URL '%s'", $wsdlUrl));
				}
				$schema = $_parsedUrl["scheme"];
				$wsdlUrl = sprintf("%s://%s:%s@%s", $schema, $phpAuthUser, $phpAuthPw, str_replace("$schema://", '', $wsdlUrl ) );
			}
		}
	
		return $wsdlUrl;
	}
}