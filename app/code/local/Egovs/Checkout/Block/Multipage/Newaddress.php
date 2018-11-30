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

/**
 * checkout choose item addresses block
 *
 * @category   Egovs
 * @package    Egovs_Checkout
 */
class Egovs_Checkout_Block_Multipage_Newaddress extends Egovs_Checkout_Block_Multipage_Abstract
{
    private $_address = null;

    /**
     * Retrieve multipage checkout model
     *
     * @return Egovs_Checkout_Model_Multipage
     */
    public function getCheckout()
    {
        return Mage::getSingleton('mpcheckout/multipage');
    }

    protected function _prepareLayout()
    {
        if ($headBlock = $this->getLayout()->getBlock('head')) {
            $headBlock->setTitle(Mage::helper('checkout')->__('Checkout Procedure'). " - " .Mage::helper('checkout')->__('New Address'));
        }
        return parent::_prepareLayout();
    }

    public function getItems()
    {
        $items = $this->getCheckout()->getQuoteShippingAddressesItems();
        $itemsFilter = new Varien_Filter_Object_Grid();
        $itemsFilter->addFilter(new Varien_Filter_Sprintf('%d'), 'qty');
        return $itemsFilter->filter($items);
    }

    public function canShip()
    {
        return !$this->getQuote()->isVirtual();
    }

    /**
     * Retrieve options for addresses dropdown
     *
     * @return array
     */
    public function getAddressOptions()
    {
        $options = $this->getData('address_options');
        if (is_null($options)) {
            $options = array();
            foreach ($this->getCustomer()->getAddresses() as $address) {
                $options[] = array(
                    'value'=>$address->getId(),
                    'label'=>$address->format('oneline')
                );
            }
            $this->setData('address_options', $options);
        }
        return $options;
    }

    function getAddress() {

    	if($this->_address != null) return $this->_address;
    	$res = null;
        if (!$this->isCustomerLoggedIn()) {
            $res = $this->getQuote()->getBillingAddress();
        } else {
            $res = Mage::getModel('sales/quote_address');
            if($res['prefix'] == '') $res['prefix'] = $this->getQuote()->getCustomer()->getPrefix();
            if($res['firstname'] == '') $res['firstname'] = $this->getQuote()->getCustomer()->getFirstname();
            if($res['lastname'] == '') $res['lastname'] = $this->getQuote()->getCustomer()->getLastname();

        }

        $postdata = Mage::getSingleton('customer/session')->getData('addresspostdata');
        if(($postdata != null) && is_array($postdata))
        {
	        $keys = array_keys($postdata);
	        foreach ($keys as $key)
	        {
	        	//if($res->getData($key)== null)
	        	$res->setData($key,$postdata[$key]);
	        }
        }
        Mage::getSingleton('customer/session')->unsetData('addresspostdata');
        $this->_address = $res;

        return $res;
    }
    
    public function getFormData() {
    	$postdata = Mage::getSingleton('customer/session')->getData('addresspostdata');
    	if(($postdata != null) && is_array($postdata)) {    		
    		return new Varien_Object($postdata);
    	}    	
    	return new Varien_Object();
    }    

    public function getFieldRequiredHtml($name, $method = null) {
        return $this->getFieldRequired($name, $method, 'html');
    }

    public function getFieldRequiredClass($name, $method = null) {
        return $this->getFieldRequired($name, $method, 'class');
    }

    private function getFieldRequired($name, $method = null, $return = 'html') {
        if ( $return == 'html' ) {
            $requiredHtml = '<span class="required">*</span>';
        }
        elseif ( $return == 'class' ) {
            $requiredHtml = 'required-entry';
        }

        if ($method == null) {
    		    $method = $this->getQuote()->getCheckoutMethod();
    	  }

        if ($this->isFieldRequired($name, $method)) {
            return $requiredHtml;
        }
        if (!$this->getQuote()->isVirtual()) {
            /* @var $addrValidator Egovs_Checkout_Model_Validateadr */
            $addrValidator = Mage::getSingleton('mpcheckout/validateadr');
            $omit = array('taxvat','prefix','company', 'fax', 'telephone', 'region');
            if (!in_array($name, $omit) && !$addrValidator->validateShippingAddressField($name, null)) {
                return $requiredHtml;
            }
        }
        return '';
    }

 	public function isFieldVisible($key, $method = null)
 	{
 		$ship = false;
 		if($this->isUsedForShipping()) {
 		 	$ship =	parent::isFieldVisible($key,'shipping');
 		}
 		return (parent::isFieldVisible($key) || $ship);

 	}

 	public function isAdditionalCompanyVisible()
 	{
  			$method = $this->getQuote()->getCheckoutMethod();
			if(Mage_Sales_Model_Quote::CHECKOUT_METHOD_GUEST == $method)
	    	{
	    		$key = 'customer/guestrequired/additionalcompany';
	    	}
	    	elseif ('shipping' == $method)
	    	{
	    		$key = 'customer/shippingrequired/additionalcompany';
	    	}
	    	else
	    	{
	    		$key = 'customer/registerrequired/additionalcompany';
	    	}

	    	$res = Mage::getStoreConfig($key);
	    	return isset ($res) ?  $res : false;

 	}


 	private function isUsedForShipping()
 	{

 		$data = Mage::getSingleton('customer/session')->getData('use_for_shipping');
 		if (isset($data) && $data == 1) return true;

 		return false;
 	}

 	public function isStorePickup()
 	{
 		$data = Mage::getSingleton('customer/session')->getData('use_for_shipping');
 		if (isset($data) && $data == 2) return true;

 		return false;
 	}


    public function getBillingtext()
    {
    	return Mage::getModel('mpcheckout/adrtext')->getBillingtext();
    }

   public function isGuest()
    {
        return ($this->getCheckout()->getCheckoutMethod() === 'guest');
    }

    public function getCustomer()
    {
        return $this->getCheckout()->getCustomerSession()->getCustomer();
    }

    public function getItemUrl($item)
    {
        return $this->getUrl('catalog/product/view/id/'.$item->getProductId());
    }

    public function getItemDeleteUrl($item)
    {
        return $this->getUrl('*/*/removeItem', array('address'=>$item->getQuoteAddressId(), 'id'=>$item->getId()));
    }

    public function getPostActionUrl()
    {
        return $this->getUrl('*/*/addressesPost', array('_secure'=>true));
    }

    public function getNewAddressUrl()
    {
        return Mage::getUrl('*/edit/newShipping', array('_secure'=>true));
    }

    public function getBackUrl()
    {
        return Mage::getUrl('checkout/cart/', array('_secure'=>true));
    }

    public function isContinueDisabled()
    {
        return !$this->getCheckout()->validateMinimumAmount();
    }
}
