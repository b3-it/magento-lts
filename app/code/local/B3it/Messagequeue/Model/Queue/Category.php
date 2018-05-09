<?php

/**
 * 
 *  Kategorie der Regel
 *  @category B3it
 *  @package  B3it_Messagequeue_Model_Queue_Status
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Queue_Category extends Varien_Object
{
    protected $_options = null;
    
   
    public function getOptionArray(){
    	if($this->_options == null)
    	{
    		$this->_options = array();
	    	$opt = Mage::getConfig()->getNode('global/b3it_messagequeue/category')->asArray();
	    	
	    	foreach($opt as $k=>$v)
	    	{
	    		$this->_options[$k] = Mage::helper('b3it_mq')->__($v['label']);
	    	}
    	}
    
    	return $this->_options;
    }
}