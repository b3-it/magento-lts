<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_Model_Relation
 * @author 		Holger K�gel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Observer_Abstract extends Varien_Object
{
    
	/**
	 * Falls Produkte aus einer Bestellung geladen werden sollen
	 * @var string
	 */
	protected static $_AllowProductLod4View = false;
	
	private $_user = null;
	
	protected function getUser()
	{
		if($this->_user == null)
		{
			if(Mage::getSingleton('admin/session')->getUser()){
				$this->_user =  Mage::getSingleton('admin/session')->getUser();
				return $this->_user;
			}
			
			$this->_user = $this->getApiUser();
			
		}
		return $this->_user;
	}
	
	protected function getApiUser()
	{
		$headerString = Mage::app()->getRequest()->getHeader('Authorization');
		
		
		$tokenPosition = strpos($headerString, 'oauth_token=');
		$token = null;
		if($tokenPosition !== false){
			$token = substr($headerString, $tokenPosition+13, 32);
		}
		
		if($token == null){
			$error = 'Authorization Token Not found.';
			throw new Exception($error);
			return null;
		}
		
		$oauth =  Mage::getModel('oauth/token')->load($token,'token');
		if($oauth){
			return Mage::getModel('admin/user')->load($oauth->getAdminId());
		}
		
		return null;
		
	}

    /**
     * Sollen die Bestellungen auch nach dem Kundenstore gefiltert werden
     * @return bool
     */
	protected function _showOrderWithinCustomerStore()
    {

        return Mage::getConfig('storeisolation/filter/show_order_within_customer_store');
    }

    /**
     * alle zum aktuellen Benutzer gehörenden Stores
     * @return array
     */
    protected function getUserStoreGroups()
	{
        if( Mage::getSingleton('adminhtml/session')->getUser() ) {
            return array();
        }
        else {
            $user = $this->getUser();
            return $user->getStoreGroups();
        }
	}
	
	/**
	 * Aller erlaubten StoreViews des Nutzers festellen
	 * @return NULL[]
	 */
	protected function getUserStoreViews()
	{
		$res = array();
		$user = $this->getUser();
		$storeGroups = $user->getStoreGroups();
		
		if(($storeGroups) && (count($storeGroups) > 0)) 
		{	
			$storeGroups = implode(',', $storeGroups);
			$collection = Mage::getModel('core/store')->getCollection();
			$collection->getSelect()->where('group_id In ('.$storeGroups.')');
			
			
			foreach($collection->getItems() as $item )
			{
				$res[] = $item->getId();
			}
		}
		return $res;
	}


	protected function _getOrderIdsDbExpr()
    {
        return Mage::helper('isolation')->getOrderIdsDbExpr();
    }

	protected function getUserStoreRootCategories()
	{
		$res = array();
		$user = $this->getUser();
		$storeGroups = $user->getStoreGroups();
		if(($storeGroups) && (count($storeGroups) > 0)) 
		{	
			$storeGroups = implode(',', $storeGroups);
			$collection = Mage::getModel('core/store_group')->getCollection();
			$collection->getSelect()->where('group_id In ('.$storeGroups.')');
			
			
			foreach($collection->getItems() as $item )
			{
				$res[] = $item->getRootCategoryId();
			}
		}
		return $res;
	}
	
	
	protected function getUsername($id)
	{
		$user = Mage::getModel('admin/user')->load($id);
		return $user->getFirstname()." " . $user->getLastname();
	}
	
	
	protected function getRelatedOrderItems4Order($orderId)
	{
		$storeGroups = $this->getUserStoreGroups();
    	
    	if(($storeGroups) && (count($storeGroups) > 0)) 
    	{
    		$storeGroups = implode(',', $storeGroups);
    		$count = Mage::getModel('isolation/relation')->getResource()->getCountOrderItems4Stores($storeGroups, $orderId);
    		return $count;
    	}
    	
    	return -1;
	}
	
	/**
	 * Falls der Nutzer die URL manipuliert hat loggen und abbrechen 
	 */
	protected function denied()
	{
		$req = Mage::app()->getRequest()->getRequestString();
		$ip = Mage::app()->getRequest()->getClientIp();
		$obj = get_class($this);
		Mage::log("Access denied for User: ". $this->getUser()->getName(). " Request: " . $req . " IP:" .$ip . " /". $obj);
		die('<h1>Access denied! Your Data has been logged!</h1>');
	}
	

    
}