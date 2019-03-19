<?php
/**
 * Observer zum Speichern von Beschreibungsinformationen zu Produkten *
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
class Egovs_ProductFile_Model_Observer extends Mage_Core_Model_Abstract
{
	/**
	 * This method will run before the product is saved.
	 * Save uploaded files and set product attributes.
	 *
	 * @param Varien_Event_Observer $observer Observer
	 * 
	 * @return void
	 */
	public function saveTabData(Varien_Event_Observer $observer) {

		if ($post = $observer->getRequest()->getPost()) {
				
			try {

				/*
				 * Load the current product model
				 */
				$product = $observer->getProduct();
				/**
				 * @var $helper Egovs_ProductFile_Helper_Data
				 */
				$helper = Mage::helper('productfile');
				$fileext = $helper->getProductFileAllowedExtensions();
				$imgext = $helper->getProductImageAllowedExtensions();
				$path = Mage::getBaseDir('media') . DS . $helper->getProductFileUploadDirectory() . DS; 
					
				/*
				 * Create upload directory in media if not present
				 */
				if (!is_dir($path)) {
					mkdir($path);
				}
					
				/*
				 * Delete product file data if checkbox is set
				 */
				if ((isset($post[Egovs_ProductFile_Helper_Data::PRODUCT_DELETE_FILE]) && $post[Egovs_ProductFile_Helper_Data::PRODUCT_DELETE_FILE] == "1") ||
					(isset($post['use_default_productfile']))){
					if (file_exists($path . $product->getProductfile()) && !is_dir($path . $product->getProductfile())) {
						unlink($path . $product->getProductfile());
					}
					if (file_exists($path . $product->getProductimage()) && !is_dir($path . $product->getProductimage())) {
						unlink($path . $product->getProductimage());
						
					}
					if (file_exists($path . "resized" . DS . $product->getProductimage()) && !is_dir($path . "resized" . DS . $product->getProductimage())) {
						unlink($path . "resized" . DS . $product->getProductimage());
					}					
					
					$product->setData('productfile',false);
					$product->setData('productimage',false);
					$product->setData('productfiledescription',false);
					return;
				}
				
				/*
				 * Check for valid file types
				 */
				if (isset($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_FILE]['name']) && $_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_FILE]['name'] != "" && !$helper->isValidProductFile($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_FILE]['name'])) {
					Mage::getSingleton('adminhtml/session')->addError($helper->__('Disallowed file type.'));
					return;	
				}
				if (isset($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE]['name']) && $_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE]['name'] != "" && !$helper->isValidProductImage($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE]['name'])) {
					Mage::getSingleton('adminhtml/session')->addError($helper->__('Disallowed file type.'));
					return;	
				}
				
				/*
				 * Check max. upload filesizes
				 */
				$max_size = min($helper->getBytes(ini_get('post_max_size')), $helper->getBytes(ini_get('upload_max_filesize')));
				if (isset($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_FILE]['name']) && $_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_FILE]['name'] != "" && !file_exists($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_FILE]['tmp_name'])) {
					Mage::getSingleton('adminhtml/session')->addError($helper->__('Product file upload error. Maximum file size is') . " " . $helper->getFormatBytes($max_size) . ".");
					return;
				}
				if (isset($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE]['name']) && $_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE]['name'] != "" && !file_exists($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE]['tmp_name'])) {
					Mage::getSingleton('adminhtml/session')->addError($helper->__('Product file image upload error. Maximum file size is') . " " . $helper->getFormatBytes($max_size) . ".");
					return;
				}
				
				/*
				 * Upload additional product file, eg. PDF-Documents etc.
				 * See config.xml for allowed file types.
				 */
				if (isset($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_FILE]['name']) && file_exists($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_FILE]['tmp_name'])) {	
					if ($product->getProductfile() && file_exists($path . $product->getProductfile()) && !is_dir($path . $product->getProductfile())) {
						unlink($path . $product->getProductfile());
					}
					$uploader = new Varien_File_Uploader(Egovs_ProductFile_Helper_Data::PRODUCT_FILE);
					$uploader->setAllowedExtensions($fileext);
					$uploader->setAllowCreateFolders(true);
					$uploader->setAllowRenameFiles(true);
					$uploader->setFilesDispersion(true);
					$result = $uploader->save($path);
					if ($result && isset($result['file'])) {
						$product->setProductfile(trim($result['file'], '/\\'));
					} else {
						Mage::getSingleton('adminhtml/session')->addError($helper->__('Product file upload error!'));
						return;
					}
				}

				if (isset($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE]['name']) && (file_exists($_FILES[Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE]['tmp_name']))) {
					if ($product->getProductimage() && file_exists($path . $product->getProductimage()) && !is_dir($path . $product->getProductimage())) {
						unlink($path . $product->getProductimage());	
					}
					if (file_exists($path . "resized" . DS . $product->getProductimage()) && !is_dir($path . "resized" . DS . $product->getProductimage())) {
						unlink($path . "resized" . DS . $product->getProductimage());
					}	
					$uploader = new Varien_File_Uploader(Egovs_ProductFile_Helper_Data::PRODUCT_IMAGE);
					$uploader->setAllowedExtensions($imgext);
					$uploader->setAllowCreateFolders(true);
					$uploader->setAllowRenameFiles(true);
					$uploader->setFilesDispersion(true);
					$result = $uploader->save($path);
					if ($result && isset($result['file'])) {
						$product->setProductimage(trim($result['file'], '/\\'));
					} else {
						Mage::getSingleton('adminhtml/session')->addError($helper->__('Product image upload error!'));
						return;
					}
				}
				
				if (isset($post[Egovs_ProductFile_Helper_Data::PRODUCT_FILE_DESCRIPTION])) {
					$product->setProductfiledescription($post[Egovs_ProductFile_Helper_Data::PRODUCT_FILE_DESCRIPTION]);
				}
			} catch(Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($helper->__($e->getMessage()));
			}
			
		}
	}
}