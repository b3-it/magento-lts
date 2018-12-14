<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Newsletter
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Subscriber model
 *
 * @category   Mage
 * @package    Mage_Newsletter
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Extnewsletter_Model_Mage_Subscriber extends Mage_Newsletter_Model_Subscriber
{
	static private $ConfirmationRequestEmailIsSended = false;
    public function unsubscribe()
    {
        if ($this->hasCheckCode() && $this->getCode() != $this->getCheckCode()) {
            Mage::throwException(Mage::helper('newsletter')->__('Invalid subscription confirmation code'));
        }

        $this->setSubscriberStatus(self::STATUS_UNSUBSCRIBED)
            ->save();
        Mage::getResourceModel('extnewsletter/extnewsletter')->resetProductsBySubscriberId($this->getId());
        $this->sendUnsubscriptionEmail();
        return $this;
    }
    
    public function subscribe($email)
    {
    	$res = $this->_subscribe($email);
		$this->makeGeneralAccount();
		return $res;
    }

    private function makeGeneralAccount()
    {
    	//um einen allgemeinen Newsletter zu erhalten muss das Produkt 0 aboniert sein
    	
    	$extnews = Mage::getModel('extnewsletter/extnewsletter');
		$extnews->loadByIdAndProduct($this->getId(),0);
		if(!$extnews->getId())
		{
			$extnews->setData('subscriber_id',$this->getId());
			$extnews->setData('product_id',0);
			
		}
		$extnews->setData('is_active','1');
		$extnews->save();

    }
    
    protected function _subscribe($email)
    {
       
        $customer = Mage::getModel('customer/customer')
           ->setWebsiteId(Mage::app()->getStore()->getWebsiteId())
           ->loadByEmail($email);
        
        if($customer->getId())
        {
        	$this->loadByCustomer($customer);
	        //falls der Nutzer sich vorher als Gast eingeschrieben hatte
	        if(!$this->getId())
	        {
	        	$this->loadByEmail($customer->getEmail());
	        	//falls gefunden
	        	if($this->getId())
	        	{
	        		$this->setCustomerId($customer->getId());
	        	}
	        }
        }
        else 
        {
        	 $this->loadByEmail($email);
        }
           
        $this->isNewSubscriber = false;

		//die($this->getStatus());        
        if (($this->getId()>0) && ($this->getStatus()== self::STATUS_SUBSCRIBED)){
        	return self::STATUS_SUBSCRIBED;
        }
        
        
        
        $customerSession = Mage::getSingleton('customer/session');

        if(!$this->getId()) {
            $this->setSubscriberConfirmCode($this->randomSequence());
        }


        if (!$this->getId() || $this->getStatus()==self::STATUS_UNSUBSCRIBED || $this->getStatus()==self::STATUS_NOT_ACTIVE) {
        	
            if (Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_FLAG) == 1) {
                $this->setStatus(self::STATUS_NOT_ACTIVE);
            } else {
                $this->setStatus(self::STATUS_SUBSCRIBED);
            }
            
            $this->setSubscriberEmail($email);
        }

        if ($customerSession->isLoggedIn()) {
            $this->setStoreId($customerSession->getCustomer()->getStoreId());
            //$this->setStatus(self::STATUS_NOT_ACTIVE);
            $this->setCustomerId($customerSession->getCustomerId());
        } else if ($customer->getId()) {
            $this->setStoreId($customer->getStoreId());
            //$this->setSubscriberStatus($this->getStatus());
            $this->setCustomerId($customer->getId());
        } else {
            $this->setStoreId(Mage::app()->getStore()->getId());
            $this->setCustomerId(0);
            $this->isNewSubscriber = true;
        }

        $this->setIsStatusChanged(true);

        try {
            $this->save();
                      
            if (Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_FLAG) == 1
               && $this->getSubscriberStatus()!=self::STATUS_SUBSCRIBED) {
                   $this->sendConfirmationRequestEmail();
            } else {
            	if(!Mage::getStoreConfig('newsletter/subscription/suppress_welcome'))
            	{
                	$this->sendConfirmationSuccessEmail();
            	}
            }
			
           
            
            return $this->getStatus();
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    
   /**
     * Load subscriber info by customer
     *
     * @param Mage_Customer_Model_Customer $customer
     * @return Mage_Newsletter_Model_Subscriber
     */
    public function loadByCustomer(Mage_Customer_Model_Customer $customer)
    {
        $data = $this->getResource()->loadByCustomer($customer);
        
        //Achtung Fallback im Core falls kein sUBSCRIBER VIA customer id gefunden wurde
        //nachladen per Email; problematisch da email->kundenzuordnung nicht eindeutig wg. WebsiteId
        if((isset($data['customer_id'])) &&($data['customer_id'] != $customer->getId()))
        {
        	$data = array();
        }
        
        $this->addData($data);
        if (!empty($data) && $customer->getId() && !$this->getCustomerId()) {
            $this->setCustomerId($customer->getId());
            $this->setSubscriberConfirmCode($this->randomSequence());
            /*
            if ($this->getStatus()==self::STATUS_NOT_ACTIVE) {
                $this->setStatus($customer->getIsSubscribed() ? self::STATUS_SUBSCRIBED : self::STATUS_UNSUBSCRIBED);
            }
            */
            $this->save();
        }
        return $this;
    }
    
    public function subscribeCustomer($customer)
    {
    	//return $this;
        $this->loadByCustomer($customer);

        //falls der Nutzer sich vorher als Gast eingeschrieben hatte
        if(!$this->getId())
        {
        	$this->loadByEmail($customer->getEmail());
        	//falls gefunden
        	if($this->getId())
        	{
        		$this->setCustomerId($customer->getId());
        	}
        }
        
        
        if ($customer->getImportMode()) {
            $this->setImportMode(true);
        }

        if (!$customer->getIsSubscribed() && !$this->getId()) {
            // If subscription flag not seted or customer not subscriber
            // and no subscribe bellow
            return $this;
        }

        if(!$this->getId()) {
            $this->setSubscriberConfirmCode($this->randomSequence());
        }

        /*
        if($customer->hasIsSubscribed()) {
            $status = $customer->getIsSubscribed() ? self::STATUS_SUBSCRIBED : self::STATUS_UNSUBSCRIBED;
        } else {
            $status = $this->getStatus();// ($this->getStatus() == self::STATUS_NOT_ACTIVE ? self::STATUS_UNSUBSCRIBED : $this->getStatus());
        }
		
		*/
		
        
        if($customer->hasIsSubscribed() && ($this->getStatus() != self::STATUS_SUBSCRIBED)) 
        {
     		if (Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_FLAG) == 1) {
                $status = self::STATUS_NOT_ACTIVE;
            } else {
                $status = self::STATUS_SUBSCRIBED;
            }
            
        }
        elseif($this->getId())
        {
        	if($customer->getIsSubscribed()=== false)
        		$status = self::STATUS_UNSUBSCRIBED;
        	else
        		$status = $this->getStatus();
        }
        
        
        
        
        
        

        if($status != $this->getStatus()) {
            $this->setIsStatusChanged(true);
        }

        $this->setStatus($status);



        if(!$this->getId()) {
            $this->setStoreId($customer->getStoreId())
                ->setCustomerId($customer->getId())
                ->setEmail($customer->getEmail());
        } else {
            $this->setStoreId($customer->getStoreId())
            	->setEmail($customer->getEmail());
        }

        $this->save();
        
        $sendSubscription = $customer->getData('sendSubscription');
        if (is_null($sendSubscription) xor $sendSubscription) {
            if ($this->getIsStatusChanged() && $status == self::STATUS_UNSUBSCRIBED) {
                $this->sendUnsubscriptionEmail();
            } elseif ($this->getIsStatusChanged() && $status == self::STATUS_SUBSCRIBED) {
                $this->sendConfirmationSuccessEmail();
                $this->makeGeneralAccount();
            } elseif($status == self::STATUS_NOT_ACTIVE){
            	$this->sendConfirmationRequestEmail();
            	$this->makeGeneralAccount();
            }
        }
        return $this;
    }

	public function getStatusAsText()
    {
    	if($this->getSubscriberStatus() == Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED)
    		return Mage::helper('newsletter')->__('Subscribed');
    	elseif ($this->getSubscriberStatus() == Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE)
    		return Mage::helper('newsletter')->__('Not activated');
    	elseif ($this->getSubscriberStatus() == Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED)
    		return Mage::helper('newsletter')->__('Unsubscribed');
    	
    	return '--';
      
    }
    public function sendConfirmationRequestEmail()
    {
    	if(Egovs_Extnewsletter_Model_Mage_Subscriber::$ConfirmationRequestEmailIsSended) return;
    	Egovs_Extnewsletter_Model_Mage_Subscriber::$ConfirmationRequestEmailIsSended = true;
    	
    	
    	$last = strtotime($this->getLastConfirmationRequest());
    	$jetzt = strtotime(date('Y-m-d H:i:s'));
        /** @noinspection SummerTimeUnsafeTimeManipulationInspection */
        if(($jetzt - $last) < 24*60*60)
    	{
    		return;
    	} 
    	
    	$this->setLastConfirmationRequest(date('Y-m-d H:i:s'));   	
    	$this->save();
    	
    	
    	parent::sendConfirmationRequestEmail();
    }
}