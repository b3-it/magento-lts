<?php
class Egovs_Base_Block_Catalog_Category_Widget_General extends Egovs_Base_Block_Catalog_Category_Widget_Widget
{
    protected $_description = null;

    protected $_name = null;

    public function getDescription() {
    	if (!$this->_description && $this->_entityResource) {
    		if (!$this->getData('description')) {
    			$idPath = explode('/', $this->getIdPath());
    			if (isset($idPath[1])) {
    				$id = $idPath[1];
    				if ($id) {
    					$category = Mage::getModel('catalog/category')->setStoreId(Mage::app()->getStore()->getId())->load($id);
    					if ($category->getId() && $category->getIsActive() && $_description = $category->getDescription()) {
    					    $this->_description = $this->helper('catalog/output')->categoryAttribute($category, $_description, 'description');
    					}
    				}
    			}
    		} else {
    			$this->_description = $this->getData('description');
    		}
    	}

    	return $this->_description;
    }

    public function getName() {
    	if (!$this->_name && $this->_entityResource) {
    		if (!$this->getData('name')) {
    			$idPath = explode('/', $this->getIdPath());
    			if (isset($idPath[1])) {
    				$id = $idPath[1];
    				if ($id) {
    					$category = Mage::getModel('catalog/category')->setStoreId(Mage::app()->getStore()->getId())->load($id);
    					if ($category->getId() && $category->getIsActive() && $_name = $category->getName()) {
    						$this->_name = $this->helper('catalog/output')->categoryAttribute($category, $_name, 'name');
    					}
    				}
    			}
    		} else {
    			$this->_name = $this->getData('name');
    		}
    	}

    	return $this->_name;
    }
}
