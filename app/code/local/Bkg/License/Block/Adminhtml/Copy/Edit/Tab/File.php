<?php
/**
 *
 * @category   	Bkg Licence
 * @package    	Bkg_Licence
 * @name       	Bkg_License_Block_Adminhtml_Copy_Edit_Tab_File
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2017 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bkg_License_Block_Adminhtml_Copy_Edit_Tab_File extends Mage_Adminhtml_Block_Widget
{
	protected $_values = null;

	/**
     * Type of uploader block
     *
     * @var string
     */
    protected $_uploaderType = 'uploader/multiple';
    protected $_uploaderFieldName = 'Filedata';

	protected function _construct()
	{
		parent::_construct();
		$this->setTemplate('bkg/license/copy/edit/tab/file.phtml');
	}

	protected function _prepareLayout()
	{
		$this->setChild( 'uploader', $this->getLayout()->createBlock($this->_uploaderType) );

		$this->getUploader()
		     ->getUploaderConfig()
		     ->setFileParameterName($this->_uploaderFieldName)
			 ->setTarget( $this->getActionUrl() );

		$browseConfig = $this->getUploader()->getButtonConfig();
		$browseConfig->setAttributes(
					       array(
							   'accept' => $browseConfig->getMimeTypesByExtensions('gif, png, jpeg, jpg')
						   )
					   );

		Mage::dispatchEvent('bkg_license_copy_prepare_layout', array('block' => $this));

		return parent::_prepareLayout();
	}

	/**
     * Retrive uploader block
     *
     * @return Mage_Uploader_Block_Multiple
     */
    public function getUploader()
    {
        return $this->getChild('uploader');
    }

    /**
     * Retrive uploader block html
     *
     * @return string
     */
    public function getUploaderHtml()
    {
        return $this->getChildHtml('uploader');
    }

	public function getJsObjectName()
    {
        return $this->getHtmlId() . 'JsObject';
    }

	



	public function getActionUrl()
	{
		$id = Mage::registry('entity_data')->getId();
		$debug = "";
		//$debug = "&start_debug=1&debug_host=192.168.178.83%2C127.0.0.1&send_sess_end=1&debug_session_id=1000&debug_start_session=1&debug_no_cache=1385544095237&debug_port=10000";
		//return Mage::getModel('adminhtml/url')->addSessionParam()->getUrl('adminhtml/license_copy/upload',array('id'=>$id)).$debug;
		return Mage::getModel('adminhtml/url')->addSessionParam()->getUrl( '*/license_copy/upload',array('id'=>$id) ).$debug;
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


	public function getDocTypes()
	{
		return Bkg_License_Model_Copy_Doctype::getOptionArray();

	}

	public function getFiles()
	{
		$id = Mage::registry('entity_data')->getId();
		$collection= Mage::getModel('bkg_license/copy_file')->getCollection();
		$collection->getSelect()->where('copy_id=?',intval($id));

		$res = array();
		foreach($collection->getItems() as $item)
		{
			$url = $this->getUrl('adminhtml/license_copy/download',array('id'=>$item->getHashFilename()));
			$item->setDownloadUrl($url);

			$url = $this->getUrl('adminhtml/license_copy/deletefile',array('id'=>$item->getHashFilename()));
			$item->setDeleteUrl($url);
			$res[] = $item;
		}

		return $res;
	}
}
