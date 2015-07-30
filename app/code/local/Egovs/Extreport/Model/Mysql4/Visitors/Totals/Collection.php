<?php
/**
 * ResourceModel Collection für Besucheraktivitäten
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Visitors_Totals_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract//Mage_Reports_Model_Mysql4_Order_Collection
{
	/**
	 * Initialisiert die Collection
	 * 
	 * @return void
	 * 
	 * @see Mage_Core_Model_Mysql4_Collection_Abstract::_construct()
	 */
	protected function _construct()
    {
        parent::_construct();
        $this->_init('extreport/visitors_totals');
        $this->setItemObjectClass('extreport/visitors_totals');
    }
    
 
    /**
     * Initialisert die Select-Instanz
     * 
     * @return Egovs_Extreport_Model_Mysql4_Visitors_Totals_Collection
     * 
     * @see Mage_Core_Model_Mysql4_Collection_Abstract::_initSelect()
     */
	protected function _initSelect()
    {
        $this->getSelect()->from(array('main_table' => $this->getResource()->getMainTable()),
        	array('visitors'=>'count(visitor_id)',
        			'totalsec'=>' (sum(unix_timestamp(last_visit_at) - unix_timestamp(first_visit_at)) div 60)',
        			'meansec'=> '((sum(unix_timestamp(last_visit_at) - unix_timestamp(first_visit_at)) div count(visitor_id) )div 60)'
        	));
        return $this;
    }   	
   	
    /**
     * Setzt eine WHERE Bedingung (Datum VON-BIS)
     * 
     * @param string $from Von Datum
     * @param string $to   Bis Datum
     * 
     * @return Egovs_Extreport_Model_Mysql4_Visitors_Totals_Collection
     */
    protected function _joinFields($from = '', $to = '')
    {
        $this->getSelect()
         	->where("last_visit_at >='".$from."' AND last_visit_at <='".$to."'"); 
        return $this;
    }
    /**
     * Macht einen Reset und ruft dann _joinFields auf
     *
     * @param string $from Von Datum
     * @param string $to   Bis Datum
     *
     * @return Egovs_Extreport_Model_Mysql4_Visitors_Totals_Collection
     * 
     * @see Egovs_Extreport_Model_Mysql4_Visitors_Totals_Collection::_joinFields
     */
    public function setDateRange($from, $to)
    {

        $this->_reset()
            ->_joinFields($from, $to);
        return $this;
    }
	/**
	 * Setzt die Store IDs
	 * 
	 * @param array $storeIds Store IDs
	 * 
	 * @return Egovs_Extreport_Model_Mysql4_Visitors_Totals_Collection
	 */
    public function setStoreIds($storeIds)
    {
        $vals = array_values($storeIds);
        if (count($storeIds) >= 1 && $vals[0] != '') {
        	$this->getSelect()
         		->where("store_id = ".$vals[0])
        	;           
        } 

        return $this;
    }
}