<?php
/**
 * ResourceModel Collection für Versendete Waren
 *  
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author     	Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Sales_Shipping_Collection extends Mage_Reports_Model_Mysql4_Shipping_Collection
{
	/**
	 * Einsprungpunkt für Report
	 *
	 * @param string $from Von Datum
	 * @param string $to   Bis Datum
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Sales_Shipping_Collection
	 */
	public function setDateRange($from, $to)
    {
    	parent::setDateRange($from, $to);
    	
        $this->addAttributeToFilter("state", array('neq' => Mage_Sales_Model_Order::STATE_CANCELED));
        $this->addAttributeToFilter("state", array('neq' => Mage_Sales_Model_Order::STATE_CLOSED));
        return $this;
    }
}