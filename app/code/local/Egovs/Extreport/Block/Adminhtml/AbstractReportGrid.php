<?php

/**
 * Abstracktes Adminhtml Report Grid
 *
 * @category   	Egovs
 * @package    	Egovs_Extreport
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
abstract class Egovs_Extreport_Block_Adminhtml_AbstractReportGrid extends Mage_Adminhtml_Block_Report_Grid
{
	protected $_baseActionName = '';
	
	/**
	 * Setz zusätzliche Parameter für Reports
	 * 
	 * <ul>
	 *  <li>Parameter in Session sichern</li>
	 *  <li>AJAX benutzen</li>
	 * </ul>
	 * 
	 * @return void
	 *  
	 */
    public function __construct()
    {
        parent::__construct();
       
        $this->setSaveParametersInSession(true);
        $this->setUseAjax(true);
    }
	
    /**
     * Liefert den Store zurück
     * 
     * @return Mage_Core_Model_Store>
     */
	protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }
    
    /**
     * Liefert die URL für AJAX Grid Actions
     * 
     * @return string
     */
    public function getGridUrl()
    {
    	//syntax: module/controller/action
    	if ($this->_baseActionName && strlen($this->_baseActionName) > 0) {
        	return $this->getUrl('*/*/grid', array('_current'=>true, 'action'=>$this->_baseActionName));
    	}
    	
    	return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}