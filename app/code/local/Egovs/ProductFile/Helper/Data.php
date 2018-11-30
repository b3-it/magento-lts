<?php

/**
 * Helper für Beschreibungsinformationen zu Produkten
 *
 * @category   	Egovs
 * @package    	Egovs_ProductFile
 * @author 		Jan Knipper <j.knipper@edv-beratung-hempel.de>
 * @author		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 *
 */
class Egovs_ProductFile_Helper_Data extends Mage_Core_Helper_Abstract
{
	const PRODUCT_FILE  			= 'productfile';
	const PRODUCT_IMAGE 			= 'productimage';
	const PRODUCT_FILE_DESCRIPTION 	= 'productfiledescription';
	const PRODUCT_DELETE_FILE		= 'deleteproductfile';

	/**
	 * Liefert die Thumbnail Bild-URL zu einem Bild
	 *
	 * @param string $image Dateiname des Bildes
	 *
	 * @return string URL zu Thumbnail
	 */
	public function getThumbnailProductImageUrl($image) {
	    $url = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA) . $this->getProductFileUploadDirectory() . "/";
    	$path = Mage::getBaseDir('media') . DS . $this->getProductFileUploadDirectory() . DS;
    	$resizedPath = $path . "resized" . DS . $image;
    	$resizedUrl = $url . "resized/" . $image;
    	if (!$image) {
    		return;
    	}
    	$imagePath = $path . $image;
    	if (!file_exists($imagePath)) return;
    	if (!file_exists($resizedPath)) {
			$imageObj = new Varien_Image($imagePath);
			$width = $this->getProductFileImageWidth();
			$imageObj->constrainOnly(true);
			$imageObj->keepAspectRatio(true);
			$imageObj->keepFrame(false);
			$imageObj->keepTransparency(true);
			if ($imageObj->getOriginalWidth() > $width || $imageObj->getOriginalHeight() > $width) {
				$imageObj->resize($width, $width);
			}
			$imageObj->save($resizedPath);
    	}
		return $resizedUrl;
	}

	/**
	 * Fügt eine Nummer zu schon existierenden Dateien hinzu
	 *
	 * @param string $filename   Dateiname
	 * @param string $target_dir Ziel-Pfad
	 *
	 * @return string Dateiname
	 * @deprecated see Varien_File_Uploader::save
	 */
	public function getUniqueFilename($filename, $target_dir) {
		$file_suffix = substr($filename, (strrpos($filename, '.')+1));
		if (file_exists($target_dir.$filename)) {
			if  (!preg_match('/_\d+.\w{3,4}$/', $filename))
			$filename = str_replace(".$file_suffix", "_1.$file_suffix", $filename);
			if (preg_match('/_(\d+).(\w{3,4})$/', $filename, $m))
			while (file_exists($target_dir.$filename))
			$filename = str_replace("$m[1].$m[2]", ++$m[1].".$m[2]", $filename);
		}
		return $filename;
	}

	/**
	 * Gibt den Typ zurück
	 *
	 * Der Typ ist die Dateiendung
	 *
	 * @return string
	 */
	public function getProductFileType() {
		return strtoupper(substr($this->getProductFileFullName(), (strrpos($this->getProductFileFullName(), '.')+1)));
	}

	/**
	 * Gibt den Typ zurück
	 *
	 * Der Typ ist die Dateiendung
	 *
	 * @param string $filename Dateiname
	 *
	 * @return string
	 */
	public function getFileType($filename) {
		return strtolower(substr($filename, (strrpos($filename, '.')+1)));
	}

	/**
	 * Validiert die Beschreibungsdatei anhand des Typs.
	 *
	 * @param string $filename Dateiname
	 *
	 * @return boolean
	 *
	 * @see Egovs_ProductFile_Helper_Data::getFileType
	 */
	public function isValidProductFile($filename) {
		$exts = Mage::getStoreConfig('settings/productfile_allowed_extensions');
		$fileext = $this->getFileType($filename);
		foreach ($exts as $key => $ext) {
			if (strtolower($ext) == $fileext) return true;
		}
		return false;
	}

	/**
	 * Validiert die Beschreibungsdatei anhand des Typs.
	 *
	 * @param string $filename Dateiname
	 *
	 * @return boolean
	 *
	 * @see Egovs_ProductFile_Helper_Data::getFileType
	 */
	public function isValidProductImage($filename) {
		$exts = Mage::getStoreConfig('settings/productimage_allowed_extensions');
		$fileext = $this->getFileType($filename);
		foreach ($exts as $key => $ext) {
			if (strtolower($ext) == $fileext) return true;
		}
		return false;
	}

	/**
	 * Liefert die Größe der Beschreibungsdatei formatiert als Bytes/KB/MB zurück
	 *
	 * @return float
	 */
	public function getProductFileSize() {
		return $this->getFormatBytes(filesize($this->getProductFileFullName()));
	}

	/**
	 * Formatiert die Größe als Bytes/KB/MB im 2 stelligen Format
	 *
	 * @param integer $size Größe in Bytes
	 *
	 * @return float
	 */
	public function getFormatBytes($size) {
		$units = array(' B', ' KB', ' MB', ' GB', ' TB');
		for ($i = 0; $size >= 1024 && $i < 4; $i++) $size /= 1024;
		return round($size, 2).$units[$i];
	}

	/**
	 * Parsed eine String-Byte-Angabe in Integer
	 *
	 * @param string $size Größe in B/KB/MB/GB
	 *
	 * @return integer Größe in Bytes
	 */
	public function getBytes($size) {
		$size = trim($size);
		$last = strtolower(substr($size, -1));
		if($last == 'g') $size = (int)$size*1024*1024*1024;
		if($last == 'm') $size = (int)$size*1024*1024;
		if($last == 'k') $size = (int)$size*1024;
		return $size;
	}

	/**
	 * Liefert den Dateinamen samt kompletten Pfad zur Beschreibungsdatei
	 *
	 * @return string
	 */
	public function getProductFileFullName() {
		$product = Mage::registry('current_product');
		$product_file_name = preg_replace("/[^a-zA-Z0-9-_.\/]/i", "_", $product->getProductfile());
		return Mage::getBaseDir('media') . DS . $this->getProductFileUploadDirectory() . DS . str_replace('__', '_', $product_file_name);
	}

	/**
	 * Gibt die erlaubten Erweiterungen für Bewschreibungsdateien aus der Konfiguration zurück
	 *
	 * @return array
	 */
	public function getProductFileAllowedExtensions() {
		$exts = Mage::getStoreConfig('settings/productfile_allowed_extensions');
		return array_values($exts);
	}
	/**
	 * Gibt die erlaubten Erweiterungen für Bilder zu Bewschreibungsdateien aus der Konfiguration zurück
	 *
	 * @return array
	 */
	public function getProductImageAllowedExtensions() {
		$exts = Mage::getStoreConfig('settings/productimage_allowed_extensions');
		return array_values($exts);
	}
	/**
	 * Gibt die erlaubten Erweiterungen formatiert zurück
	 *
	 * @return array
	 *
	 * @see Egovs_ProductFile_Helper_Data::getProductFileAllowedExtensions
	 */
	public function getFormattedProductFileAllowedExtensions() {
		return implode(', ', $this->getProductFileAllowedExtensions());
	}
	/**
	 * Gibt die erlaubten Erweiterungen formatiert zurück
	 *
	 * @return array
	 *
	 * @see Egovs_ProductFile_Helper_Data::getProductImageAllowedExtensions
	 */
	public function getFormattedProductImageAllowedExtensions() {
		return implode(', ', $this->getProductImageAllowedExtensions());
	}

	/**
	 * Liefert das File-Upload-Verzeichnis für Beschreibungsdateien aus der Konfiguration
	 *
	 * @return string
	 */
	public function getProductFileUploadDirectory() {
		return Mage::getStoreConfig('settings/productfile_upload_directory/dir');
	}
	/**
	 * Liefert die Größe für Bilder zu Beschreibungsdateien aus der Konfiguration
	 *
	 * @return string
	 */
	public function getProductFileImageWidth() {
		return Mage::getStoreConfig('settings/productfile_image_size/width');
	}

}