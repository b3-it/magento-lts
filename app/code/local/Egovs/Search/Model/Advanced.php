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
 * @category   Egovs
 * @package    Egovs_Search
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Catalog advanced search model, verf�gbare produkte
 *
 * @category   Egovs
 * @package    Egovs_Search
 */
class Egovs_Search_Model_Advanced  extends Mage_CatalogSearch_Model_Advanced
{
   private $_prefiltercount = 0;

    /**
     * Add advanced search filters to product collection
     *
     * @param   array $values
     * @return  Mage_CatalogSearch_Model_Advanced
     */
	public function addFilters($values)
	{
		//sanitize
		$values = $this->_sanitizeValues($values);
		$avail = null;
		if(isset($values['search_available_in_stock'])) 
		{
			if($values['search_available_in_stock'] == 'instock') 
			{
				$avail = $values['search_available_in_stock'];	
				$this->_prefiltercount +=1;
				$attributes = $this->getAttributes();
				foreach ($attributes as $attribute) 
				{
            		if($attribute->getAttributeCode() == 'search_available_in_stock')
            		{
            			//für die Anzeige der Suchkriterien
						$this->_addSearchCriteria($attribute, 'instock');
            		}
				}
			}
			$values['search_available_in_stock'] = '';
		}
		
		$cat = null;
		if(isset($values['product_category_search']))
		{
			$cat = $values['product_category_search'];
			unset( $values['product_category_search']);
			if(!is_array($cat))
			{
				if(strlen($cat) == 0)
				{
					$cat = null;
					//return $this;
				}
				else
				{
					$cat = array($cat); 
				}
			}
			//das attribut finden
			$att = null;
			if($cat != null)
			{
				$attributes = $this->getAttributes();
				foreach ($attributes as $attribute) 
				{
	            	if($attribute->getAttributeCode() == 'product_category_search')
	            	{
						$att = $attribute;
	            	}
				}
				
				if($att != null)
				{
					$this->_prefiltercount +=1;
					foreach($cat as $c)
					{
						$this->_addSearchCriteria($att, $c);
					}
				}
			}
			
		}
		
		//parent::addFilters($values);
		$this->_addFilters($values);
		$this->getProductCollection()->addAvailProductFilter($avail);
		if($cat != null)$this->getProductCollection()->addCategoryByIdFilter($cat);
		
		return $this;
	}
	
    /**
     * Add advanced search filters to product collection
     *
     * @param   array $values
     * @return  Mage_CatalogSearch_Model_Advanced
     */
    private function _addFilters($values)
    {
    	//sanitize
    	$values = $this->_sanitizeValues($values);
    	
        $attributes = $this->getAttributes();
        $allConditions = array();
        $filteredAttributes = array();
        $indexFilters = Mage::getModel('catalogindex/indexer')->buildEntityFilter(
            $attributes,
            $values,
            $filteredAttributes,
            $this->getProductCollection()
        );

        foreach ($indexFilters as $filter) {
            $this->getProductCollection()->addFieldToFilter('entity_id', array('in'=>new Zend_Db_Expr($filter)));
        }

        $priceFilters = Mage::getModel('catalogindex/indexer')->buildEntityPriceFilter(
            $attributes,
            $values,
            $filteredAttributes,
            $this->getProductCollection()
        );

        foreach ($priceFilters as $code=>$filter) {
            $this->getProductCollection()->getSelect()->joinInner(
                array("_price_filter_{$code}"=>$filter),
                "`_price_filter_{$code}`.`entity_id` = `e`.`entity_id`",
                array()
            );
        }

        foreach ($attributes as $attribute) {
            $code      = $attribute->getAttributeCode();
            $condition = false;

            if (isset($values[$code])) {
                $value = $values[$code];

                if (is_array($value)) {
                    if ((isset($value['from']) && strlen($value['from']) > 0)
                        || (isset($value['to']) && strlen($value['to']) > 0)) {
                        $condition = $value;
                    }
                    elseif ($attribute->getBackend()->getType() == 'varchar') {
                        $condition = array('in_set'=>$value);
                    }
                    elseif (!isset($value['from']) && !isset($value['to'])) {
                        $condition = array('in'=>$value);
                    }
                } else {
                    if (strlen($value)>0) {
                        if (in_array($attribute->getBackend()->getType(), array('varchar', 'text'))) {
                            $condition = array('like'=>'%'.$value.'%');
                        } elseif ($attribute->getFrontendInput() == 'boolean') {
                            $condition = array('in' => array('0','1'));
                        } else {
                            $condition = $value;
                        }
                    }
                }
            }

            if (false !== $condition) {
                $this->_addSearchCriteria($attribute, $value);

                if (in_array($code, $filteredAttributes))
                    continue;

                $table = $attribute->getBackend()->getTable();
                $attributeId = $attribute->getId();
                if ($attribute->getBackendType() == 'static'){
                    $attributeId = $attribute->getAttributeCode();
                    $condition = array('like'=>"%{$condition}%");
                }

                $allConditions[$table][$attributeId] = $condition;
            }
        }
        if ($allConditions) {
            $this->getProductCollection()->addFieldsToFilter($allConditions);
        } else if ((count($filteredAttributes)+$this->_prefiltercount) == 0) {
            Mage::throwException(Mage::helper('catalogsearch')->__('You have to specify at least one search term'));
        }

        return $this;
    }
  
    
    private function _sanitizeValues($values)
    {
    	//sanitize
    	$conn = Mage::getSingleton('core/resource')->getConnection('default_write');
    	foreach($values as $k=>$v)
    	{
    		if(isset($values[$k]))
    			if(is_array($values[$k]))
    			{
    				$values[$k] = $this->_sanitizeValues($values[$k]);
    			}
    			else if(strlen($v) > 0)
    			{
    				$values[$k] = $conn->quote($v);
    				$values[$k] = trim($values[$k],"'");
    			}
    	}
    	
    	return $values;
    }
    
}
