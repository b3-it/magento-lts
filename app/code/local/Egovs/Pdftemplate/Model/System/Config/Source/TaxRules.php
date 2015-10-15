<?php
/**
 *
 *  Definition für GridFilter
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
/**
 * Used in creating options for Yes|No config value selection
 *
 */
class Egovs_Pdftemplate_Model_System_Config_Source_TaxRules
{

    /**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
    	$collection = Mage::getSingleton('tax/calculation_rule')->getCollection();
    		
    	$res = array();
    	
    	foreach($collection->getItems() as $item)
    	{
    		$res[] = array('value' => $item->getId(), 'label'=>$item->getCode());
    	}
    		
    	
        return $res;
    }
    
    public function toOptionHashArray()
    {
    	$collection = Mage::getSingleton('tax/calculation_rule')->getCollection();
    
    	$res = array();
    	 
    	foreach($collection->getItems() as $item)
    	{
    		$res[$item->getId()] = $item->getCode();
    	}
    
    	 
    	return $res;
    }

}
