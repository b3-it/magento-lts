<?php
require_once 'Mage/Adminhtml/controllers/Catalog/Product/GalleryController.php';
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   	Egovs
 * @package    	Egovs_Video
 * @author 		Frank Rochlitzer <f.rochlitzer@trw-net.de>
 * @copyright  	Copyright (c) 2011 EDV Beratung Hempel - http://www.edv-beratung-hempel.de
 * @copyright  	Copyright (c) 2011 TRW-NET - http://www.trw-net.de
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 */

/**
 * Diese Klasse erweitert Magento um die Möglichkeit FLV Videos zu importieren.
 *
 * Der Dateifilter wird um *.flv erweitert.
 *
 * @category   	Egovs
 * @package    	Egovs_Video
 * @author 		Frank Rochlitzer <f.rochlitzer@b3-it.de>
 * @copyright  	Copyright (c) 2011 - 2017 B3 It Systeme GmbH - https://www.b3-it.de
 * @license    	http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 *
 * @see Mage_Adminhtml_Block_Catalog_Product_Helper_Form_Gallery_Content
 */
class Egovs_Video_Adminhtml_Catalog_Product_GalleryController extends Mage_Adminhtml_Catalog_Product_GalleryController
{
	
	/**
	 * Der Dateifilter wird um *.flv, *.avi, *.swf erweitert
	 *
	 * @return void
	 *
	 */
	public function uploadAction()
    {
    	Mage::log("video::GalleryController called...", Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

    	try {
            $uploader = new Mage_Core_Model_File_Uploader('image');
            $uploader->setAllowedExtensions(array('jpg','jpeg','gif','png', 'flv', 'avi', 'ogg',
                                                  'mp4', 'webm', 'wav', 'ogv', 'oga', 'm4v', 'm4a'
                                           ));
            $uploader->addValidateCallback('catalog_product_image',
                Mage::helper('egovsvideo/catalog_image'), 'validateUploadFile');
            $uploader->setAllowRenameFiles(true);
            $uploader->setFilesDispersion(true);
            $uploader->addValidateCallback(
            		Mage_Core_Model_File_Validator_Image::NAME,
            		Mage::getModel('egovsvideo/file_validator_media'),
            		'validate'
            		);
            $result = $uploader->save(
                Mage::getSingleton('catalog/product_media_config')->getBaseTmpMediaPath()
            );

//             Mage::log(sprintf('video::Result: %s', var_export($result, true)), Zend_Log::DEBUG, Egovs_Helper::LOG_FILE);

            /**
             * Workaround for prototype 1.7 methods "isJSON", "evalJSON" on Windows OS
             */
            $result['tmp_name'] = str_replace(DS, "/", $result['tmp_name']);
            $result['path'] = str_replace(DS, "/", $result['path']);

            $result['url'] = Mage::getSingleton('catalog/product_media_config')->getTmpMediaUrl($result['file']);
            $result['file'] = $result['file'] . '.tmp';
            $result['cookie'] = array(
                'name'     => session_name(),
                'value'    => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path'     => $this->_getSession()->getCookiePath(),
                'domain'   => $this->_getSession()->getCookieDomain()
            );

        } catch (Exception $e) {
            $result = array(
                'error' => $e->getMessage(),
                'errorcode' => $e->getCode());
        }

        $this->getResponse()->setBody(Mage::helper('core')->jsonEncode($result));
    }
}