<?php
/**
 *  Persistenzklasse für ConfigCompare
 *  @category B3it
 *  @package  B3it_ConfigCompare
 *  @author Holger Kögel <​h.koegel@b3-it.de>
 *  @copyright Copyright (c) 2014 B3 IT Systeme GmbH
 *  @license ​http://sid.sachsen.de OpenSource@SID.SACHSEN.DE
 */ 


class B3it_ConfigCompare_Model_TaxCalculations extends B3it_ConfigCompare_Model_Compare
{
	
	//protected $_attributesCompare  = array('tax_country_id', 'tax_region_id', 'tax_postcode', 'rate', 'zip_is_range', 'zip_from', 'zip_to', 'code', 'priority', 'position', 'calculate_subtotal', 'customer_group', 'product');
	//protected $_attributesExport  = array('tax_country_id', 'tax_region_id', 'tax_postcode', 'rate', 'zip_is_range', 'zip_from', 'zip_to', 'code', 'priority', 'position', 'calculate_subtotal', 'customer_group', 'product');
    
	protected $_attributesExcludeExport  = array('tax_calculation_id', 'tax_calculation_rate_id', 'tax_calculation_rule_id', 'customer_tax_class_id', 'product_tax_class_id', 'tax_calculation_rate_id');
	protected $_attributesExcludeCompare  = array('tax_calculation_id', 'tax_calculation_rate_id', 'tax_calculation_rule_id', 'customer_tax_class_id', 'product_tax_class_id', 'tax_calculation_rate_id');
	
	
	public function getCollection()
	{
		/**
		 * SELECT 
				    `main_table`.*,
				    `rate`.*,
				    `rule`.`code` AS `rule_name`,
				    GROUP_CONCAT(CONCAT(rate.tax_country_id, '_', rate.rate)) AS `rate`,
				    GROUP_CONCAT(cgroup.class_name) AS `customer_group`,
				    GROUP_CONCAT(product.class_name) AS `product`,
				    CONCAT(MD5(rule.code),
				            '_',
				            MD5(CONCAT(rate.tax_country_id, '_', rate.rate)),
				            '_',
				            MD5(GROUP_CONCAT(cgroup.class_name)),
				            '_',
				            MD5(GROUP_CONCAT(product.class_name))) AS `ident`,
				    CONCAT(rule.code,
				            '__',
				            CONCAT(rate.tax_country_id, '_', rate.rate),
				            '__',
				            GROUP_CONCAT(cgroup.class_name),
				            '__',
				            GROUP_CONCAT(product.class_name)) AS `ident_hr`
				FROM
				    `tax_calculation` AS `main_table`
				        INNER JOIN
				    `tax_calculation_rate` AS `rate` ON main_table.tax_calculation_rate_id = rate.tax_calculation_rate_id
				        INNER JOIN
				    `tax_calculation_rule` AS `rule` ON main_table.tax_calculation_rule_id = rule.tax_calculation_rule_id
				        INNER JOIN
				    `tax_class` AS `cgroup` ON main_table.customer_tax_class_id = cgroup.class_id
				        INNER JOIN
				    `tax_class` AS `product` ON main_table.product_tax_class_id = product.class_id
				where `rule`.`tax_calculation_rule_id` = 15
				GROUP BY `rule`.`tax_calculation_rule_id`

		 * 
		 */
		$collection = Mage::getModel('tax/calculation')->getCollection();
		$collection->getSelect()
			->join(array('rate'=>$collection->getTable('tax/tax_calculation_rate')),'main_table.tax_calculation_rate_id = rate.tax_calculation_rate_id',array())
			->join(array('rule'=>$collection->getTable('tax/tax_calculation_rule')),'main_table.tax_calculation_rule_id = rule.tax_calculation_rule_id',array('rule_name'=>'code'))
			->join(array('cgroup'=>$collection->getTable('tax/tax_class')),'main_table.customer_tax_class_id = cgroup.class_id',array())
			->join(array('product'=>$collection->getTable('tax/tax_class')),'main_table.product_tax_class_id = product.class_id',array())
			->columns(array('Rate' => new Zend_Db_Expr('GROUP_CONCAT(DISTINCT CONCAT(rate.code, \'_\',rate.tax_country_id, \'_\', rate.rate) ORDER BY rate.code)')))
			->columns(array('CustomerGroupClass' => new Zend_Db_Expr('GROUP_CONCAT(distinct cgroup.class_name ORDER BY cgroup.class_name)')))
			->columns(array('ProductClass' => new Zend_Db_Expr('GROUP_CONCAT(distinct product.class_name ORDER BY product.class_name)')))
			//->columns(array('ident' => new Zend_Db_Expr('concat(md5(GROUP_CONCAT(CONCAT(rate.code, \'_\',rate.tax_country_id, \'_\', rate.rate) ORDER BY rate.code)),\'_\' ,md5(rule.code),\'_\' ,md5(GROUP_CONCAT(cgroup.class_name ORDER BY cgroup.class_name)),\'_\',md5(GROUP_CONCAT(product.class_name ORDER BY product.class_name)))')))
			->columns(array('ident' => new Zend_Db_Expr('md5(rule.code)')))
			//->columns(array('ident_hr' => new Zend_Db_Expr('concat(GROUP_CONCAT(CONCAT(rate.code, \'_\',rate.tax_country_id, \'_\', rate.rate) ORDER BY rate.code),\'__\',rule.code,\'__\' ,GROUP_CONCAT(cgroup.class_name ORDER BY cgroup.class_name),\'__\',GROUP_CONCAT(product.class_name ORDER BY product.class_name))')))
			->group(array('rule.tax_calculation_rule_id'))
		;
		
			
			
			
	//die($collection->getSelect()->__toString());
		return $collection;
	}
    
    public function getCollectionDiff($importXML)
    {
    	$this->_collection  =  $this->getCollection();
    	if($importXML)
    	{
    		$notFound = array();
    		$this->_collectionArray = $this->_collection->toArray();
    		foreach($importXML as $xmlItem){
    			$item = simplexml_load_string($xmlItem->getValue());
    			$key = $this->__findInCollection((string)$item->ident);
    			if($key !== null){
    				//$diff = $this->_compareDiff($this->_collectionArray['items'][$key]['code'], (string)$item->code);
    				$diff3 = $this->_getAttributeDiff($this->_collectionArray['items'][$key], (array)$item);
    				if(($diff3 === true)) {
    					unset($this->_collectionArray['items'][$key]);
    				}else{
    					
    					
    					if($diff3 !== true){
    						$this->_collectionArray['items'][$key]['attribute'] = $diff3;
    					}
    				}
    			} else {
    				//not found = die jenigen die in der Datei aber nicht in DB vorhanden sind
	    			$notFound[] = $item;
	    		}
    		}
    	
	    	
	    	$this->_collection = Mage::getModel('configcompare/coreConfigData')->getCollection();
	    	foreach($this->_collectionArray['items'] as $item){
	    		$this->_collection->add($item);
	    	}
	    	foreach($notFound as $item){
	    		$item = (array)$item;
	    		$item['attribute'] =  $this->_getAttributeDiff(array(), $item);
	    		$this->_collection->add($item);
	    	}
	    	$this->_collection->setIsLoaded();
    	}
    	return $this->_collection;
    	
    }

    

    
    private function __findInCollection($code){
    	//return null;
    	foreach($this->_collectionArray['items'] as $key => $item){
    		if($item['ident'] == $code){
    				return $key;

    		}
    	}
    	return null;
    }
    
}