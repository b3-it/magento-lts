<?php

class Egovs_Search_Model_Mysql4_Soundex_Collection extends Mage_Core_Model_Mysql4_Collection_Abstract
{
	private $_searchableAttributes = null;
	private $_phonetic = null;
	
	
    public function _construct()
    {    
        $this->_init('egovssearch/soundex');
        //$this->_phonetic = Mage::helper('egovssearch/colognephon');
    }
    
    public function addProduct($product, $storeid)
    {
    	$this->removeProductById($product->getId(),$storeid);
    	//$this->add('name',$product,$storeid);
    	//$this->add('sku',$product,$storeid);
    	$searchData = $this->_getSearchableAttributes(array('varchar','text'));
    	foreach($searchData as $search)
    	{
    		$this->add($search->getData('attribute_code'),$product,$storeid);
    	}
    	//$this->add('description',$product,$storeid);
    	//$this->add('short_description',$product,$storeid);
    }
    
    public function add($attribute, $product, $storeid)
    {
    	$productid = $product->getId();
    	$value = $product->getData($attribute);
    	if(($value != null)  && (strlen($value)>1))
    	{
	    	$phone = $this->flat($value);
	    	if(strlen($phone)>2){
	    		$sql = "insert into ".$this->getTable('egovssearch/soundex')." (product_id,store_id,soundex) VALUES (";
		    	$sql .= $productid . "," . $storeid .",'". $phone ."')";
		    	$result = $this->_conn->query($sql);
	    	}
	    	
	    	$search  = array('ä', 'ü', 'ö',);
			$replace = array('ae', 'ue', 'oe');
			$umschrift = str_ireplace($search,$replace,$value);
			if($umschrift != $value)
			{
				$phone = $this->flat($umschrift);
		    	if(strlen($phone)>2){
		    		$sql = "insert into ".$this->getTable('egovssearch/soundex')." (product_id,store_id,soundex) VALUES (";
			    	$sql .= $productid . "," . $storeid .",'". $phone ."')";
			    	$result = $this->_conn->query($sql);
		    	}
			}
    	}
    }
    
    
   protected function _getSearchableAttributes($backendType = null)
    {
        if (is_null($this->_searchableAttributes)) {
            $this->_searchableAttributes = array();

            $entityType   = $this->getEavConfig()->getEntityType(Mage_Catalog_Model_Product::ENTITY);
            $entity       = $entityType->getEntity();

            $productAttributeCollection = Mage::getResourceModel('catalog/product_attribute_collection')
                ->setEntityTypeFilter($entityType->getEntityTypeId());
            $productAttributeCollection->addSearchableAttributeFilter();
            
            $attributes = $productAttributeCollection->getItems();

            foreach ($attributes as $attribute) {
                $attribute->setEntity($entity);
                $this->_searchableAttributes[$attribute->getId()] = $attribute;
            }
        }
        /*
        if (!is_null($backendType)) {
            $attributes = array();
            foreach ($this->_searchableAttributes as $attribute) {
                if ($attribute->getBackendType() == $backendType) {
                    $attributes[$attribute->getId()] = $attribute;
                }
            }

            return $attributes;
        }
        */
        return $attributes;
        
    }
    
    
    public function flat($value)
    {
    	$value = trim($value);
    	if(strlen($value)==0) return '';
    	$res = '';
    	$value = preg_split("/,|;|[\s,]+/",$value);
    	if(($value != null) && (is_array($value)))
    	{
    		foreach ($value as $s)
    		{
    			$s = metaphone(trim($s));
    			//if(strlen($s)>2)$res .= $this->_phonetic->germanphonetic($s)." ";
    			if(strlen($s)>2)$res .= $s." ";
    		} 
    	}
    	
    	if(strlen($res) > 50) $res = substr($res,0,50);
    	return $res;
    }
    
    public function removeProductById($id, $storeid = null)
    {
    	if(($id+0) > 0)
     	{
	     	$sql = "delete from ". $this->getTable('egovssearch/soundex');
	     	$sql .= " where product_id=".$id;
	     	if($storeid != null) $sql .= " AND store_id=". $storeid;
	     	//$select = $this->getSelect();
	     	$result = $this->_conn->query($sql);
			
     	}
    }
    
    public function removeAllProducts()
    {
    	if(($id+0) > 0)
     	{
	     	$sql = "delete from ". $this->getTable('egovssearch/soundex');
	     	
	     	$result = $this->_conn->query($sql);
			
     	}
    }
    
    
    public function rebuild()
    {
    	$this->removeAllProducts();
    	$collection = Mage::getResourceModel('catalog/product_collection')->load();
    	foreach($collection->getItems() as $product)
    	{
    		
    	}
    }
    
    
    public function getStoreId()
    {
        return Mage::app()->getStore()->getId();
    }
    
 	private function getEavConfig()
    {
        return Mage::getSingleton('eav/config');
    }
}