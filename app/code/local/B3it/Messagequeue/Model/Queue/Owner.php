<?php

/**
 * 
 *  Bearbeiter
 *  @category B3it
 *  @package  B3it_Messagequeue_Model_Queue_Owner
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Queue_Owner extends Varien_Object
{
    protected $_options = null;
    
   
    public function getOptionArray(){
    	if($this->_options == null)
    	{
    		$this->_options = array();
    		$this->_options[0] = '';
	    	$opt = Mage::getModel('admin/user')->getCollection();
	    	
	    	foreach($opt as $k=>$v)
	    	{
	    		$this->_options[$k] = $v->getName();
	    	}
    	}
    
    	return $this->_options;
    }
}