<?php

class Sid_Framecontract_Model_Files extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('framecontract/files');
    }
    
    
   	protected function _beforeDelete()
    {
    	$path = Mage::getBaseDir('media') . DS . 'framecontract' . DS ;
    	$path .= $this->getFilename();
    	if(file_exists($path))
    	{
    		unlink($path);
    	}
    	
    	return parent::_beforeDelete();
    }
    
    public function getDiskFilename()
    {
    	$path = Mage::getBaseDir('media') . DS . 'framecontract' . DS ;
    	$path .= $this->getFilename();
    	return $path;
    }
}