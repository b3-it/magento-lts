<?php
/**
 *  Statusklasse für ExportOrder
 *  @category Sid
 *  @package  Sid_ExportOrder
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 
class Sid_Cms_Model_SendMode extends Varien_Object
{
    const MODE_NONE	= 0;
    const MODE_NOW	= 1;
    const MODE_QUEUE= 2;
    
    static public function getOptionArray()
    {
    	return array(
    			self::MODE_NONE    => Mage::helper('sidcms')->__('None'),
    			self::MODE_NOW   => Mage::helper('sidcms')->__('Send now'),
    			self::MODE_QUEUE   => Mage::helper('sidcms')->__('Create Queue only'),
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
    
    
    
    static public function getAllOptions()
    {
    	
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