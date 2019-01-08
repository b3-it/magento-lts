<?php
/**
 * 
 *  Status der Übertragung der Bestellung zum Lieferanten
 *  @category Egovs
 *  @package  Sid_Export_Order_Model_Syncstatus
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Sid_ExportOrder_Model_Syncstatus extends Varien_Object
{
    const SYNCSTATUS_PENDING			= 1;
    const SYNCSTATUS_SUCCESS			= 2;
    const SYNCSTATUS_ERROR				= 3;
    const SYNCSTATUS_PERMANENTERROR		= 4;
    const SYNCSTATUS_PROCESSING		= 5;

    static public function getOptionArray()
    {
        return array(
            self::SYNCSTATUS_PENDING    => Mage::helper('exportorder')->__('Pending'),
            self::SYNCSTATUS_SUCCESS   => Mage::helper('exportorder')->__('Success'),
        	self::SYNCSTATUS_ERROR   => Mage::helper('exportorder')->__('Error'),
        	self::SYNCSTATUS_PROCESSING   => Mage::helper('exportorder')->__('Processing'),
        	//self::SYNCSTATUS_PERMANENTERROR   => Mage::helper('exportorder')->__('Permanent Error')
        );
    }
    
    /**
     * Retrieve option array with empty value
     *
     * @return array
     */
    static public function getAllOption()
    {
    	$options = self::getOptionArray();
    	array_unshift($options, array('value'=>'', 'label'=>''));
    	return $options;
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
    					'label' => Mage::helper('exportorder')->__('-- Please Select --')
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
    
    /**
     * Retrieve option text by option value
     *
     * @param string $optionId
     * @return string
     */
    static public function getOptionText($optionId)
    {
    	$options = self::getOptionArray();
    	return isset($options[$optionId]) ? $options[$optionId] : null;
    }
    
}