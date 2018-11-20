<?php
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
 * to license@magento.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magento.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright  Copyright (c) 2006-2016 X.commerce, Inc. and affiliates (http://www.magento.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog category helper
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Bfr_EventManager_Helper_Product_View extends Mage_Core_Helper_Abstract
{
    // List of exceptions throwable during prepareAndRender() method
    public $ERR_NO_PRODUCT_LOADED = 1;
    public $ERR_BAD_CONTROLLER_INTERFACE = 2;
    
    /** @var Mage_Core_Model_Layout */
    protected $_layout = NULL;
   
    protected $_store = null;
    
    protected $_product = null;

     /**
     * Inits layout for viewing product page
     *
     * @param Mage_Catalog_Model_Product $product
     * @param Mage_Core_Controller_Front_Action $controller
     *
     * @return Mage_Catalog_Helper_Product_View
     */
    public function initProductLayout($product)
    {
        $design = Mage::getSingleton('catalog/design');
        $settings = $design->getDesignSettings($product);

        if ($settings->getCustomDesign()) {
            $design->applyCustomDesign($settings->getCustomDesign());
        }

        $update = $this->_layout->getUpdate();
        $update->addHandle('default');
        $this->addActionLayoutHandles();

        $update->addHandle('PRODUCT_TYPE_' . $product->getTypeId());
        $update->addHandle('PRODUCT_' . $product->getId());
       // $controller->loadLayoutUpdates();
        $update->setCacheId(time());
        $update->load();
        // Apply custom layout update once layout is loaded
        $layoutUpdates = $settings->getLayoutUpdates();
        if ($layoutUpdates) {
            if (is_array($layoutUpdates)) {
                foreach($layoutUpdates as $layoutUpdate) {
                    $update->addUpdate($layoutUpdate);
                }
            }
        }

        $this->_layout->generateXml();
       
       
        $this->_layout->generateBlocks();
       
    

        // Apply custom layout (page) template once the blocks are generated
        if ($settings->getPageLayout()) {
            $this->_layout->helper('page/layout')->applyTemplate($settings->getPageLayout());
        }

      
        $root = $this->_layout->getBlock('root');
        if ($root) {
             $root->addBodyClass('catalog-product-view');
            
            $root->addBodyClass('product-' . $product->getUrlKey());
            
        }

        return $this;
    }

    /**
     * Prepares product view page - inits layout and all needed stuff
     *
     * $params can have all values as $params in Mage_Catalog_Helper_Product - initProduct().
     * Plus following keys:
     *   - 'buy_request' - Varien_Object holding buyRequest to configure product
     *   - 'specify_options' - boolean, whether to show 'Specify options' message
     *   - 'configure_mode' - boolean, whether we're in Configure-mode to edit product configuration
     *
     * @param int $productId
     * @param Mage_Core_Controller_Front_Action $controller
     * @param null|Varien_Object $params
     *
     * @return Mage_Catalog_Helper_Product_View
     */
    public function prepareAndRender($productId, $store_id)
    {
    	$this->_layout = Mage::getModel('core/layout');
    	$this->_layout->setArea('frontend');
    	$this->_store = Mage::getModel('core/store')->load($store_id);
        // Prepare data
       
        $params = new Varien_Object();
        

        // Standard algorithm to prepare and rendern product view page
        $product = $this->initProduct($productId);
        if (!$product) {
            throw new Mage_Core_Exception($this->__('Product is not loaded'), $this->ERR_NO_PRODUCT_LOADED);
        }

       

        Mage::dispatchEvent('catalog_controller_product_view', array('product' => $product));

        if ($params->getSpecifyOptions()) {
            $notice = $product->getTypeInstance(true)->getSpecifyOptionMessage();
            Mage::getSingleton('catalog/session')->addNotice($notice);
        }

        $appEmulation = Mage::getSingleton('core/app_emulation');
    	$initialEnvironmentInfo = $appEmulation->startEnvironmentEmulation($store_id);

        $this->initProductLayout($product);

       
      
        
        /** @var $block Mage_Core_Block_Text_List */
        $block = $this->_layout->getBlock('content');
        
        /** @var $view Mage_Catalog_Block_Product_View */
        $view = $block->getChild('product.info');
       
        
        $output = $block->toHtml();
        
        Mage::getSingleton('core/translate_inline')->processResponseBody($output);
       
        $appEmulation->stopEnvironmentEmulation($initialEnvironmentInfo);
        return $output;
    }
    
    /**
     * Inits product to be used for product controller actions and layouts
     * $params can have following data:
     *   'category_id' - id of category to check and append to product as current.
     *     If empty (except FALSE) - will be guessed (e.g. from last visited) to load as current.
     *
     * @param int $productId
     * @param Mage_Core_Controller_Front_Action $controller
     * @param Varien_Object $params
     *
     * @return false|Mage_Catalog_Model_Product
     */
    public function initProduct($productId)
    {

    	$params = new Varien_Object();

    	
    	if (!$productId) {
    		return false;
    	}
    
    	$product = Mage::getModel('catalog/product')
    	->setStoreId($this->_store->getId())
    	->load($productId);
    
    	
    	$this->_product = $product;
    
    	// Register current data and dispatch final events
    	Mage::register('current_product', $product);
    	Mage::register('product', $product);
    
    	try {
    		Mage::dispatchEvent('catalog_controller_product_init', array('product' => $product));
    		Mage::dispatchEvent('catalog_controller_product_init_after',
    				array('product' => $product,
    						'controller_action' => null
    				)
    				);
    	} catch (Mage_Core_Exception $e) {
    		Mage::logException($e);
    		return false;
    	}
    
    	return $product;
    }
    
    public function addActionLayoutHandles()
    {
    	$update = $this->_layout->getUpdate();
    
    	// load store handle
    	$update->addHandle('STORE_'.$this->_store->getCode());
    
    	// load theme handle
    	$package = Mage::getModel('core/design_package');
    	$package->setStore($this->_store->getId());
    	$update->addHandle(
    			'THEME_'.$package->getArea().'_'.$package->getPackageName().'_'.$package->getTheme('layout')
    			);
    
    	// load action handle
    	$update->addHandle('catalog_product_view_cms');
    
    	return $this;
    }
    
    public function getProduct()
    {
    	return $this->_product;
    }
}
