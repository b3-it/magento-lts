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
    /**
     * Ermittelt alle zum Store/Haldels enthalten CMS-Blöcke
     * 
     * @return NULL|array[]
     */
    public function getContentUrls()
    {
    	$handles = $this->getLayout()->getUpdate()->getHandles();
    	if(count($handles) == 0){
    		return null;
    	}

    	$storeid = intval( Mage::app()->getStore()->getId() );
    	if ( !$storeid ) {
    	    return null;
    	}

        /**
         * @var $collection Egovs_ContextHelp_Model_Resource_Contexthelphandle_Collection
         */
        $collection = Mage::getModel('contexthelp/contexthelphandle')->getCollection();

    	$collection->getSelect()
                   ->join(
                         array('contexthelp' => $collection->getTable('contexthelp/contexthelp')),
                         'FIND_IN_SET(' . $storeid . ', `store_ids`) AND `main_table`.`parent_id` = `contexthelp`.`id`',
                         array()
                     )
                   ->where('handle IN (?)', $handles);

        $isSecure = Mage::app()->getStore()->isCurrentlySecure();
        $urls = array();
    	foreach($collection->getItems() as $item){
    	    $urls[] = $this->getUrl(
    	                  'contexthelp/index/index/',
    	                  array(
    	                      'id'      => $item->getParentId(),
    	                      '_secure' => $isSecure
    	                  )
    	              );
    	}

    	return $urls;
    }
}
