<?php
/**
 * Bfr Mach
 * 
 * 
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Helper_Data
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Helper_Data extends Mage_Core_Helper_Abstract
{
	private $_Dirname = 'mach_export';
	
	public function clearDirectory()
	{
		$path = Mage::getBaseDir('media') . DS . $this->_Dirname . DS;
			
			try {
			if (!is_dir($path)) {
                if (!mkdir($path) && !is_dir($path)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
                }
			}
			
			$handle=opendir($path);
			while($data=readdir($handle))
			{
				if(!is_dir($data) && $data!="." && $data!="..") unlink($data);
			}
			closedir($handle);
			
		} catch(Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($helper->__($e->getMessage()));
		}
	}
	
	public function saveFile($filename, $content)
	{
		$path = Mage::getBaseDir('media') . DS . $this->_Dirname . DS;
			
		try {
			if (!is_dir($path)) {
                if (!mkdir($path) && !is_dir($path)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $path));
                }
			}
			
			$datei = fopen($path.$filename, 'wb');
			fwrite($datei, $content);
			fclose($datei);
			
			
		} catch(Exception $e) {
			Mage::getSingleton('adminhtml/session')->addError($helper->__($e->getMessage()));
		}
	}
}