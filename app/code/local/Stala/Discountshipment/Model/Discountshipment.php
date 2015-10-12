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


class Stala_Discountshipment_Model_Discountshipment
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{


    protected $_code = 'discountshipment';

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

       
        /*
        if (!Mage::getStoreConfig('carriers/'.$this->_code.'/active'))
	            return false;
		*/
        $result = Mage::getModel('shipping/rate_result');
        
        if($this->_getTotal($request) <=  0.01)
        {
            $method = Mage::getModel('shipping/rate_result_method');

            $method->setCarrier('discountshipment');
            $method->setCarrierTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/title'));
            //$method->setCarrierTitle($this->getConfigData('title'));

            $method->setMethod('discountshipment');
            $method->setMethodTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/name'));          
            $method->setPrice('0.00');
            $method->setCost('0.00');

            $result->append($method);
            return $result;
        }

        return false;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array('discountshipment'=>Mage::helper('discountshipment')->__('Freeshipping'));
    }
    
    
    protected function _getTotal($request)
    {
    	
    	$a = $request->getPackageValueWithDiscount();
    	
    	//wegen Problemen mit Rabatten diese Methode alternativ gewählt
        $total = 0.0;
        $items = $request->getAllItems();
        foreach ($items as $item)
        {
            if ($item->getProduct() instanceof Mage_Catalog_Model_Product) 
            {
            	if ($item->getDiscountAmount() > 0){
            		$total += $item->getRowTotalWithDiscount();
            	}
            	else{
            		$total += $item->getPrice();
            	}
            	
            }
        }
  	 
    	return min($a,$total);
    }
    
 	

}