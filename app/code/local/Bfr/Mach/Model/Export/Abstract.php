<?php
/**
 * Bfr Mach
 *
 *
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Model_Export_Abstract
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Model_Export_Abstract extends Mage_Core_Model_Abstract
{
	protected $_orderIds = null;
	protected $_ExportType = 0;
	protected $_Lauf = 0;
    
    public function getData4Order(array $orderIds = array() , $Lauf)
    {
    	$this->_orderIds = $orderIds;
    	$this->_Lauf = $Lauf;
    	
    	return array();
    }
    
    
    protected function getConfigValue($configName,$product = null, $storeId = null)
    {
    	return Mage::getStoreConfig('mach_export/'.$configName, $storeId);
    }
    
    protected function getDelimiter()
    {
    	return ';';
    }
    
    protected function getUser()
    {
    	return Mage::getSingleton('admin/session')->getUser();
    }
    
    
    public function saveHistory($lauf)
    {
    	if($this->_orderIds != null)
    	{
    		Mage::getModel('bfr_mach/history')->getResource()->saveHistory($this->_orderIds, $this->getUser()->getName(), $this->_ExportType, $lauf);
    	}
    }
    
    protected  function _formatPrice($value, $decimaseparator)
    {
    	if ($decimaseparator == null || strlen($decimaseparator) == 0){
    		$decimaseparator = ',';
    	}
    	
    	return str_replace('.', $decimaseparator, $value);
    }
}
