<?php
/**
 * Bfr EventManager
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_IndexController
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/eventmanager?id=15 
    	 *  or
    	 * http://site.com/eventmanager/id/15 	
    	 */
    	/* 
		$eventmanager_id = $this->getRequest()->getParam('id');

  		if($eventmanager_id != null && $eventmanager_id != '')	{
			$eventmanager = Mage::getModel('eventmanager/eventmanager')->load($eventmanager_id)->getData();
		} else {
			$eventmanager = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($eventmanager == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$eventmanagerTable = $resource->getTableName('eventmanager');
			
			$select = $read->select()
			   ->from($eventmanagerTable,array('eventmanager_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$eventmanager = $read->fetchRow($select);
		}
		Mage::register('eventmanager', $eventmanager);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}