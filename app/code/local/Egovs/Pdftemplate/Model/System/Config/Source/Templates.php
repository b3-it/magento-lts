<?php
/**
 * 
 *  Definition für Gridfilter 
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_System_Config_Source_Templates
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	$collection = Mage::getSingleton('pdftemplate/template')->getCollection();
    	$collection->getSelect()->where('status='.Egovs_Pdftemplate_Model_Status::STATUS_ENABLED);
    	
    	$res = array();
    	
    	foreach($collection->getItems() as $item)
    	{
    		$res[] = array('value' => $item->getId(), 'label'=>$item->getTitle());
    	}
    		
    	
        return $res;
    }

}
