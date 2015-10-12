<?php
class Gitter_Smjshipment_Model_Backend_Config extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
	public function toOptionArray()
	{
		return array(Gitter_Smjshipment_Model_Smjshipment::Books=>Mage::helper('smjshipment')->__('Books (Group 3)'),
					Gitter_Smjshipment_Model_Smjshipment::Normal=>Mage::helper('smjshipment')->__('Normal (Group 2)'),
					Gitter_Smjshipment_Model_Smjshipment::Oversize=>Mage::helper('smjshipment')->__('Oversize (Group 1)'));
	}
	
   	public function getAllOptions()
    {
    	return $this->toOptionArray();
    }
    
    public function afterLoad()
    {
    	return $this;
    }
}