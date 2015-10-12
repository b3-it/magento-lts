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
 * @package    Mage_Shipping
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Stala_Couriershipment_Model_Couriershipment
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{


    protected $_code = 'couriershipment';

    /**
     * Enter description here...
     *
     * @param Mage_Shipping_Model_Rate_Request $data
     * @return Mage_Shipping_Model_Rate_Result
     */
    public function collectRates(Mage_Shipping_Model_Rate_Request $request)
    {
        if (!$this->getConfigFlag('active')) {

            return false;
        }

   
        $result = Mage::getModel('shipping/rate_result');
       	$customer = $this->getCustomer($request);
        if($customer && $customer->getAllowCouriershipment() == 1)
        {
            $method = Mage::getModel('shipping/rate_result_method');

            $method->setCarrier('couriershipment');
            $method->setCarrierTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/title'));
            //$method->setCarrierTitle($this->getConfigData('title'));

            $method->setMethod('couriershipment');
            $method->setMethodTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/name'));          
            $method->setPrice('0.00');
            $method->setCost('0.00');

            $result->append($method);
            return $result;
        }

        return false;
    }
    
    private function getCustomer($request)
    {
    	$items = $request->getAllItems();
    	foreach ($items as $item)
    	{
    		return $item->getQuote()->getCustomer();
    	}
    	
    	$sessionQuote = Mage::getSingleton('adminhtml/session_quote');
    	
    	if (($id = $sessionQuote->getCustomerId()) > 0) {
    		return Mage::getModel('customer/customer')->load($id);
    	}
    	
    	return null;
    }
    
    /**
     * Processing additional validation to check is carrier applicable.
     *
     * @param Mage_Shipping_Model_Rate_Request $request
     * @return Mage_Shipping_Model_Carrier_Abstract|Mage_Shipping_Model_Rate_Result_Error|boolean
     */
    public function proccessAdditionalValidation(Mage_Shipping_Model_Rate_Request $request)
    {
    	if (($customer = $this->getCustomer($request)) && $customer->getAllowCouriershipment() == 1)
    		return $this;
    	
    	return false;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array('couriershipment'=>Mage::helper('couriershipment')->__('Shipping by Courier'));
    }
    
    
    protected function _getTotal($request)
    {
    	$ignore = Mage::getStoreConfig('carriers/couriershipment/ignorevirtual') == 1;
        $total = 0.0;
        $items = $request->getAllItems();
        $c = count($items);
        for ($i = 0; $i < $c; $i++) {
            if ($items[$i]->getProduct() instanceof Mage_Catalog_Model_Product) 
            {
            	if( !($items[$i]->getProduct()->getIsVirtual() && $ignore))
            	{
               		$total += $items[$i]->getPrice() * $items[$i]->getQty();
            	}
            }
        }
        return $total;
    }
    
    
   

}