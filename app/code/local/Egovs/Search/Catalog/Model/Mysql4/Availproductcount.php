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
 * Product collection
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Egovs_Search_Catalog_Model_Mysql4_Availproductcount
    extends Mage_Catalog_Model_Resource_Eav_Mysql4_Product_Collection
{
   
	public function getCount($attribute, $entitySelect)
	{
		$select = clone $entitySelect;
        $select->reset(Zend_Db_Select::COLUMNS);
        $select->reset(Zend_Db_Select::ORDER);
        $select->reset(Zend_Db_Select::LIMIT_COUNT);
        $select->reset(Zend_Db_Select::LIMIT_OFFSET);

        $select->from('',array('anzahl'=>'count(distinct(e.entity_id))'));
        //$select->from('', array('count'=>'COUNT(index.entity_id)', 'index.value'));
        //$select->join(array('index'=>'catalogindex_eav'), 'index.entity_id=e.entity_id', array());
        $select->join(array('stock'=>'cataloginventory_stock_status'),'e.entity_id = stock.product_id',array());
	        
        //$select->where('index.store_id = ?', $this->getStoreId());
        $select->where('stock.stock_status = 1');
        //$select->where('e.entity_id in (SELECT product FROM cataloginventory_stock_item_parent_merged group by product)');

        $res = $this->getConnection()->fetchAll($select);
        if((count($res)>0) && (isset($res[0]['anzahl']))) return (int)$res[0]['anzahl']; 
        
        return 0;
	}
	
  
    /**
     * Retreive count for available products
     *
     * @return array count for available/notavailable products
     */
    public function getProductCountAvailArray()
    {
    	$result = array('all'=>0,'avail'=>0,'notavail'=>0);
    	//return $result;
    	
    	$select = clone $this->getSelect();
    	$select->reset(Zend_Db_Select::ORDER);
        $select->reset(Zend_Db_Select::LIMIT_COUNT);
        $select->reset(Zend_Db_Select::LIMIT_OFFSET);
        $select->reset(Zend_Db_Select::COLUMNS);
        $select->reset(Zend_Db_Select::FROM);
        
        $hideattribute = clone $select;
        $hideattribute->from('eav_attribute','attribute_id');
        $hideattribute->where("eav_attribute.attribute_code='groupscatalog_hide_group'");
        $hideattribute->where("entity_type_id='4'");
        
        $hideattribute = $this->getConnection()->fetchAll($hideattribute);
        if(count($hideattribute) > 0)
        {
	        $hideattribute = $hideattribute[0]['attribute_id'];
	        //$select->distinct(true);
	        $select->from(array('e'=>'catalog_product_entity'),array('anzahl'=>'count(distinct(e.entity_id))'));
	        $select->join(array('stock'=>'cataloginventory_stock_item'),'e.entity_id = stock.product_id',array());
	        $select->join(array('cat_index'=>'catalog_category_product_index'),"cat_index.product_id=e.entity_id AND cat_index.store_id='1' AND cat_index.visibility IN(2, 4)",array());
	        $select->joinleft(array('_groupscatalog_hide_group_table'=>'catalog_product_entity_varchar'),"e.entity_id=_groupscatalog_hide_group_table.entity_id AND _groupscatalog_hide_group_table.attribute_id=$hideattribute",array()) ;
	        $select->where("(IFNULL(_groupscatalog_hide_group_table.value, -2) = '-2' OR ( IFNULL(_groupscatalog_hide_group_table.value, -2) != '0' AND (IFNULL(_groupscatalog_hide_group_table.value, -2) not like '0,%'
 						AND IFNULL(_groupscatalog_hide_group_table.value, -2) not like '%,0' AND IFNULL(_groupscatalog_hide_group_table.value, -2) not like '%,0,%')))");
	        $out = clone $select;
	        
	        $select->where('stock.qty > stock.min_qty');
	        $res = $this->getConnection()->fetchAll($select);
	        if((count($res)>0) && (isset($res[0]['anzahl']))) $result['avail'] = (int)$res[0]['anzahl'];  
	        
	       //	$out->where('stock.qty = 0');
	       // $res = $this->getConnection()->fetchAll($out);
	       // if((count($res)>0) && (isset($res[0]['anzahl']))) $result['notavail'] = (int)$res[0]['anzahl'];  
	        
        }
        /*
        SELECT COUNT(DISTINCT e.entity_id) FROM `catalog_product_entity` AS `e`
Inner Join cataloginventory_stock_item s on e.entity_id = s.product_id 
INNER JOIN `catalog_category_product_index` AS `cat_index` ON cat_index.product_id=e.entity_id AND cat_index.store_id='1' AND cat_index.visibility IN(2, 4) 
 LEFT JOIN `catalog_product_entity_varchar` AS `_groupscatalog_hide_group_table` ON e.entity_id=_groupscatalog_hide_group_table.entity_id
 AND _groupscatalog_hide_group_table.attribute_id=(SELECT `eav_attribute`.attribute_id FROM `eav_attribute` WHERE (eav_attribute.attribute_code='groupscatalog_hide_group') AND (entity_type_id='4')
)
 WHERE (IFNULL(_groupscatalog_hide_group_table.value, -2) = '-2' OR ( IFNULL(_groupscatalog_hide_group_table.value, -2) != '0' AND (IFNULL(_groupscatalog_hide_group_table.value, -2) not like '0,%'
 AND IFNULL(_groupscatalog_hide_group_table.value, -2) not like '%,0' AND IFNULL(_groupscatalog_hide_group_table.value, -2) not like '%,0,%'))) and s.qty>0

         */
        
        $result['all'] = $result['notavail'] + $result['avail'];
        
        return $result;
    }

 
}
