<?php

/**
 * 
 *  Definition der Template Typen
 *  @category Egovs
 *  @package  Egovs_Pdftemplate
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Pdftemplate_Model_Type extends Varien_Object
{
    const TYPE_INVOICE	= 'invoice';
    const TYPE_CREDITMEMO	= 'creditmemo';
    const TYPE_DELIVERYNOTE	= 'deliverynote';
    const TYPE_SEPAMANDAT	= 'sepamandat';

    
    
    
    static public function getConfigTypes()
    {
    	$res = Mage::getConfig()->getNode('global/pdftemplate/types')->asArray();
    	return $res;
    }
    
    
    /**
     * Options getter
     *
     * @return array
     */
    static public function getOptionArray()
    {
    	$res = self::getConfigTypes();
    	
    	foreach($res as $k=>$v)
    	{
    		$res[$k] =  Mage::helper('pdftemplate')->__($v);
    	}
    	
    	return $res;
    }
    
  
}