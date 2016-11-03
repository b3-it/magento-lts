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


class Egovs_Shipment_Model_Bulkgoods
    extends Mage_Shipping_Model_Carrier_Abstract
    implements Mage_Shipping_Model_Carrier_Interface
{


	/**
	 * code name
	 *
	 * @var string
	 */
	protected $_code = 'bulkgoods';
	
	protected $_rates = null;
	
	protected $_request = null;
	
	/*
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		
	}
	
	/**
	 * Collect and get rates
	 *
	 * @param Mage_Shipping_Model_Rate_Request $request
	 * @return Mage_Shipping_Model_Rate_Result
	 */
	public function collectRates(Mage_Shipping_Model_Rate_Request $request)
	{
		if (!$this->getConfigFlag('active')) {
			return false;
		}
		
		$this->_request = $request;
	
		$costs = array();
		
		foreach ($request->getAllItems() as $item) {
				if ($item->getParentItem()) {
					continue;
				}
				if ($item->getHasChildren() && $item->isShipSeparately()) {
					foreach ($item->getChildren() as $child) {
						if ($child->getProduct()->isVirtual() && $this->getConfigFlag('include_virtual_price')) 
						{
							$costs[] = $this->getCost($child);	
						}
					}
			}else{
				$costs[] = $this->getCost($item);
			}
		}
	
		if(count($costs) == 0){
			return false;
		}
		
		$maxPrice  = 0;
		foreach($costs as $cost){
			if($cost->getPrice() > $maxPrice){
				$maxPrice = $cost->getPrice();
			}
		}
		
		
		$result = Mage::getModel('shipping/rate_result');
		$method = Mage::getModel('shipping/rate_result_method');
		
		$method->setCarrier('bulkgoods');
		$method->setCarrierTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/title'));
		//$method->setCarrierTitle($this->getConfigData('title'));
		
		$method->setMethod('bulkgoods');
		$method->setMethodTitle(Mage::getStoreConfig('carriers/'.$this->_code.'/name'));
		
		
		$method->setCost(0);
		
		$handling_fee = Mage::getStoreConfig('carriers/'.$this->_code.'/handling_fee');
		$cost = 0;
		if($handling_fee > 0)
		{
			if(Mage::getStoreConfig('carriers/'.$this->_code.'/handling_type') == Mage_Shipping_Model_Carrier_Abstract::HANDLING_TYPE_FIXED){
				$cost = $handling_fee;
			}
			if(Mage::getStoreConfig('carriers/'.$this->_code.'/handling_type') == Mage_Shipping_Model_Carrier_Abstract::HANDLING_TYPE_PERCENT){
				$cost = $maxPrice * (1 + ($handling_fee / 100.0));
			}
		}
		
		$method->setPrice($maxPrice + $cost);
		
		
		$result->append($method);
		
		return $result;
	
	}
	
	
	//Versandpreis für ein Item ermitteln
	protected function getCost($item)
	{
		$rates = $this->getRates();
		
		//shipment_group filter
		$group = $this->filter($rates, 'shipment_group', $item->getProduct()->getShipmentGroup());
		
		$countrys = $this->filter($group, 'dest_country_id', $this->_request->getDestCountryId());
		if(count($countrys) == 0){
			$countrys = $this->filter($group, 'dest_country_id', '*');
		}
		
		$regions = $this->filter($countrys, 'dest_region_id', $this->_request->getDestRegionId());
		if(count($regions) == 0){
			$regions = $this->filter($countrys, 'dest_region_id', '0');
		}
		
		//kleinste Mengen kommen zuerst
		if(count($regions) == 1){
			if($regions[0]->getQty() == 0){
				$obj = new Varien_Object(array('rate'=>$regions[0],'price' => $regions[0]->getPrice() * $item->getQty()));
				return $obj;
			}
		}
		foreach($regions as $r){
			//falls Menge größer
			if ($r->getQty() >=  $item->getQty()) {
				$obj = new Varien_Object(array('rate'=>$r,'price' => $r->getPrice())); 	
				return $obj;
			}
			
		}
		
		return null;
	}
	
	/*
	 * Array filter
	 */
	protected function filter($data,$field,$value)
	{
		$res = array();
		foreach($data as $d)
		{
			if($d->getData($field) == $value){
				$res[] = $d;
			}
		}
		
		return $res;
	}
	
	
	/**
	 * Get Rate
	 *
	 * @param Mage_Shipping_Model_Rate_Request $request
	 *
	 * @return Mage_Core_Model_Abstract
	 */
	public function getRates()
	{
		if($this->_rates == null)
		{
// 			$collection = Mage::getResourceModel('egovsshipment/carrier_bulkgoods')->getCollection();
// 			$this->_rates = $collection->getItems();
			$this->_rates = Mage::getResourceModel('egovsshipment/carrier_bulkgoods')->getRate($this->_request);
		}
		
		return $this->_rates;
	}
	
	
	
	/**
	 * Get allowed shipping methods
	 *
	 * @return array
	 */
	public function getAllowedMethods()
	{
		return array('bulkgoods' => $this->getConfigData('name'));
	}
	

}