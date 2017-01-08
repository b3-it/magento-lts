<?php
/**
 * 
 *  Liste der ferfügbaren Composits als Array
 *  @category Egovs
 *  @package  Bkg_Viewer_Model_Entity_Attribute_Source_Geocomposit
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */


class Bkg_Viewer_Model_Entity_Attribute_Source_Geocomposit extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
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
        	$collection = Mage::getModel('bkgviewer/composit_composit')->getCollection();
        	
        	foreach ($collection->getItems() as $item)
        	{
        		$this->_options[] = array(
                    'label' => $item->getTitle(),
                    'value' => $item->getId()
                );
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
