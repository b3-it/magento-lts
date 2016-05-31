<?php
/**
 * Bfr EventRequest
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventRequest
 * @name       	Bfr_EventRequest_IndexController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventRequest_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/eventrequest?id=15 
    	 *  or
    	 * http://site.com/eventrequest/id/15 	
    	 */
    	/* 
		$eventrequest_id = $this->getRequest()->getParam('id');

  		if($eventrequest_id != null && $eventrequest_id != '')	{
			$eventrequest = Mage::getModel('eventrequest/eventrequest')->load($eventrequest_id)->getData();
		} else {
			$eventrequest = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($eventrequest == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$eventrequestTable = $resource->getTableName('eventrequest');
			
			$select = $read->select()
			   ->from($eventrequestTable,array('eventrequest_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$eventrequest = $read->fetchRow($select);
		}
		Mage::register('eventrequest', $eventrequest);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}