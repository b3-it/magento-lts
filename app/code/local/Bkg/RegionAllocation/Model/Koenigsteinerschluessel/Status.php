<?php
/**
 *
 * @category   	Bkg Regionallocation
 * @package    	Bkg_Regionallocation
 * @name       	Bkg_Regionallocation_Model_Koenigsteinerschluessel_Status
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_RegionAllocation_Model_Koenigsteinerschluessel_Status extends Varien_Object
{
    const STATUS_ACTIVE	= 1;
    const STATUS_INACTIVE		= 2;


    static public function getOptionArray()
    {
        return array(
            self::STATUS_ACTIVE    => Mage::helper('regionallocation')->__('Active'),
            self::STATUS_INACTIVE   => Mage::helper('regionallocation')->__('Inactive'),
        );
    }
    
    
    
    
    
    /**
     * Retrieve option array with empty value
     *
     * @return array
     */
    static public function getAllOptions()
    {
    	$res = array(
    			array(
    					'value' => '',
    					'label' => Mage::helper('regionallocation')->__('-- Please Select --')
    			)
    	);
    	foreach (self::getOptionArray() as $index => $value) {
    		$res[] = array(
    					'value' => $index,
    					'label' => $value
    			);
    		}
    	
    	return $res;
    }
}