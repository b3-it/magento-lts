<?php
/**
 * 
 *  TODO:: -- DOKU -- kurze Beschreibung einfügen
 *  @category B3it
 *  @package  B3it_Messagequeue_Model_Email_Status
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class B3it_Messagequeue_Model_Email_Status extends Varien_Object
{
    const STATUS_NEW	= 0;
    const STATUS_SENDING	= 1;
    const STATUS_FINISHED	= 2;

    static public function getOptionArray()
    {
        return array(
            self::STATUS_NEW    => Mage::helper('infoletter')->__('Neu'),
            self::STATUS_SENDING   => Mage::helper('infoletter')->__('Sending'),
            self::STATUS_FINISHED   => Mage::helper('infoletter')->__('Finished')
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
    	/*
    	$res = array(
    			array(
    					'value' => '',
    					'label' => Mage::helper('infoletter')->__('-- Please Select --')
    			)
    	);
    	*/
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