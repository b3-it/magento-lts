<?php
/**
 * Bfr Mach
 *
 *
 * @category   	Bfr
 * @package    	Bfr_Mach
 * @name       	Bfr_Mach_Model_History
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_Mach_Model_Export extends Mage_Core_Model_Abstract
{
	
	private $_Dirname = 'mach_export';
	private $_Lauf = 0;
	
	
	/**
	 * Daten für die Bestellungen abrufen und in ein temp Verzeichniss speichern
	 * @param array $orderIds
	 */
    public function saveData($orderIds)
    {
    	$this->_clearDirectory();
    	
    	$this->_Lauf = Mage::getModel('bfr_mach/history')->getResource()->getLastLauf() + 1;
    	
    	$model = Mage::getModel('bfr_mach/export_head');
    	$content = $model->getData4Order($orderIds, $this->_Lauf);
    	//$fileName = date('d_m_Y').'_kopf.csv';
    	$fileName = $this->_Lauf . '_kopf.csv';
    	
    	$this->_saveFile($fileName, $content);
    	$model->saveHistory($this->_Lauf);
    	
    	$model = Mage::getModel('bfr_mach/export_pos');
    	$content = $model->getData4Order($orderIds, $this->_Lauf);
    	$fileName = $this->_Lauf . '_pos.csv';
    	$this->_saveFile($fileName, $content);
    	$model->saveHistory($this->_Lauf);
    	
    	$model = Mage::getModel('bfr_mach/export_mapping');
    	$content = $model->getData4Order($orderIds, $this->_Lauf);
    	$fileName = $this->_Lauf . '_zuordnung.csv';
    	$this->_saveFile($fileName, $content);
    	$model->saveHistory($this->_Lauf);
    }
    
    
    public function getLauf()
    {
    	return $this->_Lauf;
    }
    
    /**
     * Die Daten anhand des Laufes von der Platte laden
     * @param string $lauf
     * @param Bfr_Mach_Model_ExportType $exportType
     */
    public function loadData($lauf, $exportType)
    {
    	$fileName = null;
    	switch ($exportType)
    	{
    		case Bfr_Mach_Model_ExportType::TYPE_KOPF: $fileName = $lauf . '_kopf.csv'; break;
    		case Bfr_Mach_Model_ExportType::TYPE_POSITION: $fileName = $lauf . '_pos.csv'; break;
    		case Bfr_Mach_Model_ExportType::TYPE_ZUORDNUNG: $fileName = $lauf . '_zuordnung.csv'; break;
    	}
    	
    	if(!$fileName){
    		Mage::throwException('Exporttype not found!');
    	}
    	
    	$path = Mage::getBaseDir('tmp') . DS . $this->_Dirname . DS;
    	
    	
    	
    	return file_get_contents($path.$fileName);
    	
    }
    
    
    public function updateHistory($lauf, $exportType)
    {
    	Mage::getModel('bfr_mach/history')->getResource()->updateHistory($exportType, $lauf);
    }
    
    
    private function _clearDirectory()
    {
    	$path = Mage::getBaseDir('tmp') . DS . $this->_Dirname . DS;
    		
    	try {
    		if (!is_dir($path)) {
    			mkdir($path);
    		}
    			
    		$handle=opendir($path);
    		while($data=readdir($handle))
    		{
    			if(!is_dir($path.$data) && $data!="." && $data!="..") unlink($path.$data);
    		}
    		closedir($handle);
    			
    	} catch(Exception $e) {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bfr_mach')->__($e->getMessage()));
    	}
    }
    
    private function _saveFile($filename, $content)
    {
    	$path = Mage::getBaseDir('tmp') . DS . $this->_Dirname . DS;
    		
    	try {
    		if (!is_dir($path)) {
    			mkdir($path);
    		}
    			
    		$datei = fopen($path.$filename,"w");
    		fwrite($datei, $content);
    		fclose($datei);
    			
    			
    	} catch(Exception $e) {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('bfr_mach')->__($e->getMessage()));
    	}
    }
    
    
}
