<?php
/**
 * 
 *  Schnittstelle zum BGK System Zugriffsdienst
 *  @category Egovs
 *  @package  Bkg_VirtualAccess_Model_Service_Account
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_VirtualAccess_Model_Service_Account extends Varien_Object
{
	protected $_client = NULL;
		
	/**
	 *  Erzeugen eines Accounts
	 * @param Bkg_VirtualAccess_Model_Purchased $purchased
	 * @return number
	 */
	public function create(Bkg_VirtualAccess_Model_Purchased $purchased)
	{
		
		$xmldoc = new DOMDocument('1.0', 'utf-8');
		$xml = new Bkg_VirtualAccess_Model_Service_Webservice_Freischaltung();
		
		$xml->getAuftrag()->setValue($purchased->getOrderIncrementId());
		$xml->getService()->setValue($purchased->getProductCode());
		$xml->getPerson()->getVorname()->setValue($purchased->getOrder()->getCustomerFirstname());
		$xml->getPerson()->getName()->setValue($purchased->getOrder()->getCustomerLastname());
		$xml->getPerson()->getEmail()->setValue($purchased->getOrder()->getCustomerEmail());		
		
		$xml->toXml($xmldoc);
		$xmldoc->preservWhiteSpace = true;
		$xmldoc->formatOutput = true;
		echo('<pre>');
		die (htmlentities($xmldoc->saveXML()));
		
		
		return time();
	}
	
	/**
	 * Auslesen der Zugangsparameter
	 * @param int|string $accountId
	 * @return Varien_Object[]
	 */
	public function getCredentials($accountId)
	{
		$res = array();
		$res[] = new Varien_Object(array('uuid'=>'1234'));
		$res[] = new Varien_Object(array('uuid'=>'12345'));
		$res[] = new Varien_Object(array('uuid'=>'123456'));
		
		return $res;
	}
	
	/**
	 * Neuer Account auf Basis eines Besetehenden erstellen
	 * @param int|string $accountId alte Kennung
	 * @return string neue Kennung
	 */
	public function renew($accountId)
	{
		return $accountId ."_1";
	}
	
	
	/**
	 * Verbrauch ermitteln
	 * @param int|string $accountId Kennung
	 * @return Varien_Object Verbrauchsdaten
	 */
	public function getConsumtion($accountId)
	{
		return new Varien_Object(array('test'=>'1234'));
	}
	
	/**
	 * Status ändern
	 * @param int|string $accountId Kennung
	 * @return Varien_Object Verbrauchsdaten
	 */
	public function changeState($accountId)
	{
		return new Varien_Object(array('test'=>'1234'));
	}
	
	
	protected function _getClient()
	{
		if($this->_client == null){
			$this->_client = Mage::getModel('virtualaccess/service_webservice_client');
		}
		
		return $this->_client;
	}
	
}