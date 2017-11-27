<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Gka
 *  @package  Gka_Reports
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_Reports_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/reports?id=15 
    	 *  or
    	 * http://site.com/reports/id/15 	
    	 */
    	/* 
		$reports_id = $this->getRequest()->getParam('id');

  		if($reports_id != null && $reports_id != '')	{
			$reports = Mage::getModel('reports/reports')->load($reports_id)->getData();
		} else {
			$reports = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($reports == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$reportsTable = $resource->getTableName('reports');
			
			$select = $read->select()
			   ->from($reportsTable,array('reports_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$reports = $read->fetchRow($select);
		}
		Mage::register('reports', $reports);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}