<?php
/**
 * Downloadable link file model
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Model_Link_File extends Mage_Core_Model_Abstract
{
    /**
     * Initialize resource model
     * 
     * @return void
     */
    protected function _construct() {
        $this->_init('configdownloadable/link_file');

        parent::_construct();
    }
    
    /**
     * Load link file by filename
     *
     * @param string $linkFileName Dateiname (relative Pfadangabe möglich)
     * 
     * @return Dwd_ConfigurableDownloadable_Model_Link_File
     */
    public function loadByFilename($linkFileName) {
    	$this->_getResource()->loadByFilename($this, $linkFileName);
    	return $this;
    }
    
    /**
     * Erhöht den Zähler für Dateien in Benutzung
     *
     * @param int $amount Anzahl
     * 
     * @return Dwd_ConfigurableDownloadable_Model_Link_File
     */
    public function increase($amount = 1) {
    	$numberInUse = 0;
    	if ($this->hasNumberInUse()) {
    		$numberInUse = $this->getNumberInUse();
    	}
    	$amount = max(1, $amount);
    	$numberInUse += $amount;
    	$this->setNumberInUse($numberInUse);
    	
    	return $this;
    }
    
    /**
     * Reduziert den Zähler für Dateien in Benutzung
     *
     * @param int $amount Anzahl
     * 
     * @return Dwd_ConfigurableDownloadable_Model_Link_File
     */
    public function decrease($amount = 1) {
    	$numberInUse = 0;
    	if ($this->hasNumberInUse()) {
    		$numberInUse = $this->getNumberInUse();
    	}
    	$numberInUse -= $amount;
    	$numberInUse = max(0, $numberInUse);
    	$this->setNumberInUse($numberInUse);
    	 
    	return $this;
    }
    
    /**
     * Löscht die Datei
     * 
     * @return Dwd_ConfigurableDownloadable_Model_Link_File
     */
    public function deleteFile() {
    	$ioObject = new Varien_Io_File();
    	
    	$destDirectory = dirname(Mage_Downloadable_Model_Link::getBasePath().$this->getLinkFile());
    	$destFile = basename(Mage_Downloadable_Model_Link::getBasePath().$this->getLinkFile());
    	try {
    		$ioObject->open(array('path'=>$destDirectory));
    	} catch (Exception $e) {
    		return $this;
    	}
    	
    	$ioObject->rm($destFile);
    	return $this;
    }
}
