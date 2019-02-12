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
class Egovs_Doc_Model_Doc extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('egovs_doc/doc');
    }
    
    
    public function getFileIdentId()
    {    	
    	return md5(microtime(false).mt_rand(0,10000));
    }
    
    public function deleteFile()
    {
    	$filename = $path = Mage::getBaseDir('media') . DS . 'doc' . DS. $this->getSavefilename();
    	if (is_file($filename))
    	{
    		unlink($filename);
    	}
    }
    
    protected function _beforeDelete()
    {
    	$this->deleteFile();
    	return parent::_beforeDelete();
    }
    
    
}