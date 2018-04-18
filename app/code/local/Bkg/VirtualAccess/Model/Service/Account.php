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
	
	/**
	 * Erzeugen eines Accounts
	 * @param unknown $data user,produkt,lizenz..
	 * @return accountID
	 */
	public function create($data)
	{
		return time();
	}
	
	/**
	 * Auslesen der Zugangsparameter
	 * @param unknown $accountId
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
	 * @param unknown $accountId alte Kennung
	 * @return accountID neue Kennung
	 */
	public function renew($accountId)
	{
		return $accountId ."_1";
	}
	
	
	/**
	 * Verbrauch ermitteln
	 * @param unknown $accountId Kennung
	 * @return Varien_Object Verbrauchsdaten
	 */
	public function getConsumtion($accountId)
	{
		return new Varien_Object(array('test'=>'1234'));
	}
	
	/**
	 * Status ändern
	 * @param unknown $accountId Kennung
	 * @return Varien_Object Verbrauchsdaten
	 */
	public function changeState($accountId)
	{
		return new Varien_Object(array('test'=>'1234'));
	}
	
	

}