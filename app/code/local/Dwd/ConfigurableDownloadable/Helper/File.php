<?php
/**
 * Configurable Downloadable Products File Helper
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2012 - 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Helper_File extends Mage_Downloadable_Helper_File
{
    /**
     * Pürft Datei für Verschiebung und verschiebt diese
     *
     * @param string $baseTmpPath       Base Temp Pfad
     * @param string $basePath          Base Pfad
     * @param array  $file              Dateien
     * @param bool	 $replaceDuplicates Vorhandene Dateien ersetzen?
     * 
     * @return string
     */
    public function copyFileFromTmpWithDispretionPath($baseTmpPath, $basePath, $file, $replaceDuplicates) {
        if (isset($file[0])) {
            $fileName = $file[0]['file'];
            if ($file[0]['status'] == 'new') {
                try {
                    $fileName = $this->_copyFileFromTmpWithDispretionPath(
                        $baseTmpPath, $basePath, $file[0]['file'], $replaceDuplicates
                    );
                } catch (Exception $e) {
                    Mage::throwException(sprintf("%s:\n%s", Mage::helper('downloadable')->__('An error occurred while saving the file(s).'), $e->getMessage()));
                }
            }
            return $fileName;
        }
        return '';
    }

    /**
     * Verschiebt Datei von tmp Pfad nach base Pfad
     *
     * @param string $baseTmpPath       Base Temp Pfad
     * @param string $basePath          Base Pfad
     * @param array  $file              Dateien
     * @param bool	 $replaceDuplicates Vorhandene Dateien ersetzen?
     * 
     * @return string
     */
    protected function _copyFileFromTmpWithDispretionPath($baseTmpPath, $basePath, $file, $replaceDuplicates) {
        $ioObject = new Varien_Io_File();
        
        //Unterstützung für Subfolders in $file
        $dirPartFromFile = dirname($file);
        //Falls $file ohne Verzeichnis kommt
        if ($dirPartFromFile == '.') {
        	$dirPartFromFile = '';
        } else {
        	$baseTmpPath .= $dirPartFromFile.$ioObject->dirsep();
        	$dirPartFromFile = $ioObject->dirsep().$dirPartFromFile;
        }
        $file = basename($file);
        
        
        //Beginnt immer mit directory separator ('/')
        $destDispretionPath = Mage_Core_Model_File_Uploader::getDispretionPath($file);
        $destDispretionPath .= $dirPartFromFile;
        $destDirectory = dirname($this->getFilePath($basePath.$destDispretionPath, $file));
        try {
            $ioObject->open(array('path'=>$destDirectory));
        } catch (Exception $e) {
            $ioObject->mkdir($destDirectory, 0777, true);
            $ioObject->open(array('path'=>$destDirectory));
        }

        if (strrpos($file, '.tmp') == strlen($file)-4) {
            $file = substr($file, 0, strlen($file)-4);
        }

        $srcFileModTime = filemtime($this->getFilePath($baseTmpPath, $file));
        if ($ioObject->fileExists($this->getFilePath($basePath.$destDispretionPath, $file))
        		&& filemtime($this->getFilePath($basePath.$destDispretionPath, $file)) == $srcFileModTime
        ) {
        	return str_replace($ioObject->dirsep(), '/', $this->getFilePath($destDispretionPath, $file));
        }
        
        if ($replaceDuplicates) {
        	$destFile = $destDispretionPath . $ioObject->dirsep() . $file;
        } else {
        	//Erzeugt einen Index am Ende des Dateinamens falls Datei im Ziel schon vorhanden
        	$destFile = $this->getFilePath($basePath.$destDispretionPath, $file);
        	/* if (Mage::getStoreConfig('dev/log/log_level') == Zend_Log::DEBUG) {
        		$fileInfo = pathinfo($destFile);
        		if (file_exists($destFile)) {
        			if (!isset($fileInfo["extension"])) {
        				Mage::log(sprintf("dwdafa::No extension for file\nfrom:%s\nto:%s", $this->getFilePath($baseTmpPath, $file), $this->getFilePath($basePath, $destFile)), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);
        			}
        		}
        	} */
        	$destFile = $destDispretionPath . $ioObject->dirsep()
        				. Dwd_ConfigurableDownloadable_Model_File_Uploader::getNewFileName($destFile);
        }
        //kopiert Datei in Datenbank falls aktiviert!
        Mage::helper('core/file_storage_database')->copyFile(
            $this->getFilePath($baseTmpPath, $file),
            $this->getFilePath($basePath, $destFile)
        );

        //Bereits vorhandene Dateien werden ersetzt!
        $result = $ioObject->cp(
            $this->getFilePath($baseTmpPath, $file),
            $this->getFilePath($basePath, $destFile)
        );
        if (!$result) {
        	Mage::throwException(sprintf("Can't copy file\nfrom:%s\nto:%s", $this->getFilePath($baseTmpPath, $file), $this->getFilePath($basePath, $destFile)));
        }
        
        @touch($this->getFilePath($basePath, $destFile), $srcFileModTime);
        return str_replace($ioObject->dirsep(), '/', $destFile);
    }
}
