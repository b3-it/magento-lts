<?php
/**
 * Diese Klasse erweitert Magento um die Möglichkeit FLV Videos zu importieren.
 *
 * Der Dateifilter wird um Video/Audio-Formate erweitert.
 *
 * @category   	Egovs
 * @package    	Egovs_Video
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - https://www.b3-it.de
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @see Mage_Core_Model_File_Validator_Image
 */
class Egovs_Video_Model_File_Validator_Media extends Mage_Core_Model_File_Validator_Image
{
	protected $_allowedMediaTypes = array(
			'video/x-flv',
			'video/x-msvideo',
			'video/mp4',
			'video/ogg',
			'video/webm',
			'audio/mp4',
			'audio/wav',
			'audio/ogg',
			'audio/webm',
			'audio/wav',
	);
	
	/**
	 * Setter for allowed image types
	 *
	 * @param array $mediaFileExtensions
	 * @return $this
	 */
	public function setAllowedMediaTypes(array $mediaFileExtensions = array())
	{
		$map = array(
				'flv' => array('video/x-flv'),
				'avi' => array('video/x-msvideo'),
				'ogv' => array('video/ogg'),
				'mp4' => array('video/mp4', 'audio/mp4'),
				'webm' => array('video/webm', 'audio/webm'),
				'm4v' => array('video/mp4'),
				'm4a' => array('audio/mp4'),
				'ogg' => array('audio/ogg'),
				'wav' => array('audio/wav'),
				'oga' => array('audio/ogg'),
		);
		
		$this->_allowedMediaTypes = array();
		
		foreach ($mediaFileExtensions as $extension) {
			if (isset($map[$extension])) {
				foreach ($map[$extension] as $mediaType) {
					$this->_allowedMediaTypes[$mediaType] = $mediaType;
				}
			}
		}
		
		return $this;
	}
	
	/**
	 * Returns is media by mime type
	 * @param string $sMediaType
	 * @return bool
	 */
	protected function isMediaType($sMediaType)
	{
		return in_array($sMediaType, $this->_allowedMediaTypes);
	}
	
	/**
	 * Validation callback for checking is file is valid media
	 *
	 * @param  string $filePath Path to temporary uploaded file
	 * 
	 * @return null
	 * @throws Mage_Core_Exception
	 */
	public function validate($filePath)
	{
		list($imageWidth, $imageHeight, $fileType) = getimagesize($filePath);
		if ($fileType) {
			if ($this->isImageType($fileType)) {
				//replace tmp image with re-sampled copy to exclude images with malicious data
				$image = imagecreatefromstring(file_get_contents($filePath));
				if ($image !== false) {
					$img = imagecreatetruecolor($imageWidth, $imageHeight);
					imagecopyresampled($img, $image, 0, 0, 0, 0, $imageWidth, $imageHeight, $imageWidth, $imageHeight);
					switch ($fileType) {
						case IMAGETYPE_GIF:
							imagegif($img, $filePath);
							break;
						case IMAGETYPE_JPEG:
							imagejpeg($img, $filePath, 100);
							break;
						case IMAGETYPE_PNG:
							imagepng($img, $filePath);
							break;
						default:
							return;
					}
					imagedestroy($img);
					imagedestroy($image);
					return null;
				} else {
					throw Mage::exception('Mage_Core', Mage::helper('core')->__('Invalid image.'));
				}
			}
		}
		$mime = mime_content_type($filePath);
		if ($mime) {
			if ($this->isMediaType($mime)) {
				return;
			}
		}
		throw Mage::exception('Mage_Core', Mage::helper('egovsvies')->__('Invalid MIME type: %s', $mime));
	}
}