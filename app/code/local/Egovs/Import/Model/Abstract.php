<?php

class Egovs_Import_Model_Abstract  extends Varien_Object
{
	private $_config;
    
	public function getAdapter($sourcetype)
	{
		return $this;
	}
	
	
	public function import($config)
	{
		$this->_config = $config;
		
		
		return $this;
	}
 
}
    
