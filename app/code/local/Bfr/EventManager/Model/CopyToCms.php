<?php
/**
 * Bfr EventManager
 *
 *
 * @category   	Bfr
 * @package    	Bfr_EventManager
 * @name       	Bfr_EventManager_Model_CopyToCms
 * @author 		Holger Kögel <h.koegel@b3-it.de>
 * @copyright  	Copyright (c) 2015 B3 It Systeme GmbH - http://www.b3-it.de
 * @license		http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */
class Bfr_EventManager_Model_CopyToCms extends Varien_Object
{
  	protected $_layout = null;
   public function createCmsBlock($data) {
       $event = Mage::getModel('eventmanager/event')->load(intval($data['event_id']));
       //$product = Mage::getModel('catalog/product')->load($event->getProductId());
       $store_id = intval($data['store_id']);


       $viewHelper = Mage::helper('eventmanager/product_view');

       $content = $viewHelper->prepareAndRender($event->getProductId(), $store_id);

       //die($content);

       /** @var $block Mage_Cms_Model_Block */
       $block = Mage::getModel('cms/block');
       $block->setContent($content);
       $block->setTitle($data['title']);
       $block->setIdentifier($data['identifier']);
       $block->setCreationTime(now());
       $block->setUpdateTime(now());
       $block->setIsActive(1);
       $block->setStores(array($store_id));

       $block->save();


       if (isset($data['new_category']))
       {
           $category = Mage::getModel('catalog/category');
           $category->setName($data['category']);
           //$category->setUrlKey('new-category');
           $category->setIsActive(1);
           $category->setDisplayMode(Mage_Catalog_Model_Category::DM_PAGE);
           $category->setIsAnchor(1); //for active achor
           $category->setLandingPage($block->getId());
           //$category->setStoreId(Mage::app()->getStore()->getId());
           $parentCategory = Mage::getModel('catalog/category')->load($data['parent_category']);
           $category->setPath($parentCategory->getPath());
           $category->save();
       }else {
           $category = Mage::getModel('catalog/category')->load($data['parent_category']);

           $category->setDisplayMode(Mage_Catalog_Model_Category::DM_PAGE);
           $category->setIsAnchor(1); //for active achor
           $category->setLandingPage($block->getId());
           $category->setStoreId($store_id);
           $category->save();
       }


   		return $block;
   }
   
 
}
