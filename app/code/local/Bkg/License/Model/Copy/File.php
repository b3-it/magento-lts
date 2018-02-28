<?php
/**
 *
 * @category   	Bkg License
 * @package    	Bkg_License
 * @name       	Bkg_License_Model_File
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Model_Copy_File extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('bkg_license/copy_file');
    }
    

    public function getHashFilename()
    {
    	if(strlen($this->getData('hash_filename')) < 5){
    		$str = bin2hex(openssl_random_pseudo_bytes(18)).$this->getOrigFilename().time();
    		$this->setData('hash_filename',md5($str));
    	}
    	return $this->getData('hash_filename');
    }
    
    protected function _beforeSave()
    {
    	if(!$this->getDoctype()){
    		$this->setDoctype(Bkg_License_Model_Copy_Doctype::TYPE_DRAFT);
    	}
    	return parent::_beforeSave();
    }
    
    protected function _beforeDelete()
    {
    	$path = Mage::helper('bkg_license')->getLicenseFilePath($this->getCopyId()).DS.$this->getHashFilename();
    	if(file_exists($path))
    	{
    		unlink($path);
    	}
    	return parent::_beforeDelete();
    }
}
