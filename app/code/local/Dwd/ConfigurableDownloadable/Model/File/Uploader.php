<?php

class Dwd_ConfigurableDownloadable_Model_File_Uploader extends Mage_Core_Model_File_Uploader
{
	static public function getNewFileName($destFile) {
        $fileInfo = pathinfo($destFile);
        if (file_exists($destFile)) {
            $index = 1;
            if (isset($fileInfo['extension'])) {
            	$baseName = $fileInfo['filename'] . '.' . $fileInfo['extension'];
            	while( file_exists($fileInfo['dirname'] . DIRECTORY_SEPARATOR . $baseName) ) {
            		$baseName = $fileInfo['filename']. '_' . $index . '.' . $fileInfo['extension'];
            		$index ++;
            	}
            } else {
            	$baseName = $fileInfo['filename'];
            	while( file_exists($fileInfo['dirname'] . DIRECTORY_SEPARATOR . $baseName) ) {
            		$baseName = $fileInfo['filename']. '_' . $index;
            		$index ++;
            	}
            }
            
            $destFileName = $baseName;
        } else {
            return $fileInfo['basename'];
        }

        return $destFileName;
    }
}