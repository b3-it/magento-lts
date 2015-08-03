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
 * @category   Egovs
 * @package    Egovs_Search
 * @copyright  Copyright (c) 2009
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */
class Egovs_Search_Model_Config_Source_Category
	extends Mage_Eav_Model_Entity_Attribute_Source_Abstract
{
 
  public function getOptionText($value)
    {
    	return Mage::getModel('catalog/category')->load($value)->getName();
    }

    public function toOptionArray()
    {
    	$id = Mage::app()->getStore()->getRootCategoryId();
    	$rootId = Mage_Catalog_Model_Category::TREE_ROOT_ID;
    	$storeid = Mage::app()->getStore()->getStoreId();
    	$collection = Mage::getModel('catalog/category')->getCollection();
    	$collection->addAttributeToSelect('name')
                //->addAttributeToSelect('is_active')
                ->addIsActiveFilter()
                ->setStoreId($storeid)
                ->addPathsFilter($rootId . '/'. $id .'/')
                //->setRootCategoryId($id)
                ->load();

    
                
                
                
    	$res = array();
    	foreach($collection->getItems() as $item)
    	{
    		if($item->getData('level')+0 > 1)
    		{
    			$res[] = array('value'=>$item->getData('entity_id'),'label'=>$item->getData('name'));
    		}
    	}
        return $res;
    }
    
    public function getAllOptions()
    {
    	return $this->toOptionArray();
    }
    

}