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
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2009 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog layered navigation view block
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Search_Catalog_Block_Layer_View extends Mage_CatalogSearch_Block_Layer
{

	
 protected function _prepareLayout()
    {
        $stateBlock = $this->getLayout()->createBlock('catalog/layer_state')
            ->setLayer($this->getLayer());

        $categryBlock = $this->getLayout()->createBlock('catalog/layer_filter_category')
            ->setLayer($this->getLayer())
            ->init();
            
        $availBlock = $this->getLayout()->createBlock('searchcatalog/layer_filter_avail')
            ->setLayer($this->getLayer())
            ->init();

        $this->setChild('layer_state', $stateBlock);
        $this->setChild('category_filter', $categryBlock);
        $this->setChild('avail_filter', $availBlock);

        $filterableAttributes = $this->_getFilterableAttributes();
        foreach ($filterableAttributes as $attribute) {
            $filterBlockName = 'catalog/layer_filter_attribute';
            if ($attribute->getFrontendInput() == 'price') {
                $filterBlockName = 'catalog/layer_filter_price';
            }

            $this->setChild($attribute->getAttributeCode().'_filter',
                $this->getLayout()->createBlock($filterBlockName)
                    ->setLayer($this->getLayer())
                    ->setAttributeModel($attribute)
                    ->init());
        }

        $this->getLayer()->apply();
        return Mage_Core_Block_Template::_prepareLayout();
    }
	
	
    /**
     * Get all layer filters
     *
     * @return array
     */
    public function getFilters()
    {
    	
        $filters = array();
        if ($categoryFilter = $this->_getCategoryFilter()) {
            $filters[] = $categoryFilter;
        }
        
        if ($availFilter = $this->_getAvailFilter()) {
            $filters[] = $availFilter;
        }

        $filterableAttributes = $this->_getFilterableAttributes();
        foreach ($filterableAttributes as $attribute) {
            $filters[] = $this->getChild($attribute->getAttributeCode().'_filter');
        }

        return $filters;
    }
    
    
    protected function _getAvailFilter()
    {
        return $this->getChild('avail_filter');
    }
}
