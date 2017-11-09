<?php
/**
 * Report Reviews collection with sortable periods
 * 
 * @category   Sid
 * @package    Sid_Report
 * @author 	   Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license	   http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_Report_Model_Mysql4_Report_Collection extends Mage_Reports_Model_Mysql4_Report_Collection
{
	/**
	 * Aufsteigende Sortierung
	 * @var string
	 */
	const SORT_ASC = 'asc';
	/**
	 * Absteigende Sortierung
	 * @var string
	 */
	const SORT_DESC = 'desc';
	
	/**
	 * Sort direction
	 * @var string
	 */
    protected $_direction = self::SORT_ASC;

    /**
     * Liefert die Einzelnen Intervalle
     * 
     * @return array
     * 
     * @see Mage_Reports_Model_Mysql4_Report_Collection::getIntervals()
     */
    public function getIntervals()
    {
    	if (!$this->_intervals) {
	    	parent::getIntervals();
	    	
	        if (is_array($this->_intervals)) {
	            if ($this->getDirection() != self::SORT_ASC) {
	            	//2010-03-12 Frank Rochlitzer
	            	//array_reverse interpretiert bei Jahresgruppierung die Jahreszahlen
	            	//als int und setzt diese wieder zurück - bei 0 beginnent
	            	//-> preserve keys muss true sein
	            		            	
            		$this->_intervals = array_reverse($this->_intervals, true);
	            }
	        }
    	}
        return  $this->_intervals;
    }
    
    /**
     * Liefert den kompletten Report
     * 
     * @param string $from Von Datum
     * @param string $to   Bis Datum
     * 
     * @return Mage_Core_Model_Mysql4_Abstract
     * 
     * @see Mage_Reports_Model_Mysql4_Report_Collection::getReportFull()
     */
	public function getReportFull($from, $to) {
    	$report = parent::getReportFull($from, $to);
    	
    	if ($this->_createdAtExists($report)) {
    		$report->setOrder('created_at', $this->getDirection());
    	}
    	
        return $report;
    }

    /**
     * Liefert den Report
     *
     * @param string $from Von Datum
     * @param string $to   Bis Datum
     *
     * @return Mage_Core_Model_Mysql4_Abstract
     *
     * @see Mage_Reports_Model_Mysql4_Report_Collection::getReport()
     */
    public function getReport($from, $to)
    {
        $report = parent::getReport($from, $to);
    	
    	if ($this->_createdAtExists($report)) {
    		$report->setOrder('created_at', $this->getDirection());
    	}
    	
        return $report;
    }
    
    /**
     * Prüft ob das Feld 'created_at' in der Tabelle existiert.
     * 
     * @param Mage_Reports_Model_Mysql4_Report_Collection $report Report
     * 
     * @return boolean
     */
    protected function _createdAtExists($report) {
    	$createdAtExists = false;
    	if ($report) {
    		$columns = $report->getSelect()->getPart(Zend_Db_Select::COLUMNS);
    		
    		if (!isset($columns)) {
    			return $createdAtExists;
    		}
    		
    		if (is_array($columns)) {
    			foreach ($columns as $col) {
    				if (!is_array($col)) {
    					continue;
    				}
    				
    				if (count($col) != 3) {
    					continue;
    				}
    				
    				if ($col[1] == 'created_at') {
    					$createdAtExists = true;
    				}
    			}
    		}    		
    	}
    	
    	return $createdAtExists;
    }
    
    /**
     * Ändert die aktuelle Sortierung des Zeitraums zu $dir.
     * 
     * @param string $dir Sortierrichtung
     * 
     * @return string Aktuelle Sortierung
     * 
     * @see getDirection()
     */
    public function setDirection($dir = self::SORT_ASC) {
    	if ($dir == self::SORT_DESC) {
    		$this->_direction = self::SORT_DESC;
    	} else {
    		$this->_direction = self::SORT_ASC;
    	}
    	
    	return $this->_direction;
    }
    
    /**
     * Liefert die aktuelle Sortierreihenfolge des Zeitraums.
     * 
     * @return string
     */
    public function getDirection() {
    	return $this->_direction;
    }
    
	/**
     * Liefert die Sortierarten für Zeitraum
     *
     * @return array
     */
    public function getSortPeriods()
    {
        return array(
            'asc'=>Mage::helper('sidreport')->__('Ascending'),
            'desc'=>Mage::helper('sidreport')->__('Descending')
        );
    }    
    
    /**
     * Setzt den Kategorienfilter
     * 
     * @param Mage_Core_Model_Input_Filter $filter Filter
     * 
     * @return void
     */
	public function setCategoryFilter($filter)
    {
    	$this->_model->getReportModel()->setCategoryFilter($filter);
    }
    /**
     * Setzt den Haushaltstellenfilter
     *
     * @param Mage_Core_Model_Input_Filter $filter Filter
     *
     * @return void
     */
	public function setHaushaltsstelleFilter($filter)
    {
    	$this->_model->getReportModel()->setHaushaltsstelleFilter($filter);
    }

    
    public function getReportModel()
    {
    	return $this->_model->getReportModel();
    }
}
