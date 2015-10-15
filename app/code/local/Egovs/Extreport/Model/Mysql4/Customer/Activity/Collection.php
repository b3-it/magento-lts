<?php
/**
 * ResourceModel Collection für Benutzeraktivitäten
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Holger Kögel <h.koegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Extreport_Model_Mysql4_Customer_Activity_Collection extends Mage_Customer_Model_Entity_Customer_Collection
{
	private $_subscriberfilter = null;
	private $_customersincefilter = null;
	private $_lastloginfilter = null;
	private $_lastorderfilter = null;
	
	/**
	 * Liefert diese Collection als Report
	 *
	 * Von/Bis Datum wird ignoriert
	 *
	 * @param string $from Von Datum
	 * @param string $to   Bis Datum
	 *
	 * @return Egovs_Extreport_Model_Mysql4_Customer_Activity_Collection
	 */
    public function getReportFull($from, $to)
    {
    	return $this;
    }   
    
    public function setSubscriberFilter($value)
    {
    	$this->_subscriberfilter = $value;
    }
    
   	public function setCustomerSinceFilter($value)
    {
    	$this->_customersincefilter = $value;
    }
   	
    public function setLastLoginFilter($value)
    {
    	$this->_lastloginfilter = $value;
    }
   	
    public function setLastOrderFilter($value)
    {
    	$this->_lastorderfilter = $value;
    }
    
    /**
     * Liefert die Anzahl der Ergebnisse
     * 
     * @return integer
     * 
     * @see Varien_Data_Collection_Db::getSize()
     */
    public function getSize()
    {
    	$sql = 'select count(entity_id) as cnt from ('.$this->getSelect()->reset(Zend_Db_Select::LIMIT_COUNT)->__toString().') as sub';
    	$res = $this->getConnection()->fetchAll($sql);
    	//die($sql);
    	//var_dump($res);
    	if (count($res)>0) {
    		return $res[0]['cnt'];
    	}
    	
    	return 0;
    }
    
    /**
     * Initialisiert die Filter
     * 
     * @return Egovs_Extreport_Model_Mysql4_Customer_Activity_Collection
     * 
     * @see Mage_Eav_Model_Entity_Collection_Abstract::_beforeLoad()
     */
	protected function _beforeLoad()
    {        	
        if ($this->_subscriberfilter != null) {
        	$this->getSelect()->where("subscriber_status=".$this->_subscriberfilter);
        	unset($this->_subscriberfilter);
        }
        
        if ($this->_customersincefilter != null) {
        	//var_dump($this->_customersincefilter);
        	$this->__addDateFilter('e.created_at', $this->_customersincefilter);
        	unset($this->_customersincefilter);
        }
        
        if ($this->_lastloginfilter != null) {
        	//var_dump($this->_customersincefilter);
        	$this->__addDateFilterExpression('last_login', $this->_lastloginfilter);
        	unset($this->_lastloginfilter);
        }
        
        if ($this->_lastorderfilter != null) {
        	//var_dump($this->_customersincefilter);
        	$this->__addDateFilterExpression('last_order', $this->_lastorderfilter);
        	unset($this->_lastorderfilter);
        }
        
        //die($this->getSelect()->__toString());
        return parent::_beforeLoad();
    }
   
 	/**
 	 * Fügt den Datumsfilter hinzu
 	 * 
 	 * @param string $field  Name
 	 * @param mixed  $filter Filter
 	 * 
 	 * @return void
 	 */
    private function __addDateFilter($field, $filter)
    {
    	$from = null;
    	$to = null;
    	if (isset($filter['from'])) $from = $filter['from']->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
    	if (isset($filter['to'])) $to = $filter['to']->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
    	if (($to != null)&&($from != null)) {
    		$this->getSelect()->where(" $field BETWEEN '$from' AND '$to' ");
    	} elseif ($to != null) {
    		$this->getSelect()->where(" $field < '$to' ");
    	} elseif ($from != null) {
    		$this->getSelect()->where(" $field > '$from' ");
    	}
    }
    
    /**
     * Fügt den Datumsfilter hinzu
 	 * 
 	 * @param string $field  Name
 	 * @param mixed  $filter Filter
 	 * 
 	 * @return void
     */
    private function __addDateFilterExpression($field, $filter)
    {
    	$from = null;
    	$to = null;
    	if (isset($filter['from'])) $from = $filter['from']->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
    	if (isset($filter['to'])) $to = $filter['to']->toString(Varien_Date::DATETIME_INTERNAL_FORMAT);
    	if (($to != null)&&($from != null)) {
    		$this->getSelect()->having(" $field BETWEEN '$from' AND '$to' ");
    	} elseif ($to != null) {
    		$this->getSelect()->having(" $field < '$to' ");
    	} elseif ($from != null) {
    		$this->getSelect()->having(" $field > '$from' ");
    	}        	
    } 
}