<?php
/**
 * Configurable Downloadable Block für Sales Items Columns
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Block_Adminhtml_Sales_Items_Column_Name extends Mage_Adminhtml_Block_Sales_Items_Column_Name
{
    private $_station = null;

    public function getStation() {
    	//if ($this->_station == null) 
    	{
    		$id = $this->getItem()->getStationId();
    		if ($id == null) {
    			return null;
    		}
    	 	$this->_station = Mage::getModel('stationen/stationen')->load($id);
    	}
     	return $this->_station;   
    }
    
 	public function hasPeriode() {
    	return ($this->getItem()->getPeriodType() > 0);
    }
    
    public function getFormatedPeriode() {
    	return $this->getItem()->getPeriodStart().' - '.$this->getItem()->getPeriodEnd();
    }
}
