<?php
/**
 * Verwalten von Dokumenten im Webshop.
 *
 * @category	Egovs
 * @package		Egovs_Doc
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright	Copyright (c) 2014 B3 IT Systeme GmbH
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Doc_Model_Category extends Varien_Object
{
    /**
     * Retrieve all options array
     *
     * @return array
     */
    public static function getAllOptions()
    {
        //if (is_null($this->_options)) 
        {
        	$_options = array();
        	/*
        	$_options[] = array(
                    'label' =>'',
                    'value' =>''
                );
             */   
        	$einheiten = Mage::getConfig()->getNode('global/egovs_doc/categories')->asArray();
        	
        	if(is_array($einheiten))
        	{
	        	
	        	foreach($einheiten as $k=>$v)
	        	{
	        		$_options[] = array(
	                    'label' =>$v['label'],
	                    'value' =>$k
	                );
	        	}
	        	
        	}
        }
        return $_options;
    }

    /**
     * Retrieve option array
     *
     * @return array
     */
    public static function getOptionArray()
    {
        $_options = array();
        foreach (self::getAllOptions() as $option) {
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
    public static function getOptionText($value)
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