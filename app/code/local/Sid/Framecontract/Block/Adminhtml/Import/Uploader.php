<?php

class Sid_Framecontract_Block_Adminhtml_Import_Uploader extends Mage_Adminhtml_Block_Widget
implements Varien_Data_Form_Element_Renderer_Interface
{

    protected $_config;
    protected $_token = null;

    public function __construct()
    {
        parent::__construct();
        $this->setId($this->getId() . '_Uploader');
        $this->setTemplate('sid/framecontract/uploader1.phtml');
        $this->getConfig()->setUrl($this->getActionUrl());
        $this->getConfig()->setParams(array('form_key' => $this->getFormKey()));
        $this->getConfig()->setFileField('image_upload');
        $this->getConfig()->setFilters(array(
            'images' => array(
                'label' => Mage::helper('adminhtml')->__('Images (.gif, .jpg, .png)'),
                'files' => array('*.gif', '*.jpg', '*.png')
            ),
        ));
    }

    
    public function getActionUrl()
    {
    	$debug = "";
    	//$debug = "&start_debug=1&debug_host=192.168.178.83%2C127.0.0.1&send_sess_end=1&debug_session_id=1000&debug_start_session=1&debug_no_cache=1385544095237&debug_port=10000";
    	return Mage::getModel('adminhtml/url')->addSessionParam()->getUrl('adminhtml/framecontract_import/upload').$debug;
    }
    
    protected function _xprepareLayout()
    {
        $this->setChild(
            'browse_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->addData(array(
                    'id'      => $this->_getButtonId('browse'),
                    'label'   => Mage::helper('adminhtml')->__('Browse Files...'),
                    'type'    => 'button',
                    'onclick' => $this->getJsObjectName() . '.browse()'
                ))
        );

        $this->setChild(
            'upload_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->addData(array(
                    'id'      => $this->_getButtonId('upload'),
                    'label'   => Mage::helper('adminhtml')->__('Upload Files'),
                    'type'    => 'button',
                    'onclick' => $this->getJsObjectName() . '.upload()'
                ))
        );

        $this->setChild(
            'delete_button',
            $this->getLayout()->createBlock('adminhtml/widget_button')
                ->addData(array(
                    'id'      => '{{id}}-delete',
                    'class'   => 'delete',
                    'type'    => 'button',
                    'label'   => Mage::helper('adminhtml')->__('Remove'),
                    'onclick' => $this->getJsObjectName() . '.removeFile(\'{{fileId}}\')'
                ))
        );

        return parent::x_prepareLayout();
    }



    /**
     * Retrive uploader js object name
     *
     * @return string
     */
    public function getJsObjectName()
    {
        return $this->getHtmlId() . 'JsObject';
    }

    /**
     * Retrive config json
     *
     * @return string
     */
    public function getConfigJson()
    {
        return Mage::helper('core')->jsonEncode($this->getConfig()->getData());
    }

    /**
     * Retrive config object
     *
     * @return Varien_Simplexml_Config
     */
    public function getConfig()
    {
        if(is_null($this->_config)) {
            $this->_config = new Varien_Object();
        }

        return $this->_config;
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
    
    
    public function render(Varien_Data_Form_Element_Abstract $element)
    {
    	$this->setElement($element);
    	return $this->toHtml();
    }
    
    public function getToken()
    {
    	if($this->_token == null)
    	{
    		$this->_token = md5(rand(1, 1000) . time());
    	}
    	
    	return $this->_token;
    }
    
    
}
