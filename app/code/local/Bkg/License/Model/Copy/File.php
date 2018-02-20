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
    
    public function getActionUrl()
    {
    	$id = Mage::registry('entity_data')->getId();
    	$debug = "";
    	//$debug = "&start_debug=1&debug_host=192.168.178.83%2C127.0.0.1&send_sess_end=1&debug_session_id=1000&debug_start_session=1&debug_no_cache=1385544095237&debug_port=10000";
    	return Mage::getModel('adminhtml/url')->addSessionParam()->getUrl('adminhtml/license_copy/upload',array('id'=>$id)).$debug;
    }
    
    public function getHashFilename()
    {
    	if(stlen($this->getData('hash_filename')) > 1){
    		$str = bin2hex(random_bytes(8)).$this->getOrigFilename();
    		$this->setData('hash_filename',md5($str));
    	}
    	return $this->getData('hash_filename');
    }
    
    public function getPostMaxSize()
    {
    	return ini_get('post_max_size');
    }
    
    public function getUploadMaxSize()
    {
    	return ini_get('upload_max_filesize');
    }
    
    public function getDataMaxSize()
    {
    	return min($this->getPostMaxSize(), $this->getUploadMaxSize());
    }
    
    public function getDataMaxSizeInBytes()
    {
    	$iniSize = $this->getDataMaxSize();
    	$size = substr($iniSize, 0, strlen($iniSize)-1);
    	$parsedSize = 0;
    	switch (strtolower(substr($iniSize, strlen($iniSize)-1))) {
    		case 't':
    			$parsedSize = $size*(1024*1024*1024*1024);
    			break;
    		case 'g':
    			$parsedSize = $size*(1024*1024*1024);
    			break;
    		case 'm':
    			$parsedSize = $size*(1024*1024);
    			break;
    		case 'k':
    			$parsedSize = $size*1024;
    			break;
    		case 'b':
    		default:
    			$parsedSize = $size;
    			break;
    	}
    	return $parsedSize;
    }
    
    /**
     * Retrive full uploader SWF's file URL
     * Implemented to solve problem with cross domain SWFs
     * Now uploader can be only in the same URL where backend located
     *
     * @param string url to uploader in current theme
     * @return string full URL
     */
    public function getUploaderUrl()
    {
    	 
    	$url = "uploadify.swf";
    	$design = Mage::getDesign();
    	$theme = $design->getTheme('skin');
    	if (empty($url) || !$design->validateFile($url, array('_type' => 'skin', '_theme' => $theme))) {
    		$theme = $design->getDefaultTheme();
    	}
    	return Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_SKIN) .
    	$design->getArea() . '/' . $design->getPackageName() . '/' . $theme . '/' . $url;
    }
 
}
