<?php
/**
 * Configurable Downloadable Products Controller
 *
 * @category    Dwd
 * @package     Dwd_ConfigurableDownloadable
 * @author     	Frank Rochlitzer <f.rochlitzer@edv-beratung-hempel.de>
 * @copyright	Copyright (c) 2013 EDV Beratung Hempel
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Dwd_ConfigurableDownloadable_Adminhtml_Configdownloadable_Product_EditController extends Mage_Adminhtml_Controller_Action
{
    /**
     * Varien class constructor
     * 
     * @return void
     *
     */
    protected function _construct() {
        $this->setUsedModuleName('Dwd_ConfigurableDownloadable');
    }
    
    /**
     * Spezielles Dispatching für Grid Actions
     * 
     * Die Prüfung verhindert einen PHP-Fatal Error falls die Session abgelaufen ist und nur eine Grid-Action stattfindet.
     * 
     * @return Mage_Adminhtml_Controller_Action
     * 
     * @see Mage_Adminhtml_Controller_Action::preDispatch()
     */
    public function preDispatch() {
    	if ($this->getRequest()->getQuery('isAjax', false) || $this->getRequest()->getQuery('ajax', false)) {
	    	Mage::getSingleton('core/session', array('name'=>'adminhtml'));
	    	if (!Mage::getSingleton('admin/session')->isLoggedIn()) {
	    		//TODO Magento müsste für die Unterstützung des Referers angepasst werden siehe Mage_Admin_Model_User::getStartupPageUrl()
	    		$this->_forward('adminhtml/index/deniedJson');
	    		//$this->_forward('adminhtml/index/login', null, null, array('referer' => Mage::helper('core')->urlEncode($this->getUrl("*/*/*"))));
	    		return $this;
	    	}
    	}
    	return parent::preDispatch();
    }

    /**
     * Wird bei AJAX Grid-Aktionen aufgerufen
     * 
     * @return void
     */
    public function gridAction() {
    	$this->loadLayout();
    
    	$this->getResponse()->setBody(
    			$this->getLayout()->createBlock('configdownloadable/adminhtml_catalog_product_edit_tab_configdownloadable_links')->toHtml()
    	);
    }
    
    public function massDeleteAction() {
    	$linkIds = $this->getRequest()->getParam('link_ids');
    	if (!is_array($linkIds)) {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('configdownloadable')->__('Please select link(s).'));
    	} else {
    		try {
    			Mage::getResourceModel('configdownloadable/extendedlink')->deleteItems($linkIds);
    			Mage::getSingleton('adminhtml/session')->addSuccess(
	    			Mage::helper('configdownloadable')->__('Total of %d record(s) were deleted.', count($linkIds))
    			);
    		} catch (Exception $e) {
    			Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
    		}
    	}
    	$productId  = (int) $this->getRequest()->getParam('id');
    	$this->_redirect('adminhtml/catalog_product/edit', array('id' => $productId, 'active_tab' => 'configdownloadable_tab', '_secure' => true));
    }
}
