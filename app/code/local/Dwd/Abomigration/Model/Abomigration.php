<?php
/**
 *  Persistenzklasse für Abomigration
 *  @category Dwd
 *  @package  Dwd_Abomigration
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Dwd_Abomigration_Model_Abomigration extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('abomigration/abomigration');
    }
    
    
    public function createCustomerAccounts($limit = 10)
    {
    	$collection = $this->getCollection();
    	$collection->getSelect()
    		->where('create_customer=1')
    		->where('customer_id = 0')
    		->where('error = 0')
    		->limit($limit);
    	    	
    	foreach($collection->getItems() as $item)
    	{
    		$customer = Mage::getModel('customer/customer');
    		$customer->setData('created_in',$item['store_id']);
    		$customer->setData('store_id',$item['store_id']);
    		$customer->setData('website_id',$item['website_id']);
    		$customer->setData('email',$item['email']);
    			
    		$customer->setData('firstname',$item['firstname']);
    		$customer->setData('lastname',$item['lastname']);
    		$customer->setData('company',$item['company1']);
    		//$customer->setData('company2',$item['company2']);
    		$pass = $item['pwd_shop'];
    		$customer->setData('password',$pass);
    		if(strlen($pass) == 0)
    		{
    			$customer->setData('password',Dwd_Abomigration_Model_Abomigration::createPassword(''));
    		}
    				
    		$customer->setPrefix($item['prefix']);
    		
     		
    		
    		
    		$address = $this->getAddress($item);
    		
    		try{
	    		$customer->save();
	    		$address->setCustomerId($customer->getId());
	    		$address->save();
	    		$customer->setDefaultShipping($address->getId());
	    		$customer->setDefaultBilling($address->getId());
	    		$customer->setBaseAddress($address->getId());
	    		$customer->setConfirmation(null);
	    		$customer->save();
				$item
					->setCustomerId($customer->getId())
					->setAddressId($address->getId())
					->save();
	    		}
    		catch(Exception $ex)
	    		{
	    			$item->setError(1)
	    				->setErrorText($ex->getMessage())
	    				->save();
	    		}
    		
    		}
    }
    
    
    public function createCustomerAddresses($limit = 50)
    {
    	$collection = $this->getCollection();
    	$collection->getSelect()
    	->where('customer_id > 0')
    	->where('address_id = 0')
    	->where('error = 0')
    	->limit($limit);
    
    	foreach($collection->getItems() as $item)
    	{
    		try {
	    		$adr = $this->getAddress($item);
	    		
	    		$adr->setCustomerId($item->getCustomerId())->save();
	    		$item->setAddressId($adr->getId())->save();
    		}
    		catch(Exception $ex)
    		{
    			$item->setError(1)
    			->setErrorText($ex->getMessage())
    			->save();
    		}
    	}
    }
    
    
    protected function getAddress($item)
    {
    	$address = Mage::getModel('customer/address');
    		
    	$address->setData('company',$item['company1']);
    	$address->setData('company2',$item['company2']);
    	$address->setData('country_id',$item['country']);
    	$address->setPrefix($item['prefix']);
    	$address->setData('firstname',$item['firstname']);
    	$address->setData('lastname',$item['lastname']);
    	$address->setData('postcode',$item['postcode']);
    	$address->setData('street',$item['street']);
    	$address->setData('city',$item['city']);
    	$address->setData('telephone',$item['telephone']);
    	$address->setData('email',$item['email']);
    	return $address;
    }
    
    
    
    /**
     * testen der Passwörter auf Kompextiät
     * @see Mage_Core_Model_Abstract::_beforeSave()
     */
    protected function _beforeSave()
    {
    	
    	$var = $this->checkPassword($this->getData('email'),$this->getData('pwd_shop'));
    	$this->setData('pwd_shop_is_safe',$var);
    	
    	$var = $this->checkPassword($this->getData('username_ldap'),$this->getData('pwd_ldap'));
    	$this->setData('pwd_ldap_is_safe',$var);
    	
    	return parent::_beforeSave();
    }
    
    protected static function getRandomString($len, $chars=null)
    {
    	if (is_null($chars)) {
    		$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    	}
    	mt_srand(10000000*(double)microtime());
    	for ($i = 0, $str = '', $lc = strlen($chars)-1; $i < $len; $i++) {
    		$str .= $chars[mt_rand(0, $lc)];
    	}
    	return $str;
    }
    
    /**
     * Sicheres Passwort erzeugen
     * @param string $username
     * @return string
     */
    public static function createPassword($username)
    {
    	$res = array();
    	$res[] = self::getRandomString(2);
    	$res[] = self::getRandomString(2,"ABCDEFGHIJKLMNOPQRSTUVWXYZ");
    	$res[] = self::getRandomString(2,"abcdefghijklmnopqrstuvwxyz");
    	$res[] = self::getRandomString(2);
    	$res[] = self::getRandomString(2,"0123456789");
    	
    	$keys = array_rand($res,5);
    	$sum = "";
    	foreach($keys as $k)
    	{
    		$sum .= $res[$k];	
    	}
    	
    	return  substr($sum, 0,9);
    }
    
    
    /**
     * Checks for valid passwords.
     *
     * @param string $sUsername username
     * @param string $sPassword the password
     *
     * @return boolean True if the password is valid, and false otherwise.
     */
    public function checkPassword($sUsername = null, $sPassword = null)
    {
    	if (is_null($sPassword) || (strlen($sPassword) < 8) ) {
    		return false;
    	}
    
    	$sLowerUser = strtolower($sUsername);
    	$sLowerPass = strtolower($sPassword);
    
    	$sUserSix = substr($sLowerUser, 0, 6);
    	$sUserTwo = substr($sLowerUser, 0, 2);
    
    	if (strpos($sLowerPass, $sLowerUser)) {
    		return false;
    	}
    
    	if ((strlen($sLowerUser) >= 6) AND strpos($sLowerUser, $sUserSix)) {
    		return false;
    	}
    	if ( (strlen($sLowerUser) > 4) AND strpos($sLowerUser, $sUserTwo) ) {
    		return false;
    	}
    
    	$iCat = 0;
    
    	if ( preg_match("/.*[A-Z].*/", $sPassword) ) {
    		$iCat++;
    	}
    	if ( preg_match("/.*[a-z].*/", $sPassword) ) {
    		$iCat++;
    	}
    	if ( preg_match("/.*\\d.*/", $sPassword) ) {
    		$iCat++;
    	}
    	if ( preg_match("/.*\\W.*/", $sPassword) ) {
    		$iCat++;
    	}
    
    	if ( $iCat < 3 ) {
    		return false;
    	}
    	 
    	return true;
    }
    
}