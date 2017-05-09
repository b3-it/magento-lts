<?php
/**
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category Gka
 *  @package  Gka_UserStore
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Gka_UserStore_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/userstore?id=15 
    	 *  or
    	 * http://site.com/userstore/id/15 	
    	 */
    	/* 
		$userstore_id = $this->getRequest()->getParam('id');

  		if($userstore_id != null && $userstore_id != '')	{
			$userstore = Mage::getModel('userstore/userstore')->load($userstore_id)->getData();
		} else {
			$userstore = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($userstore == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$userstoreTable = $resource->getTableName('userstore');
			
			$select = $read->select()
			   ->from($userstoreTable,array('userstore_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$userstore = $read->fetchRow($select);
		}
		Mage::register('userstore', $userstore);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}