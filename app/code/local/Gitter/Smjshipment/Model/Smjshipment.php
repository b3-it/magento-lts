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


class Gitter_Smjshipment_Model_Smjshipment
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{

	const Books = '3';
	const Normal = '2';
	const Oversize = '1';
	
    protected $_code = 'smjshipment';

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
        {
            $method = Mage::getModel('shipping/rate_result_method');

            $method->setCarrier('smjshipment');
            $method->setCarrierTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/title'));
            //$method->setCarrierTitle($this->getConfigData('title'));

            $method->setMethod('smjshipment');
            $method->setMethodTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/name'));

            if($request->getData('dest_country_id') == 'DE')
            {
            	$p = $this->calcPriceNational();	
            }else{
            	$p = $this->calcPriceInterNational();
            }
          
            
            $method->setPrice($p);
            $method->setCost($p);

            $result->append($method);
        }

        return $result;
    }

    /**
     * Get allowed shipping methods
     *
     * @return array
     */
    public function getAllowedMethods()
    {
        return array('smjshipment'=>Mage::helper('smjshipment')->__('Shipping by Type'));
    }
    
    
    private function calcPriceNational()
    {
    	$group = $this->getItemGroups();
    	//b�chersendung
    	if( ($group[Gitter_Smjshipment_Model_Smjshipment::Books]>0)
    	  &&($group[Gitter_Smjshipment_Model_Smjshipment::Normal]==0)
    	  &&($group[Gitter_Smjshipment_Model_Smjshipment::Oversize]==0))
    	  {
    	  	$qty = $group[Gitter_Smjshipment_Model_Smjshipment::Books];
    	  	if($qty > 9 ) return Mage::getStoreConfig('carriers/smjshipment/nat_book10')+0;
    	  	elseif($qty > 5) return Mage::getStoreConfig('carriers/smjshipment/nat_book6')+0;
    	  	else return Mage::getStoreConfig('carriers/smjshipment/nat_book1')+0;
    	  } 
    	//�berg��e
    	else if($group[Gitter_Smjshipment_Model_Smjshipment::Oversize] > 0){
    		return $group[Gitter_Smjshipment_Model_Smjshipment::Oversize]*Mage::getStoreConfig('carriers/smjshipment/nat_oversize')+0;
    	}
    	//normal
    	else if($group[Gitter_Smjshipment_Model_Smjshipment::Normal]>0){
    		return Mage::getStoreConfig('carriers/smjshipment/nat_normal')+0;
    	}
    	else return 0;
    }
    
    private function calcPriceInterNational()
    {
    	$group = $this->getItemGroups();
    	//b�chersendung
    	if( ($group[Gitter_Smjshipment_Model_Smjshipment::Books]>0)
    	  &&($group[Gitter_Smjshipment_Model_Smjshipment::Normal]==0)
    	  &&($group[Gitter_Smjshipment_Model_Smjshipment::Oversize]==0))
    	  {
    	  	$qty = $group[Gitter_Smjshipment_Model_Smjshipment::Books];
    	  	if($qty > 9 ) return Mage::getStoreConfig('carriers/smjshipment/int_book10')+0;
    	  	elseif($qty > 5) return Mage::getStoreConfig('carriers/smjshipment/int_book6')+0;
    	  	else return Mage::getStoreConfig('carriers/smjshipment/int_book1')+0;
    	  } 
    	//�berg��e
    	else if($group[Gitter_Smjshipment_Model_Smjshipment::Oversize] > 0){
    		return $group[Gitter_Smjshipment_Model_Smjshipment::Oversize]*Mage::getStoreConfig('carriers/smjshipment/int_oversize')+0;
    	}
    	//normal
    	else if($group[Gitter_Smjshipment_Model_Smjshipment::Normal]>0){
    		return Mage::getStoreConfig('carriers/smjshipment/int_normal')+0;
    	}
    	else return 0;
    }
    
    private function getItemGroups()
    {
        $sess = Mage::getSingleton('checkout/session');
		$items = $sess->getQuote()->getAllItems();
		$res = array('1'=>0,'2'=>0,'3'=>0);
		foreach($items as $item) {
		    $product = $item->getProduct();
		    if($product != null){
		    	$idx = $product->getData('smjshipment_group');
		    	if($idx != null){
		    		$res[$idx] += $item->getData('qty');
		    	}
		    }
		}
		return $res;
    }

}