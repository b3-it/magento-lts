<?php
/**
 * 
 *  Sourcemodel mit gefiterten Stores in Abhängigkeit der Rechte der Bearbeiter 
 *  @category Egovs
 *  @package  Egovs_Isolation
 *  @author Frank Rochlitzer <​f.rochlitzer@b3-it.de>
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Egovs_Isolation_Model_Entity_Attribute_Source_Storegroups extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
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
        	$helper  = Mage::helper('isolation');
        	$storeGroups = $helper->getUserStoreGroups();
        	$this->_options = array();
        	
        	if($helper->getUserIsAdmin())
        	{
	        	$this->_options[] = array(
	                    'label' =>$helper->__('not assigned to special store'),
	                    'value' =>'0'
	                );
        	}
        	$collection = Mage::getModel('adminhtml/system_store')->getGroupCollection();
        	
        	foreach ($collection as $item)
        	{
        		if($storeGroups)
        		{
	        		if(in_array($item->getId(), $storeGroups))
	        		{
		        		$this->_options[] = array(
		                    'label' => $item->getName(),
		                    'value' => $item->getId()
		                );
	        		}
        		}else
        		{
        			$this->_options[] = array(
        					'label' => $item->getName(),
        					'value' => $item->getId()
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
    public function getOptionArray($appendEmpty = false)
    {
        $_options = array();
        $allOptions = $this->getAllOptions();
        if($appendEmpty){
        	$_options[''] = Mage::helper('isolation')->__('-- Please Select a Store --');
        	$helper  = Mage::helper('isolation');
        	if($helper->getUserIsAdmin())
        	{
        		array_shift($allOptions);
        	}
        }
        foreach ($allOptions as $option) {
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
