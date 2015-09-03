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
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog product controller
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Stala_Abo_Adminhtml_Stalaabo_Catalog_ProductController extends Mage_Adminhtml_Controller_Action
{

    /**
     * Create product duplicate
     */
    public function duplicateAboAction()
    {
        $productId = (int) $this->getRequest()->getParam('product_id');
        $product = Mage::getModel('catalog/product')->load($productId);
        try {
            
            
            $stockitem = $product->getStockItem();
			$sku = $product->getSku();
			$newProduct = $product->duplicate();
			$newProduct = Mage::getModel('catalog/product')->load($newProduct->getId());
			$newProduct->setUrlKey($product->getUrlKey().'-'.$newProduct->getId());
        	$newProduct->setSku($sku.'-'.$newProduct->getId());
            $newProduct->setIsAboBaseProduct('0');
            $newProduct->setAboParentProduct($product->getId());
            $newProduct->save();
            
            $newProduct->getStockItem()
        			->setData('manage_stock',$stockitem['manage_stock'])
        			->setData('use_config_manage_stock',$stockitem['use_config_manage_stock'])
        			->setData('stock_status_changed_automatically',$stockitem['stock_status_changed_automatically'])
        			->save();
            
        	$freecopies = Mage::getModel('extcustomer/freecopies');
        	if($freecopies != null)
        	{		
            	$freecopies->setFreecopiesForDerivate($newProduct);
        	}
            $this->_getSession()->addSuccess($this->__('Abo Product derivated'));
            $this->_redirect('adminhtml/catalog_product/edit', array('_current'=>true, 'id'=>$newProduct->getId()));
        }
        catch (Exception $e){
            $this->_getSession()->addError($e->getMessage());
            $this->_redirect('adminhtml/catalog_product/edit', array('_current'=>true));
        }
    }

    
    public function deliverAboAction()
    {
    	$product_id = (int) $this->getRequest()->getParam('product_id');
        
        try {
        	
        	Mage::getModel('stalaabo/deliver')->deliverProduct($product_id);
        	Mage::getSingleton('adminhtml/session')->addSuccess($this->__("Product added to delivery list."));
        }
      	catch (Exception $e){
             Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            
        }
        $this->_redirect('adminhtml/catalog_product/edit', array('_current'=>true,'id'=>$product_id));
    }
    
    protected function _isAllowed() {
    	$action = strtolower($this->getRequest()->getActionName());
    	switch ($action) {
    		default:
    			return Mage::getSingleton('admin/session')->isAllowed('stalaabo/deliver');
    			break;
    	}
    }

}
