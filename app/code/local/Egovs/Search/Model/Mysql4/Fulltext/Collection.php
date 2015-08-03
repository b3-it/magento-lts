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
 * @copyright  Copyright (c)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


class Egovs_Search_Model_Mysql4_Fulltext_Collection
    extends Mage_CatalogSearch_Model_Mysql4_Fulltext_Collection
{
    
	private $_qtyApplied = false;
	
	
	
	
	/**
     * Add search query filter
     *
     * @param   Mage_CatalogSearch_Model_Query $query
     * @return  Mage_CatalogSearch_Model_Mysql4_Search_Collection
     */
    public function addSearchFilter($query)
    {
    	$query = Mage::helper('egovssearch')->htmlEntityDecode($query);

    	
    	Mage::getSingleton('catalogsearch/fulltext')->prepareResult();
       
        $this->getSelect()
        ->distinct('e.entity_id')
        ->joinLeft(array('search_result' => $this->getTable('catalogsearch/result')),'search_result.product_id=e.entity_id',array('relevance' => 'relevance'))
        //->where($this->getConnection()->quoteInto('search_result.query_id=?',$this->_getQuery()->getId()))
        ;
        
        
        
        //!!klammer für Suche nach soundex und search_result.query_id
        if(strlen(metaphone($query))>2)
        {
        	$exp  = "(soundex_result.product_id=e.entity_id AND ";
        	$exp .= "(". $this->getConnection()->quoteInto('soundex_result.soundex like ?','%'.metaphone($query));
        	$exp .= " OR ". $this->getConnection()->quoteInto('soundex_result.soundex like ?',metaphone($query).'%')."))";
        	$SoundExpr = new Zend_Db_Expr($exp);
        	
        	
        	
        	$exp = $this->getConnection()->quoteInto('search_result.query_id=?',$this->_getQuery()->getId());
        	$exp = new Zend_Db_Expr($exp);	
        	
        	$SoundExpr = 
        	
        	$this->getSelect()
        		->joinLeft(array('soundex_result' => $this->getTable('egovssearch/soundex')),$SoundExpr, array())
        		//->orWhere($this->getConnection()->quoteInto('soundex_result.soundex like ?','%'.metaphone($query).'%'))
        		->where($exp)
        		;
        	
        } 
        else
        {
        	$this->getSelect()
        		->where($this->getConnection()->quoteInto('search_result.query_id=?',$this->_getQuery()->getId()));
        }  
        
        
        $this->getSelect()
    		->joinLeft( array('best' => 'sales_flat_order_item'), 'best.product_id=e.entity_id', array('ordered_qty' => 'sum(qty_ordered)'))
    		->group('e.entity_id');
    		//->order('ordered_qty ' . $dir);
        
//die( $this->getSelect()->__toString());
        return $this;
    }

   	public function addAvailProductFilter($availStatus)
    {
        $this->_productLimitationFilters['avial'] = $availStatus;
		$this->_applyProductAvail();
        return $this;
    }
	
    
	public function getSelectCountSql()
    {
        $countSelect = clone $this->getSelect();
        $countSelect->reset(Zend_Db_Select::ORDER);
        $countSelect->reset(Zend_Db_Select::LIMIT_COUNT);
        $countSelect->reset(Zend_Db_Select::LIMIT_OFFSET);
        $countSelect->reset(Zend_Db_Select::COLUMNS);
        $countSelect->reset(Zend_Db_Select::DISTINCT);

        $countSelect->from('', 'COUNT(*)');
        //die( $countSelect->__toString());
        $count2 = new Zend_Db_Select($countSelect->getAdapter());
        $count2->from($countSelect, 'COUNT(*)');
        return $count2;
    }
    
    
    /**
     * Set Order field
     *
     * @param string $attribute
     * @param string $dir
     * @return Mage_CatalogSearch_Model_Mysql4_Fulltext_Collection
     */
    public function setOrder($attribute, $dir='desc')
    {
        if ($attribute == 'relevance') {
            //$this->getSelect()->order("relevance {$dir}");
        }
     	else if ($attribute == 'ordered_qty') {
            $this->getSelect()->order("ordered_qty {$dir}");
        }
        else {
            parent::setOrder($attribute, $dir);
        }
        return $this;
    }
    
    
     protected function _applyProductAvail()
     {
     	parent::_applyProductLimitations();
     	if( isset($this->_productLimitationFilters['avial']))
     	{
	     	if(($this->_qtyApplied === false) && ($this->_productLimitationFilters['avial']=='instock'))
	     	{
		     	$select = $this->getSelect();
			    $select->join(array('stock'=>'cataloginventory_stock_status'),'e.entity_id = stock.product_id AND stock.stock_status = 1',array());        
	     	}
	     	$this->_qtyApplied = true; 
     	}
    //die($select->__toString()); 	
     	return $this;
     }
}
