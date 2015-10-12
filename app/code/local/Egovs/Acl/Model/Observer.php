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
 * @package    Mage_Catalog
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog product model
 *
 * @category   Egovs
 * @package    Egovs_Acl
 */
class Egovs_Acl_Model_Observer extends Mage_Catalog_Model_Product
{
	//falls der status nicht gesetzt ist wg. ausgeblendetem feld, auf disabled setzen
	public function onProductSaveBefore($object)
	{
		$product = $object->getProduct();
		$acl = Mage::getSingleton('acl/productacl');
		$status = $acl->getProductStatusString($product);
		
		$canStatus = $acl->testPermission('admin/catalog/products/'.$status.'products/productstatus');
		if($product && !$canStatus)
		{
			if($product->getStatus() == 0 ) $product->setStatus(Mage_Catalog_Model_Product_Status::STATUS_DISABLED);
		}
	}
	
 	public function onCategoryCanAddRoot($observer)
   {
   		$canAdd = Mage::getSingleton('admin/session')->isAllowed('admin/catalog/categories/addrootcategory');
   		if(!$canAdd)
   		{
   			$options = $observer->getOptions();
   			$options->setIsAllow($canAdd);
   			
   			$catId = Mage_Catalog_Model_Category::TREE_ROOT_ID;
   			$categroies = Mage::getModel('catalog/category')->load(Mage_Catalog_Model_Category::TREE_ROOT_ID);
   			$categroies = $categroies->getCategories(Mage_Catalog_Model_Category::TREE_ROOT_ID,1);
   			$catId = 0;
   			foreach($categroies as $cat)
   			{
   				$catId = $cat->getId();
   				continue;
   			}

   			$options = new Varien_Object(array('category_id' => $catId));
   			Mage::dispatchEvent('adminhtml_catalog_category_tree_can_not_add_root_category',array('options' => $options));
   		
   			$catId = $options->getCategoryId();
   			$cat = Mage::getModel('catalog/category')->load($options->getCategoryId());
   			Mage::unregister('category');
   			Mage::register('category', $cat);
   			
   		}
   }
   
 	public function onCategoryCanAddSub($observer)
   {
   		$canAdd = Mage::getSingleton('admin/session')->isAllowed('admin/catalog/categories/addcategory');
   		$options = $observer->getOptions();
   		$options->setIsAllow($canAdd);
   }
   
   public function onControllerActionDispatch($observer)
   {
   		$acl = Mage::getSingleton('acl/productacl');
   		$controller_action = $observer->getControllerAction();
   		/* @var $request Mage_Core_Controller_Request_Http */
   		$request = $controller_action->getRequest();
   		$controller = $request->getControllerName();
   		$action = $request->getActionName();
   		
   		$path = $acl->getPermissionPath($controller,$action);
   		if($path !== false)
   		{
   			$allow = $acl->testPermission($path);
   			if(!$allow)
   			{
   				die("Access denied!");
   			}
   		}
   		
   		
   		
   }
   
   
   
	
}
