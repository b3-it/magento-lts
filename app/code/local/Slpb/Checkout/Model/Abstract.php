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
 * @package    Mage_Checkout
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Slpb_Checkout_Model_Abstract extends Mage_Checkout_Model_Type_Abstract
{
	
	const DummyEmailDomain = 'dummy.slpb.de';
    /**
     * Enter description here...
     *
     * @return Mage_Checkout_Model_Session
     */
    public function getCheckout()
    {
        return Mage::getSingleton('checkout/session');
    }

    /**
     * Enter description here...
     *
     * @return Mage_Sales_Model_Quote
     */
    public function getQuote()
    {
        return $this->getCheckout()->getQuote();
    }


 

    /**
     * Check if customer email exists
     *
     * @param string $email
     * @param int $websiteId
     * @return false|Mage_Customer_Model_Customer
     */
    protected function _customerEmailExists($email, $websiteId = null)
    {
        $customer = Mage::getModel('customer/customer');
        if ($websiteId) {
            $customer->setWebsiteId($websiteId);
        }
        $customer->loadByEmail($email);
        if ($customer->getId()) {
            return $customer;
        }
        return false;
    }

    /**
     * Enter description here...
     *
     * @return string
     */
    public function getLastOrderId()
    {
     
        $order = Mage::getModel('sales/order');
        $order->load($this->getCheckout()->getLastOrderId());
        $orderId = $order->getIncrementId();
        return $orderId;
    }
    

    protected function isNotEmpty($value)
    {
    	return (strlen($value) > 0);
    }
    
    
    
    protected function addPaymentMethode($aMethode)
    {
    	$paymentdata = array();
		$paymentdata['method'] = $aMethode;
         
        $payment = $this->getQuote()->getPayment();
        $payment->importData($paymentdata);

        $this->getQuote()->getShippingAddress()->setPaymentMethod($payment->getMethod());
        $this->getQuote()->collectTotals();
    }
    
  
    
    protected function validateAddress(&$data)
    {
    	
     	$errors = array();
    	if(!$this->isNotEmpty($data['firstname']))$errors[] = Mage::helper('mpcheckout')->__('Please enter first name.');
    	if(!$this->isNotEmpty($data['lastname']))$errors[] = Mage::helper('mpcheckout')->__('Please enter last name.');
    	if(!$this->isNotEmpty($data['city']))$errors[] = Mage::helper('mpcheckout')->__('Please enter city.');
    	
    	$adr = $data['street'];
    	if (is_array($adr)) $adr = implode('',$adr);
    	if(!$this->isNotEmpty($adr)) $errors[] = Mage::helper('mpcheckout')->__('Please enter street.');
 	    	  	
    	if(!$this->isNotEmpty($data['postcode']))$errors[] = Mage::helper('mpcheckout')->__('Please enter zip/postal code.');
    	if(isset($data['postcode']) && (strlen($data['postcode'])>0))
    	{
    		$data['postcode'] = trim(str_replace('D-','',$data['postcode']));
    		if(preg_match("/^[0-9]{5}$/",$data['postcode'])==0)
    		{
    			Mage::log('plz:"'.$data['postcode'].'"' , Zend_Log::ALERT,Slpb_Extstock_Helper_Data::EXCEPTION_LOG_FILE);
    			$errors[] = Mage::helper('mpcheckout')->__('Please enter valid zip/postal code.');
    		}
    	}
    	if(count($errors)> 0 )	return implode(' ',$errors);
    	return true;
    }
    
    
    protected function normalizeAddress($data)
    {
    	$res = array();
    	$res['country_id'] = "DE";
    	$res['firstname'] = trim($data['firstname']);
    	$res['lastname'] = trim($data['lastname']);
    	$res['city'] = (ucfirst(strtolower(trim($data['city']))));
    	$res['postcode'] = trim($data['postcode']);
    	$res['customernumber'] = "";
    	$res["address_id"]= "new";
  		$res["prefix"]= $data['prefix'];
    	
    	
    	
    	
    	$strasse = preg_replace("/\s+/", " ",(ucwords(trim(mb_strtolower($data['street'][0],'UTF-8')))));
 
    	$suchmuster = array();
		$suchmuster[0] = '/'.utf8_encode('stra�e').'/u';
		$suchmuster[1] = '/strasse/';
		$suchmuster[2] = '/Stra�e/';
		$suchmuster[3] = '/Strasse/';
		$suchmuster[4] = '/Str$/';
		$suchmuster[5] = '/str$/';
		$suchmuster[6] = '/'.utf8_encode('Stra�e').'/u';

		$ersetzungen = array();
		$ersetzungen[0] = 'str.';
		$ersetzungen[1] = 'str.';
		$ersetzungen[2] = 'Str.';
		$ersetzungen[3] = 'Str.';
		$ersetzungen[4] = 'Str.';
		$ersetzungen[5] = 'str.';
		$ersetzungen[6] = 'Str.';

		$strasse = explode(" ",$strasse);
		for($i = 0, $iMax = count($strasse); $i < $iMax; $i++)
		{
			$strasse[$i] = $this->replace($suchmuster, $ersetzungen, $strasse[$i]);
		}
		
		$res['street'] = implode(" ",$strasse);
 		//echo '<pre>'; var_dump($data); echo '<br><br>'; var_dump($res); echo '<br><br>'; var_dump($strasse); die();
		return $res;
    	
    }
    
    protected function getCustomerAddressId($data)
    {
    	$AttributeId = Mage::getModel('customer/customer')
    		->getCollection()
    		->getAttribute('default_billing');
    	$tab = $AttributeId->getBackendTable();
    	$id = $AttributeId->getId();
    	$dummy = Slpb_Checkout_Model_Abstract::DummyEmailDomain;
    	//echo '<pre>'; var_dump($AttributeId); die();
    	$collection = Mage::getModel('customer/address')
    		->getCollection()
    		->addAttributeToFilter('firstname',$data['firstname'])
    		->addAttributeToFilter('lastname',$data['lastname'])
    		->addAttributeToFilter('country_id',$data['country_id'])
    		->addAttributeToFilter('city',$data['city'])
    		->addAttributeToFilter('postcode',$data['postcode'])
    		->addAttributeToFilter('street',$data['street'])
    		->addAttributeToFilter('city',$data['city'])
    		->joinTable('customer/entity','entity_id=parent_id',array('email'),"email like '%@$dummy'")
    		->joinTable($tab,"value=entity_id",array('billingid'=>'value'),"$tab.attribute_id=$id"); 	
    	//die($collection->getSelect()->__toString());
    	$items = $collection->getItems();
    	if(count($items) != 1) return 0;
    	$item = array_shift($items);
    	return $item->getId();
    	//echo '<pre>'; var_dump($collection);die;
    }
    
    private function replace($such,$replace,$subject)
    {
    	$res = "";
    	for($i =0, $iMax = count($such); $i < $iMax; $i++)
    	{
    		$count = 0;
    		$res = preg_replace($such[$i], $replace[$i], $subject,1, $count);
    		if($count > 0)
    		{
    			return $res;
    		}
    	}
  		return $subject;
    }
    
    //Aufbau d Kundenummer.
    //kundenid 6 Stellig 1+2 Zeichen
    //letzten 2 Stellen  d. Quersumme
    //kundenid 6 Stellig REst
    public function encodeCustumerId($custonmerId)
    {
    	$custonmerId = $custonmerId * 3;
    	$cross = $this->crossfoot($custonmerId);
		$custonmerId = sprintf("%06d", $custonmerId);
    	
		return substr($custonmerId,0,2).$cross.substr($custonmerId,2);
    }
    
    public function decodeCustumerId($value)
    {
    	if(strlen($value) == 8)
        {
            $crossin = substr($value,2,2);
            $customerid = substr($value,0,2).substr($value,4);
            $cross = $this->crossfoot($customerid);
            if($cross === $crossin)
            {
                return $customerid / 3;
               
            }
        }
    	Mage::throwException(Mage::helper('checkout')->__('Customer registered number is not valid!'));
    }
    
   private function crossfoot ( $digits )
	  {
	    // Typcast falls Integer uebergeben
	    $strDigits = ( string ) $digits;
	
	    $intCrossfoot = 0;
	    for($i = 0, $iMax = strlen($strDigits); $i < $iMax; $i++ )
	    {
	      $intCrossfoot += $strDigits[$i];
	    }
	
        $strDigits = sprintf("%06d", $intCrossfoot);
	    return substr($strDigits,4,2);
	  } 
    
    
}
