<?php
require_once 'Mage/Adminhtml/controllers/Cms/Wysiwyg/ImagesController.php';

class Egovs_Base_Adminhtml_Cms_Wysiwyg_MediaController extends Mage_Adminhtml_Cms_Wysiwyg_ImagesController
{
    /**
     * Register storage model and return it
     *
     * @return Mage_Cms_Model_Wysiwyg_Images_Storage
     */
    public function getStorage()
    {
        if (!Mage::registry('storage')) {
            $storage = Mage::getModel('egovsbase/cms_wysiwyg_media_storage');
            Mage::register('storage', $storage);
        }
        return Mage::registry('storage');
    }

	public function indexAction() {
        $this->getRequest()->setParam('type', null);
        $this->getRequest()->setParam('target_element_id', 'file-content');
        $this->loadLayout();

        $this->_initAction();
        /**
         * Set active menu item
         */
        $this->_setActiveMenu('cms/media');

        /**
         * Add breadcrumb item
         */
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Cms'), Mage::helper('adminhtml')->__('Cms'));
        $this->_addBreadcrumb(Mage::helper('adminhtml')->__('Media Gallery'), Mage::helper('adminhtml')->__('Media Gallery'));

        $storeId = (int) $this->getRequest()->getParam('store');

        try {
            Mage::helper('cms/wysiwyg_images')->getCurrentPath();
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        $block = $this->getLayout()->getBlock('wysiwyg_images.js');
        if ($block) {
            $block->setStoreId($storeId);
        }

        $block = $this->getLayout()->getBlock('wysiwyg_images.uploader');
        if ($block) {
            $block->getUploaderConfig()->setFileParameterName('media');
        }
        $this->renderLayout();
    }

    public function dialogAction() {
        $this->getRequest()->setParam('type', null);

        $storeId = (int) $this->getRequest()->getParam('store');

        try {
            Mage::helper('cms/wysiwyg_images')->getCurrentPath();
        } catch (Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        }
        $this->_initAction()->loadLayout('overlay_popup');
        $block = $this->getLayout()->getBlock('wysiwyg_images.js');
        if ($block) {
            $block->setStoreId($storeId);
        }
        $block = $this->getLayout()->getBlock('wysiwyg_images.uploader');
        if ($block) {
            $block->getUploaderConfig()->setFileParameterName('media');
        }
        $this->renderLayout();
    }
}