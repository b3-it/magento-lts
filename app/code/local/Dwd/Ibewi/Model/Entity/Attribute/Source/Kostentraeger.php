<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Ibewi
 * @package    	Dwd_Ibewi
 * @name        Dwd_Ibewi_Model_Entity_Attribute_Source_Kostentraeger
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Dwd_Ibewi_Model_Entity_Attribute_Source_Kostentraeger extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Retrieve all options array
     *
     * @return array
     */
	public function getAllOptions()
    {
        if (is_null($this->_options)) {
        	$this->_options = array();
        	//$options = Mage::getConfig()->getNode('shipment_groups')->asArray();
        	
            $ship = Mage::getModel('ibewi/kostentraeger_attribute')->getCollection();
            $ship->getSelect()->order('pos');
            $this->_options[] = array( 'label' =>Mage::helper('ibewi')->__('-- Please Select --'), 'value' =>'');
            foreach($ship->getItems() as $value)        	{
        		$this->_options[] = array( 'label' =>$value->getTitle(), 'value' => $value->getValue());
        	}
          
        }
        return $this->_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public function getOptionArray()
    {
        $_options = array();
        foreach ($this->getAllOptions() as $option) {
           // $_options[$option['value']] = $option['label'];
        }
        return $_options;
    }

    /**
     * Get a text for option value
     *
     * @param string|integer $value
     * @return string
     */
    public function getOptionText($value)
    {
        $options = $this->getAllOptions();
        foreach ($options as $option) {
            if ($option['value'] == $value) {
                return $option['label'];
            }
        }
        return false;
    }

    
}
