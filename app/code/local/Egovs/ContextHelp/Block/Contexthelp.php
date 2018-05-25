<?php
/**
 *
 * @category   	Egovs ContextHelp
 * @package    	Egovs_ContextHelp
 * @name       	Egovs_ContextHelp_Block_Contexthelp
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_ContextHelp_Block_Contexthelp extends Mage_Core_Block_Template
{
    public function getContentUrls()
    {
    	$handles = $this->getLayout()->getUpdate()->getHandles();
    	if(count($handles) == 0){
    		return null;
    	}
    	
    	    	
    	$collection = Mage::getModel('contexthelp/contexthelphandle')->getCollection();
    	$collection->getSelect()->where('handle IN (?)',$handles);

    	$urls = array();    	
    	foreach($collection->getItems() as $item){
    		$urls[] = $this->getUrl('contexthelp/index/index/',array('id'=>$item->getParentId()));
    	}
    	
    	return $urls;
    	
    	
    }
    
    
}
