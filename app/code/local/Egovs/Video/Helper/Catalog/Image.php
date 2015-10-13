<?php
class Egovs_Video_Helper_Catalog_Image extends Mage_Catalog_Helper_Image
{
	/**
	 * Prüft ob 'shell_exec' verwendet werden kann
	 *
	 * @return bool
	 */
	protected function _shellExecEnabled() {
			$disabled = explode(', ', ini_get('disable_functions'));
			return !in_array('shell_exec', $disabled);
	}

	/**
	 * Check - is this file an image
	 *
	 * @param string $filePath Path
	 *
	 * @return bool
	 * @throw Mage_Core_Exception
	 */
	public function validateUploadFile($filePath) {
	  $mime = '';
		$fileInfo = false;
		if (class_exists('finfo', false) || function_exists('finfo_open')) {
			$fileInfo = new finfo();

			if (is_resource($fileInfo) === true) {
				$mime = $fileInfo->file($filePath, FILEINFO_MIME_TYPE);
			} else {
				$fileInfo = false;
			}
		}


		$mime = getimagesize($filePath);
		if( is_array($mime) ){
        $mime = image_type_to_mime_type($mime[2]);
		} elseif(!$fileInfo && function_exists("mime_content_type")) {
			//Fallback
			$mime = mime_content_type($filePath);
		} elseif (function_exists('shell_exec') && $this->_shellExecEnabled()) {
			//letzter Fallback
			$file = escapeshellarg( $filePath);
			$mime = shell_exec("file -bi " . $file);
		  if ( !$mime ) {
		    Mage::log(sprintf('video::Imagevalidy: It is not possible to determine the file mime type'), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
		    return true;
		  }
		} else {
			//Wir können die Datei nicht auf Ihren MIME-Type prüfen
			Mage::log(sprintf('video::Imagevalidy: It is not possible to determine the file mime type'), Zend_Log::WARN, Egovs_Helper::LOG_FILE);
			return true;
		}

		Mage::log(sprintf('video::Imagevalidy: %s', $mime), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

		if (stripos($mime, 'image/') !== false) {
			if (!getimagesize($filePath)) {
				Mage::throwException($this->__('Disallowed file type.'));
			} else {
				return true;
			}
		} elseif (stripos($mime, 'video/') !== false) {
			return true;
		}

		Mage::throwException($this->__('Disallowed file type.'));
	}
}