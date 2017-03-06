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
		$collection = Mage::getModel('tax/calculation')->getCollection();
		$collection->getSelect()
			->join(array('rate'=>$collection->getTable('tax/tax_calculation_rate')),'main_table.tax_calculation_rate_id = rate.tax_calculation_rate_id')
			->join(array('rule'=>$collection->getTable('tax/tax_calculation_rule')),'main_table.tax_calculation_rule_id = rule.tax_calculation_rule_id',array())
			->join(array('group'=>$collection->getTable('tax/tax_class')),'main_table.customer_tax_class_id = group.class_id',array('customer_group'=>'class_name'))
			->join(array('product'=>$collection->getTable('tax/tax_class')),'main_table.product_tax_class_id = product.class_id',array('product'=>'class_name'))
			->columns(array('rate' => new Zend_Db_Expr('group_concat(concat(rate.tax_country_id,\'_\',rate.rate))')))
			->columns(array('ident' => new Zend_Db_Expr('concat(md5(rule.code),\'_\' ,md5(group.class_name),\'_\',md5(product.class_name))')))
			->group(array('rule.tax_calculation_rule_id', 'main_table.customer_tax_class_id', 'main_table.product_tax_class_id'))
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
	    			$notFound[] = $item;
	    		}
    		}
    	
	    	
	    	$this->_collection = Mage::getModel('configcompare/coreConfigData')->getCollection();
	    	foreach($this->_collectionArray['items'] as $item){
	    		$this->_collection->add($item);
	    	}
	    	foreach($notFound as $item){
	    		$this->_collection->add((array)$item);
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