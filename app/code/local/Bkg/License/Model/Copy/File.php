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
    	if(stlen($this->getData('hash_filename')) > 1){
    		$str = bin2hex(random_bytes(8)).$this->getOrigFilename();
    		$this->setData('hash_filename',md5($str));
    	}
    	return $this->getData('hash_filename');
    }
    
 
}
