<?php
/**
 * Dwd Ibewi Reports
 *
 *
 * @category   	Dwd Icd
 * @package    	Dwd_Icd
 * @name        Dwd_Icd_Model_Entity_Attribute_Source_Appications
 * @author 		Holger Kögel <hkoegel@edv-beratung-hempel.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */

class Dwd_Icd_Model_Source_Attribute_Applications extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public function getAllOptions()
    {
        if (is_null($this->_options)) 
        {
        	$this->_options = array();
        	$this->_options[] = array(
                    'label' =>'',
                    'value' =>''
                );
                
        	$einheiten = Mage::getConfig()->getNode('global/applications')->asArray();
        	
        	if(is_array($einheiten))
        	{
	        	
	        	foreach($einheiten as $k=>$v)
	        	{
	        		$this->_options[] = array(
	                    'label' =>$v['label'],
	                    'value' =>$k
	                );
	        	}
	        	
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
            $_options[$option['value']] = $option['label'];
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
