<?php
/**
 * Egovs Isolation
 * 
 * 
 * @category   	Egovs
 * @package    	Egovs_Isolation
 * @name       	Egovs_Isolation_IndexController
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
    	
    	/*
    	 * Load an object by id 
    	 * Request looking like:
    	 * http://site.com/isolation?id=15 
    	 *  or
    	 * http://site.com/isolation/id/15 	
    	 */
    	/* 
		$isolation_id = $this->getRequest()->getParam('id');

  		if($isolation_id != null && $isolation_id != '')	{
			$isolation = Mage::getModel('isolation/isolation')->load($isolation_id)->getData();
		} else {
			$isolation = null;
		}	
		*/
		
		 /*
    	 * If no param we load a the last created item
    	 */ 
    	/*
    	if($isolation == null) {
			$resource = Mage::getSingleton('core/resource');
			$read= $resource->getConnection('core_read');
			$isolationTable = $resource->getTableName('isolation');
			
			$select = $read->select()
			   ->from($isolationTable,array('isolation_id','title','content','status'))
			   ->where('status',1)
			   ->order('created_time DESC') ;
			   
			$isolation = $read->fetchRow($select);
		}
		Mage::register('isolation', $isolation);
		*/

			
		$this->loadLayout();     
		$this->renderLayout();
    }
}