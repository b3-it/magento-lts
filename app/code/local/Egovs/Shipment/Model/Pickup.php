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


class Egovs_Shipment_Model_Pickup
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{

    protected $_code = 'storepickup';

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
        //if($this->_isNotVirtual($request))
        {
            $method = Mage::getModel('shipping/rate_result_method');

            $method->setCarrier('storepickup');
            $method->setCarrierTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/title'));
            //$method->setCarrierTitle($this->getConfigData('title'));

            $method->setMethod('storepickup');
            $method->setMethodTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/name'));

            $method->setPrice(0);
            $method->setCost(0);

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
        return array('storepickup'=>Mage::helper('shipping')->__('Store Pickup'));
    }
    
  	protected function _isNotVirtual($request)
    {
    	$ignore = Mage::getStoreConfig('carriers/'.$this->_code.'/ignorevirtual') == 1;
        $total = 0;
        $items = $request->getAllItems();
        $c = count($items);
        for ($i = 0; $i < $c; $i++) {
            if ($items[$i]->getProduct() instanceof Mage_Catalog_Model_Product) 
            {
            	if( !($items[$i]->getProduct()->getIsVirtual() && $ignore))
            	{
               		$total ++;
            	}
            }
        }
        return $total > 0;
    }

}
