<?php
class Egovs_Extnewsletter_Model_Subscriber extends Egovs_Extnewsletter_Model_Mage_Subscriber
{

	/*
	 * wird von MPCheckout aufgerufen
	 */
	public function subscribeWithOptions($email,$products)
	{
		try
		{
			if($products == null) return;
			if(!is_array($products)) return;
			//if(count($products) == 0) return;
			
			
			if($email=='')
			{
				$customer =  Mage::getSingleton('customer/session')->getCustomer();
				/*
	                ->setStoreId(Mage::app()->getStore()->getId())
	                ->setIsSubscribed(count($products)>0)
	                ->save();
	             */  
	              //$news = Mage::getModel('newsletter/subscriber');
				$this->loadByEmail($customer->getData('email'));
				if (!$this->getId() )
				{
				 	$this->_subscribe($customer->getData('email'));
				}	
			
			}
			else
			{
				//$news = Mage::getModel('newsletter/subscriber');
				//$status = $news->subscribe($email);
				//$subsciber = $news->loadByEmail($email);
				$this->loadByEmail($email);
				//if (!$this->getId() )
				{
				 	$this->_subscribe($email);
				}
			}
			
			$flat = implode(',',$products);
			$msg = "Subscribe on checkout [eMail: $email; Subscriber: ".$this->getId()."; Products: ($flat)].";				
			Mage::log("extnewsletter::".$msg, Zend_Log::NOTICE, Egovs_Helper::LOG_FILE);

			foreach($products as $product)
			{
				//if($product != 'all')
				{
					$extnews = Mage::getModel('extnewsletter/extnewsletter');
					$extnews->loadByIdAndProduct($this->getId(),$product);
					if(!$extnews->getId())
					{
						$extnews->setData('subscriber_id',$this->getId());
						$extnews->setData('product_id',$product);
						
					}
					$extnews->setData('is_active','1');
					$extnews->save();
				}
			}
			
			//$this->saveNewsOption($products);
		}
		catch(Exception $e)
		{
			//Mage::getSingleton('customer/session')->addError(Mage::helper('extnewsletter')->__('There was an error while saving your subscription'));
			Mage::log("extnewsletter::".$e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
	}
	
	
	/*
	 * wird vom Customer-Account aufgerufen
	 */
	public function saveOptions($subsciberid,$products, $issues)
	{
		try
		{
			if($subsciberid == null)
			{
				  $customer =  Mage::getSingleton('customer/session')->getCustomer();
				  /*
	                ->setStoreId(Mage::app()->getStore()->getId())
	                ->setIsSubscribed(count($products)>0)
	                ->save();
	              */ 
	              //$news = Mage::getModel('newsletter/subscriber');
				  $this->loadByEmail($customer->getData('email'));
				if (!$this->getId() )
				{
				 	$this->_subscribe($customer->getData('email'));
				}	
			}
			else
			{
				$this->load($subsciberid);
				//Mage::getResourceModel('extnewsletter/extnewsletter')->resetProductsBySubscriberId($subsciberid);
			}
			
			$this->saveNewsOption($products,$issues);
			Mage::getSingleton('customer/session')->addSuccess(Mage::helper('extnewsletter')->__('The newsletter settings was successfully saved.'));
		}
		catch(Exception $e)
		{
			Mage::getSingleton('customer/session')->addError(Mage::helper('extnewsletter')->__('There was an error while saving your newsletter settings.'));
			Mage::log("extnewsletter::".$e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
		
	}
	
	
	private function saveNewsOption($products, $issues)
	{
		try
		{
			if($products == null) $products=array();
			if($issues == null) $issues = array();
			Mage::getResourceModel('extnewsletter/extnewsletter')->resetProductsBySubscriberId($this->getId());
			Mage::getResourceModel('extnewsletter/issuesubscriber')->resetIssuesBySubscriberId($this->getId());
			
			
			//$extnews = Mage::getModel('extnewsletter/extnewsletter');
			
			foreach($products as $product)
			{
				//if($product != 'all')
				{
					$extnews = Mage::getModel('extnewsletter/extnewsletter');
					$extnews->loadByIdAndProduct($this->getId(),$product);
					if(!$extnews->getId())
					{
						$extnews->setData('subscriber_id',$this->getId());
						$extnews->setData('product_id',$product);
						
					}
					$extnews->setData('is_active','1');
					$extnews->save();
				}
			}
			
			foreach($issues as $issue)
			{
				//if($product != 'all')
				{
					$m = Mage::getModel('extnewsletter/issuesubscriber');
					$m->loadByIdAndIssue($this->getId(),$issue);
					if(!$m->getId())
					{
						$m->setData('subscriber_id',$this->getId());
						$m->setData('issue_id',$issue);
						
					}
					$m->setData('is_active','1');
					$m->save();
				}
			}
		
			//falls keine Newsletter angehakt wurden
			if((count($products) + count($issues)) == 0)
			{
					$this->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_UNSUBSCRIBED);
					$this->save();
			}
			else
			{
				//falls Newsletter angehakt wurden und keine Best�tigung gew�nscht ist
				if (Mage::getStoreConfig(self::XML_PATH_CONFIRMATION_FLAG) != 1) 
				{       
					$this->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_SUBSCRIBED);
					$this->save();
				}
				else
				{
					if ($this->getStatus()!=self::STATUS_SUBSCRIBED )
					{
						
						$this->setStatus(Mage_Newsletter_Model_Subscriber::STATUS_NOT_ACTIVE);
						$this->save();
						$this->sendConfirmationRequestEmail();
						
					}
				}
			}
			
		}
		catch(Exception $e)
		{
			Mage::log("extnewsletter::".$e->getMessage(), Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
	}
	
	
	

}