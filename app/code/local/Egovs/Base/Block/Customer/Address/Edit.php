<?php
/**
 * Customer address edit block
 *
 * @category	Egovs
 * @package		Egovs_Base
 * @author		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @author		Frank Fochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Base_Block_Customer_Address_Edit extends Mage_Customer_Block_Address_Edit
{
	protected function _prepareLayout() {
		parent::_prepareLayout();
		
		if (!$this->_address->getId() && !$this->_address->hasCompany()) {
			$this->_address
                ->setCompany($this->getCustomer()->getCompany());
		}
	}
	
	/**
	 * @deprecated not used anymore and doesn't work with ajax
	 * {@inheritDoc}
	 * @see Mage_Directory_Block_Data::getRegionCollection()
	 */
	public function getRegionCollection() {
		if (!$this->_regionCollection) {
			$this->_regionCollection = Mage::getModel('directory/region')->getResourceCollection()
			->addCountryFilter('DE') //$this->getAddress()->getCountryId()
			->load();
		}
		return $this->_regionCollection;
	}
	 
	/**
	 * @deprecated not used anymore and doesn't work with ajax
	 * @return NULL[][]
	 */
	public function getRegionCollectionAsOptionArray() {
		$collection = $this->getRegionCollection();
		$options = array();
		foreach ($collection->getItems() as $item) {
			$options[] = array(
					'value' => $item->getId(),
					'label' => $item->getName()
			);
		}
		if (count($options)>0) {
			array_unshift($options, array('title'=>null, 'value'=>'', 'label'=>Mage::helper('egovsbase')->__('Out of Germany')));
		}
		return $options;
	}
	
	public function isFieldRequired($key, $default = false, $method = 'register') {
		$helper = null;
		try {
			$helper = Mage::helper('egovsbase/config');
		} catch (Exception $e) {
			Mage::log("Helper 'egovsbase/config' not available!", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
		
		if (!$helper || is_null($helper)) {
			return $default;
		}
		
		return ($helper->isFieldRequired($key,$method));
	}
	
	public function canShowField($key, $default = true, $method = 'register') {
		$helper = null;
		try {
			$helper = Mage::helper('egovsbase/config');
		} catch (Exception $e) {
			Mage::log("Helper 'egovsbase/config' not available!", Zend_Log::ERR, Egovs_Helper::EXCEPTION_LOG_FILE);
		}
	
		if (!$helper || is_null($helper)) {
			return $default;
		}
		
		switch ($helper->getConfig($key, $method)) {
			case '' :
				return false;
			default :
				return true;
		}
	}
	
	public function getCountryHtmlSelect($defValue=null, $name='country_id', $id='country', $title='Country') {
        Varien_Profiler::start('TEST: '.__METHOD__);
        if (is_null($defValue)) {
            $defValue = $this->getCountryId();
        }
        $cacheKey = 'DIRECTORY_COUNTRY_SELECT_STORE_'.Mage::app()->getStore()->getCode();
        if (Mage::app()->useCache('config') && $cache = Mage::app()->loadCache($cacheKey)) {
            $options = unserialize($cache);
        } else {
            $options = $this->getCountryCollection()->toOptionArray();
            if (Mage::app()->useCache('config')) {
                Mage::app()->saveCache(serialize($options), $cacheKey, array('config'));
            }
        }
        $class = 'validate-select';
        if ($this->isFieldRequired('country_id')) {
        	$class .= ' required-entry';
        }
        $block = $this->getLayout()->createBlock('core/html_select')
            ->setName($name)
            ->setId($id)
            ->setTitle(Mage::helper('directory')->__($title))
            ->setClass($class)
            ->setValue($defValue)
            ->setOptions($options);

        $data = array('block' => $block, 'parent' => $this);
        Mage::dispatchEvent('egovs_base_customer_address_edit_block_before_html', $data);

        $html = $block
            ->getHtml();

        Varien_Profiler::stop('TEST: '.__METHOD__);
        return $html;
    }
    
    public function isStreetEmpty() {
    	$street = $this->getAddress()->getStreet();
    	
    	if (is_array($street)) {
    		foreach ($street as $s) {
    			if (!empty($s)) {
    				return false;    				
    			}
    		}
    		return true;
    	}
    	
    	if (empty($street)) {
    		return true;
    	}
    	
    	return false;
    }
    
    /**
     * Stammadresse
     * @return number|boolean
     */
    public function canSetAsBaseAddress()
    {
    	if(!$this->changeBaseAddressAlowed())
    	{
    		return false;
    	}
    	if (!$this->getAddress()->getId()) {
    		return $this->getCustomerAddressCount();
    	}
    	return !$this->isBaseAddress();
    }
    
    public function getCanSetAsBaseAddress()
    {
    	return $this->canSetAsBaseAddress();
    }
    
    /**
     * Stammadresse
     * @return number|boolean
     */
    public function isBaseAddress()
    {
    	if($this->getAddress()->getBaseAddress() == 1)
    	{
    		return true;
    	}
    	$baseAddress = Mage::getSingleton('customer/session')->getCustomer()->getBaseAddress();
    	return $this->getAddress()->getId() && $this->getAddress()->getId() == $baseAddress;
    }
    
    public function getIsBaseAddress()
    {
    	return $this->isBaseAddress();
    }
    
    
    public function isDefaultBilling()
    {
    	if($this->getAddress()->getDefaultBilling() == 1)
    	{
    		return true;
    	}
    	$defaultBilling = Mage::getSingleton('customer/session')->getCustomer()->getDefaultBilling();
    	return $this->getAddress()->getId() && $this->getAddress()->getId() == $defaultBilling;
    }
    
    public function isDefaultShipping()
    {
    	if($this->getAddress()->getDefaultShipping() == 1)
    	{
    		return true;
    	}
    	$defaultShipping = Mage::getSingleton('customer/session')->getCustomer()->getDefaultShipping();
    	return $this->getAddress()->getId() && $this->getAddress()->getId() == $defaultShipping;
    }
 
    public function changeBaseAddressAlowed()
    {
    	if(!Mage::helper('egovsbase')->isModuleEnabled('Egovs_Vies'))
    	{
    		return false;
    	}
    	
    	if(!$this->isBaseAddress())
    	{
    		$customer = Mage::getSingleton('customer/session')->getCustomer();
    		if($customer && $customer->getData('use_group_autoassignment') != 1)
    		{
    			return false;
    		}
    	}
    	
    	return true;
    }
    
    
    public function getBaseAddressInfoText()
    {
    	$blockId = Mage::getStoreConfig('customer/address/base_address_info_block');
    	if($blockId)
    	{
    		return $this->getLayout()->createBlock('cms/block')->setBlockId($blockId)->toHTML();
    	}
    	
    	
    	return "";
    	
    }
    
    public function getNameBlockHtml()
    {
    	$nameBlock = $this->getLayout()
    		->createBlock('egovsbase/customer_widget_name')
    		->setObject($this->getAddress());

		$data = array('block' => $nameBlock, 'parent' => $this);
		Mage::dispatchEvent('egovs_base_customer_address_edit_block_before_html', $data);

    	return $nameBlock->toHtml();
    }
    
}
